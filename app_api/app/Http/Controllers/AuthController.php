<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Метод для авторизации
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        $user = User::where('name', $credentials['name'])->first();

        if (!$user) {
            return response()->json(['message' => 'Пользователь не существует'], 404);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Неверный пароль'], 401);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Создание токена
            $token = $user->createToken('authToken')->plainTextToken;

            // Разделение токена на две части
            [$id, $token] = explode('|', $token, 2);

            // Установка HttpOnly куки с токеном
            $cookie = cookie('auth_token', $token, 180); // Установка куки на 180 минут

            // Возвращаем ответ с установленной кукой
            return response()->json([
                'message' => 'Авторизация успешна',
                'user' => $user,
            ])->withCookie($cookie);
        }

        return response()->json(['message' => 'Неверный логин или пароль'], 401);
    }


    // Метод для выхода пользователя
    public function logout(Request $request)
    {
        // Удаляем токен пользователя
        $request->user()->tokens()->delete();

        // Удаляем куку
        $cookie = Cookie::forget('auth_token');

        return response()->json(['message' => 'Вы вышли из системы'])->withCookie($cookie);
    }

}
