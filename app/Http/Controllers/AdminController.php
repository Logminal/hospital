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
            'surname' => 'nullable|string|max:255',
            'firstname' => 'nullable|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
        ]);

        // Формируем имя для поля name (для обратной совместимости)
        $fullName = $request['name'];
        if ($request->filled('firstname') || $request->filled('surname')) {
            $nameParts = array_filter([
                $request['surname'],
                $request['firstname'],
                $request['patronymic']
            ]);
            if (!empty($nameParts)) {
                $fullName = implode(' ', $nameParts);
            }
        }

        // Создаем пользователя с ролью врач
        $user = User::create([
            'name' => $fullName,
            'surname' => $request['surname'] ?? null,
            'firstname' => $request['firstname'] ?? null,
            'patronymic' => $request['patronymic'] ?? null,
            'pole' => $request['pole'],
            'email' => $request['email'] ?? null,
            'phone' => $request['phone'] ?? null,
            'birth_date' => $request['birth_date'] ?? null,
            'password' => bcrypt($request['password']),
            'role' => 'doctor',
        ]);

        // Создаем врача и привязываем к пользователю
        Doctor::create([
            'name' => $fullName,
            'specialty_id' => $request['specialty_id'],
            'user_id' => $user->id,
            'cabinet_number' => $request['cabinet_number'] ?? null,
            'is_active' => $request->has('is_active') ? (bool)$request['is_active'] : true,
        ]);

        return redirect()->back()->with('success', 'Врач успешно добавлен! Логин: ' . $request['pole']);
    }

    public function updateDoctor(Request $request, $id)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        $doctor = Doctor::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id',
            'pole' => 'required|string|unique:users,pole,' . ($doctor->user ? $doctor->user->id : 'NULL') . ',id',
            'password' => 'nullable|string|min:6',
            'cabinet_number' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
            'surname' => 'nullable|string|max:255',
            'firstname' => 'nullable|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . ($doctor->user ? $doctor->user->id : 'NULL') . ',id',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
        ]);

        // Формируем имя для поля name (для обратной совместимости)
        $fullName = $request['name'];
        if ($request->filled('firstname') || $request->filled('surname')) {
            $nameParts = array_filter([
                $request['surname'],
                $request['firstname'],
                $request['patronymic']
            ]);
            if (!empty($nameParts)) {
                $fullName = implode(' ', $nameParts);
            }
        }

        // Обновляем врача
        $doctor->update([
            'name' => $fullName,
            'specialty_id' => $request['specialty_id'],
            'cabinet_number' => $request['cabinet_number'] ?? null,
            'is_active' => $request->has('is_active') ? (bool)$request['is_active'] : true,
        ]);

        // Обновляем пользователя
        if ($doctor->user) {
            $userData = [
                'name' => $fullName,
                'surname' => $request['surname'] ?? null,
                'firstname' => $request['firstname'] ?? null,
                'patronymic' => $request['patronymic'] ?? null,
                'pole' => $request['pole'],
                'email' => $request['email'] ?? null,
                'phone' => $request['phone'] ?? null,
                'birth_date' => $request['birth_date'] ?? null,
            ];

            // Обновляем пароль только если он указан
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request['password']);
            }

            $doctor->user->update($userData);
        }

        return redirect()->back()->with('success', 'Данные врача успешно обновлены!');
    }

    public function showDoctor($id)
    {
        // Проверяем права доступа
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для администраторов.');
        }

        try {
            $doctor = Doctor::with(['specialty', 'user'])->findOrFail($id);
            
            return response()->json([
                'id' => $doctor->id,
                'name' => $doctor->name ?? '',
                'specialty' => $doctor->specialty ? ($doctor->specialty->name ?? 'Не указана') : 'Не указана',
                'specialty_id' => $doctor->specialty_id,
                'cabinet_number' => $doctor->cabinet_number ?? null,
                'is_active' => $doctor->is_active ?? true,
                'user' => $doctor->user ? [
                    'id' => $doctor->user->id,
                    'name' => $doctor->user->name ?? '',
                    'surname' => $doctor->user->surname ?? null,
                    'firstname' => $doctor->user->firstname ?? null,
                    'patronymic' => $doctor->user->patronymic ?? null,
                    'pole' => $doctor->user->pole ?? '',
                    'email' => $doctor->user->email ?? null,
                    'phone' => $doctor->user->phone ?? null,
                    'birth_date' => $doctor->user->birth_date ? $doctor->user->birth_date->format('Y-m-d') : null,
                ] : null,
                'created_at' => $doctor->created_at ? $doctor->created_at->format('d.m.Y H:i') : '',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка при загрузке данных о враче',
                'message' => $e->getMessage()
            ], 500);
        }
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

        try {
            $user = User::with(['appointments.doctor', 'doctor.specialty'])->findOrFail($id);
            
            return response()->json([
                'id' => $user->id,
                'name' => $user->name ?? ($user->firstname . ' ' . ($user->surname ?? '')),
                'surname' => $user->surname ?? null,
                'firstname' => $user->firstname ?? null,
                'patronymic' => $user->patronymic ?? null,
                'pole' => $user->pole,
                'email' => $user->email ?? null,
                'phone' => $user->phone ?? null,
                'birth_date' => $user->birth_date ? $user->birth_date->format('d.m.Y') : null,
                'role' => $user->role,
                'created_at' => $user->created_at->format('d.m.Y H:i'),
                'appointments_count' => $user->appointments ? $user->appointments->count() : 0,
                'doctor' => $user->doctor ? [
                    'id' => $user->doctor->id,
                    'name' => $user->doctor->name,
                    'specialty' => $user->doctor->specialty ? $user->doctor->specialty->name : 'Не указана',
                ] : null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка при загрузке данных пользователя',
                'message' => $e->getMessage()
            ], 500);
        }
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
