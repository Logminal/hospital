<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorAppointmentController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth')->with('error', 'Необходима авторизация');
        }

        $user = Auth::user();
        
        if (!$user->isDoctor()) {
            abort(403, 'Доступ запрещен. Только для врачей.');
        }

        $doctor = Doctor::where('user_id', $user->id)->first();
        
        if (!$doctor) {
            return redirect()->route('main')->with('error', 'Для вашей учетной записи не найден профиль врача. Обратитесь к администратору.');
        }
        
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['user'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get()
            ->groupBy(function($appointment) {
                return $appointment->appointment_date->format('Y-m-d');
            });

        return view('doctor.appointments.index', [
            'appointments' => $appointments,
            'doctor' => $doctor,
        ]);
    }

    public function updateStatus(Request $request, $appointment)
    {
        // Проверяем, что пользователь - врач
        if (!Auth::user()->isDoctor()) {
            abort(403, 'Доступ запрещен. Только для врачей.');
        }

        // Получаем запись
        $appointment = Appointment::findOrFail($appointment);

        // Проверяем, что запись принадлежит текущему врачу
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();
        if ($appointment->doctor_id !== $doctor->id) {
            return redirect()->back()->with('error', 'У вас нет доступа к этой записи');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,visited,no_show,completed,cancelled',
        ]);

        $status = $request->status;
        
        // Если статус cancelled, требуется причина отмены
        if ($status === 'cancelled') {
            $request->validate([
                'cancellation_reason' => 'required|string|min:3',
            ]);
            $appointment->cancellation_reason = $request->cancellation_reason;
        }

        $appointment->status = $status;
        $appointment->save();

        $statusMessages = [
            'confirmed' => 'Запись подтверждена',
            'visited' => 'Статус изменен: пациент пришел',
            'no_show' => 'Статус изменен: пациент не пришел',
            'completed' => 'Прием завершен',
            'cancelled' => 'Запись отменена',
        ];

        return redirect()->back()->with('success', $statusMessages[$status] ?? 'Статус обновлен');
    }

    public function completeAppointment(Request $request, $appointment)
    {
        // Проверяем, что пользователь - врач
        if (!Auth::user()->isDoctor()) {
            abort(403, 'Доступ запрещен. Только для врачей.');
        }

        // Получаем запись
        $appointment = Appointment::findOrFail($appointment);

        // Проверяем, что запись принадлежит текущему врачу
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();
        if ($appointment->doctor_id !== $doctor->id) {
            return redirect()->back()->with('error', 'У вас нет доступа к этой записи');
        }

        $request->validate([
            'conclusion' => 'required|string|min:10',
        ]);

        $appointment->status = 'completed';
        $appointment->conclusion = $request->conclusion;
        $appointment->save();

        return redirect()->back()->with('success', 'Прием завершен, заключение добавлено');
    }

    public function cancelAppointment(Request $request, $appointment)
    {
        // Проверяем, что пользователь - врач
        if (!Auth::user()->isDoctor()) {
            return response()->json(['error' => 'Доступ запрещен. Только для врачей.'], 403);
        }

        // Получаем запись
        $appointment = Appointment::findOrFail($appointment);

        // Проверяем, что запись принадлежит текущему врачу
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();
        if ($appointment->doctor_id !== $doctor->id) {
            return response()->json(['error' => 'У вас нет доступа к этой записи'], 403);
        }

        $request->validate([
            'cancellation_reason' => 'required|string|min:3',
        ]);

        $appointment->status = 'cancelled';
        $appointment->cancellation_reason = $request->cancellation_reason;
        $appointment->save();

        return response()->json([
            'success' => true,
            'message' => 'Запись отменена',
        ]);
    }
}
