<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminPanel()
    {
        // Проверяем, что пользователь авторизован
        if (!Auth::check()) {
            return redirect()->route('auth')->with('error', 'Необходима авторизация для доступа к админ-панели');
        }

        $user = Auth::user();
        
        // Проверяем, что пользователь является админом
        if (!$user->isAdmin()) {
            return redirect()->route('main')->with('error', 'Доступ запрещен. Только для администраторов. Ваша роль: ' . ($user->role ?? 'не установлена'));
        }

        $all_users = User::all();
        $all_specialty = Specialty::all();
        $all_doctors = Doctor::with(['specialty', 'user'])->get();
        $all_admins = User::where('role', 'admin')->get();
        $all_appointments = Appointment::with(['user', 'doctor.specialty'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('admin.panel',[
            'all_users' => $all_users,
            'all_specialty' => $all_specialty,
            'all_doctors' => $all_doctors,
            'all_admins' => $all_admins,
            'all_appointments' => $all_appointments,
        ]);
    }

    public function storeSpecialty(Request $request)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $request->validate([
            'specialty' => 'required',
        ]);

        Specialty::create([
            'name' => $request["specialty"],
        ]);
        return redirect()->back();
    }

    public function storeDoctor(Request $request)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id',
            'pole' => 'required|string|unique:users,pole',
            'password' => 'required|string|min:6',
            'cabinet_number' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        // Создаем пользователя с ролью врач
        $user = User::create([
            'name' => $request['name'],
            'pole' => $request['pole'],
            'password' => bcrypt($request['password']),
            'role' => 'doctor',
        ]);

        // Создаем врача и привязываем к пользователю
        Doctor::create([
            'name' => $request['name'],
            'specialty_id' => $request['specialty_id'],
            'user_id' => $user->id,
            'cabinet_number' => $request['cabinet_number'] ?? null,
            'is_active' => $request->has('is_active') ? (bool)$request['is_active'] : true,
        ]);

        return redirect()->back()->with('success', 'Врач успешно добавлен! Логин: ' . $request['pole']);
    }

    public function showDoctor($id)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $doctor = Doctor::with(['specialty', 'user'])->findOrFail($id);
        
        return response()->json([
            'id' => $doctor->id,
            'name' => $doctor->name,
            'specialty' => $doctor->specialty->name ?? 'Не указана',
            'specialty_id' => $doctor->specialty_id,
            'cabinet_number' => $doctor->cabinet_number,
            'is_active' => $doctor->is_active,
            'user' => $doctor->user ? [
                'id' => $doctor->user->id,
                'name' => $doctor->user->name,
                'pole' => $doctor->user->pole,
            ] : null,
            'created_at' => $doctor->created_at->format('d.m.Y H:i'),
        ]);
    }

    public function destroyDoctor($id)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->back()->with('success', 'Врач успешно удален');
    }

    public function storeAdmin(Request $request)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'pole' => 'required|string|unique:users,pole',
            'password' => 'required|string|min:6',
        ]);

        // Создаем пользователя с ролью администратора
        $user = User::create([
            'name' => $request['name'],
            'pole' => $request['pole'],
            'password' => bcrypt($request['password']),
            'role' => 'admin',
        ]);

        return redirect()->back()->with('success', 'Администратор успешно создан! Логин: ' . $request['pole']);
    }

    public function showUser($id)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $user = User::with(['appointments.doctor', 'doctor'])->findOrFail($id);
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'pole' => $user->pole,
            'role' => $user->role,
            'created_at' => $user->created_at->format('d.m.Y H:i'),
            'appointments_count' => $user->appointments->count(),
            'doctor' => $user->doctor ? [
                'id' => $user->doctor->id,
                'name' => $user->doctor->name,
                'specialty' => $user->doctor->specialty->name ?? 'Не указана',
            ] : null,
        ]);
    }

    public function destroyUser($id)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $user = User::findOrFail($id);
        
        // Нельзя удалить самого себя
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Нельзя удалить самого себя');
        }

        // Если это врач, удаляем также его профиль врача
        if ($user->role === 'doctor' && $user->doctor) {
            $user->doctor->delete();
        }

        $user->delete();

        return redirect()->back()->with('success', 'Пользователь успешно удален');
    }

    public function destroySpecialty($id)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $specialty = Specialty::findOrFail($id);
        
        // Проверяем, нет ли врачей с этой специальностью
        $doctorsCount = Doctor::where('specialty_id', $id)->count();
        if ($doctorsCount > 0) {
            return redirect()->back()->with('error', 'Невозможно удалить специальность. Есть врачи с этой специальностью (' . $doctorsCount . ' шт.)');
        }

        $specialty->delete();

        return redirect()->back()->with('success', 'Специальность успешно удалена');
    }
}
