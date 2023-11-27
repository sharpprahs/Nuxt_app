<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'token' => $token
            ], 200);
        } else {
            return response()->json(['message' => 'Произошла ошибка аутентификации'], 401);
        }
    }

    // Метод для выхода пользователя
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
