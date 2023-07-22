<?php

namespace App\Http\Controllers\Admin\api\v1\auth;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\api\v1\auth\LoginRequest;
use App\Http\Resources\Admin\api\v1\auth\AuthResource;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $user['token'] = $user->createToken('laravel10')->accessToken;
            return new AuthResource($user->load('roles'));
        }
        return response()->json(['message' => 'Unauthorized.', 'status' => false], Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return new AuthResource($user);
    }

}
