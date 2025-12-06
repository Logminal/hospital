<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            abort(403, 'Доступ запрещен. Только для врачей.');
        }

        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();
        
        // Получаем расписание на ближайшие 30 дней
        $schedules = Schedule::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>=', now()->toDateString())
            ->orderBy('appointment_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get()
            ->groupBy(function($schedule) {
                return $schedule->appointment_date->format('Y-m-d');
            });

        return view('doctor.schedule.index', [
            'doctor' => $doctor,
            'schedules' => $schedules,
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            abort(403, 'Доступ запрещен. Только для врачей.');
        }

        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Проверяем, нет ли уже такого слота
        $existing = Schedule::where('doctor_id', $doctor->id)
            ->where('appointment_date', $request->appointment_date)
            ->where('start_time', $request->start_time)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Этот слот уже существует');
        }

        Schedule::create([
            'doctor_id' => $doctor->id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_available' => true,
        ]);

        return redirect()->back()->with('success', 'Слот успешно создан');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            abort(403, 'Доступ запрещен. Только для врачей.');
        }

        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();
        $schedule = Schedule::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        $request->validate([
            'is_available' => 'required|boolean',
        ]);

        $schedule->update([
            'is_available' => $request->is_available,
        ]);

        return redirect()->back()->with('success', 'Слот обновлен');
    }

    public function destroy($id)
    {
        if (!Auth::check() || !Auth::user()->isDoctor()) {
            abort(403, 'Доступ запрещен. Только для врачей.');
        }

        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();
        $schedule = Schedule::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        $schedule->delete();

        return redirect()->back()->with('success', 'Слот удален');
    }
}
