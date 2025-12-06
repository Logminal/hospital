<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'pole' => 'required|string|unique:users,pole',
            'password' => 'required|string|min:6',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
        ]);

        // Формируем полное имя для обратной совместимости
        $fullName = trim(($request['surname'] ?? '') . ' ' . ($request['firstname'] ?? '') . ' ' . ($request['patronymic'] ?? ''));
        if (empty($fullName)) {
            $fullName = $request['firstname'] ?? 'Пользователь';
        }

        $user = User::create([
            "name" => $fullName,
            "surname" => $request['surname'] ?? null,
            "firstname" => $request['firstname'],
            "patronymic" => $request['patronymic'] ?? null,
            "pole" => $request['pole'],
            "email" => $request['email'] ?? null,
            "phone" => $request['phone'] ?? null,
            "birth_date" => $request['birth_date'] ?? null,
            "password" => bcrypt($request['password']),
            "role" => "patient", // По умолчанию пациент
        ]);

        auth()->login($user);

        return redirect('/');
    }

    public function login(Request $request)
    {
        $request->validate([
            'pole' => 'required',
            'password' => 'required',
        ]);

        if(auth()->attempt(['pole' => $request['pole'], 'password' => $request['password']])){
            return redirect('/');
        }
        return redirect('/auth')->with('message', 'Неверный логин или пароль');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('main'));
    }
}
