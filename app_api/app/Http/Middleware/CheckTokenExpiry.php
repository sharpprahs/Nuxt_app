<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiry
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $tokenId = $user->currentAccessToken()->id ?? null;

            if ($tokenId) {
                $token = PersonalAccessToken::find($tokenId);

                if ($token && now()->diffInMinutes($token->created_at) > 2) {

                    // Удаляем токен пользователя
                    $request->user()->tokens()->delete();

                    // Удаляем куку
                    $cookie = Cookie::forget('auth_token');

                    // Отправляем ответ, что срок действия токена истек
                    return response()->json(['message' => 'Срок действия токена истек'], 401)->withCookie($cookie);
                }
            }
        }

        return $next($request);
    }
}
