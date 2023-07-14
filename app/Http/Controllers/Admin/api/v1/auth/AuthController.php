<?php

namespace App\Http\Controllers\Admin\api\v1\auth;

use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Admin\api\v1\auth\AuthResource;
use App\Http\Requests\Admin\api\v1\auth\LoginAuthenticationRequest;
use App\Http\Requests\Admin\api\v1\auth\RegisterAuthenticationRequest;
use App\Http\Requests\Admin\api\v1\auth\ChangePasswordAuthenticationRequest;

class AuthController extends Controller
{
    public function login(LoginAuthenticationRequest $request)
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
