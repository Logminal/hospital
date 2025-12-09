<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $specialties = Specialty::all();

        // Получаем фильтр по специальности из запроса
        $specialtyFilter = $request->input('specialty');
        $searchQuery = $request->input('search');

        // Базовый запрос врачей - только активные
        $doctorsQuery = Doctor::with('specialty')->where('is_active', true);

        // Применяем фильтр по специальности, если указан
        if ($specialtyFilter && $specialtyFilter !== 'all') {
            $doctorsQuery->where('specialty_id', $specialtyFilter);
        }

        // Применяем поиск по имени, если указан
        if ($searchQuery) {
            $doctorsQuery->where('name', 'like', '%' . $searchQuery . '%');
        }

        $doctors = $doctorsQuery->get();

        return view('appointments.index', [
            'specialties' => $specialties,
            'doctors' => $doctors,
            'selectedSpecialty' => $specialtyFilter ?? 'all',
            'searchQuery' => $searchQuery ?? '',
        ]);
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('specialty');

        return view('appointments.show', [
            'doctor' => $doctor,
        ]);
    }

    public function checkAvailability(Request $request)
    {
        try {
            $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'date' => 'required|date|after_or_equal:today',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Ошибка валидации',
                'messages' => $e->errors(),
            ], 422);
        }

        $doctorId = $request->input('doctor_id');
        $date = $request->input('date');

        try {
            // Получаем все занятые времена для данного врача на указанную дату
            $bookedTimes = Appointment::where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->where('status', '!=', 'cancelled')
                ->pluck('appointment_time')
                ->map(function ($time) {
                    // Если время уже в формате H:i, возвращаем как есть, иначе конвертируем
                    if (is_string($time)) {
                        // Проверяем, не является ли уже форматом H:i
                        if (preg_match('/^\d{2}:\d{2}$/', $time)) {
                            return $time;
                        }
                        // Пробуем конвертировать через strtotime
                        $timestamp = strtotime($time);
                        return $timestamp !== false ? date('H:i', $timestamp) : $time;
                    }
                    // Если это объект DateTime или Time
                    if ($time instanceof \DateTime || $time instanceof \Illuminate\Support\Carbon) {
                        return $time->format('H:i');
                    }
                    return date('H:i', strtotime($time));
                })
                ->filter()
                ->toArray();

            // Получаем расписание врача на указанную дату
            $schedules = Schedule::where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->where('is_available', true)
                ->get();

            $availableSlots = [];

            if ($schedules->count() > 0) {
                // Используем расписание врача
                foreach ($schedules as $schedule) {
                    $start = strtotime($schedule->start_time);
                    $end = strtotime($schedule->end_time);

                    // Генерируем слоты каждые 30 минут в пределах расписания
                    $current = $start;
                    while ($current < $end) {
                        $timeSlot = date('H:i', $current);
                        // Проверяем, не занято ли это время
                        if (!in_array($timeSlot, $bookedTimes)) {
                            $availableSlots[] = $timeSlot;
                        }
                        $current += 30 * 60; // +30 минут
                    }
                }
            } else {
                return response()->json([
                    'error' => 'Врач в этот день не работет.',
//                    'message' => $e->getMessage(),
                ], 500);
//                // Если расписание не задано, используем динамическую генерацию (обратная совместимость)
//                $startHour = 9;
//                $endHour = 17;
//                $slotDuration = 30; // минут
//
//                for ($hour = $startHour; $hour < $endHour; $hour++) {
//                    for ($minute = 0; $minute < 60; $minute += $slotDuration) {
//                        $timeSlot = sprintf('%02d:%02d', $hour, $minute);
//                        if (!in_array($timeSlot, $bookedTimes)) {
//                            $availableSlots[] = $timeSlot;
//                        }
//                    }
//                }
            }
            // Сортируем слоты
            sort($availableSlots);

            return response()->json([
                'available_times' => $availableSlots,
                'booked_times' => $bookedTimes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка при получении доступных времен',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Проверяем, что пользователь авторизован
        if (!Auth::check()) {
            return redirect()->route('auth')->with('error', 'Для записи необходимо войти в систему');
        }

        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
        ], [
            'appointment_time.required' => 'Пожалуйста, выберите время приема',
            'appointment_time.date_format' => 'Неверный формат времени',
        ]);

        // Проверяем доступность времени
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingAppointment) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Это время уже занято. Выберите другое время.');
        }

        // Проверяем, что врач активен
        $doctor = Doctor::findOrFail($request->doctor_id);
        if (!$doctor->is_active) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Этот врач временно недоступен для записи.');
        }

        // Создаем запись
        Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'notes' => $request->notes ?? null,
        ]);

        return redirect()->route('appointments.my')->with('success', 'Запись успешно создана!');
    }

    public function myAppointments()
    {
        if (!Auth::check()) {
            return redirect()->route('auth')->with('error', 'Для просмотра записей необходимо войти в систему');
        }

        $appointments = Appointment::where('user_id', Auth::id())
            ->with(['doctor.specialty'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('appointments.my', [
            'appointments' => $appointments,
        ]);
    }

    public function cancelAppointment(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth')->with('error', 'Необходима авторизация');
        }

        $appointment = Appointment::findOrFail($id);

        // Проверяем, что запись принадлежит текущему пользователю
        if ($appointment->user_id !== Auth::id()) {
            return redirect()->route('appointments.my')->with('error', 'Вы можете отменять только свои записи');
        }

        // Проверяем, что запись еще не отменена и не завершена
        if ($appointment->status === 'cancelled') {
            return redirect()->route('appointments.my')->with('error', 'Эта запись уже отменена');
        }

        if ($appointment->status === 'completed') {
            return redirect()->route('appointments.my')->with('error', 'Нельзя отменить завершенную запись');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|min:5|max:500',
        ]);

        // Отменяем запись
        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->route('appointments.my')->with('success', 'Запись успешно отменена');
    }
}
