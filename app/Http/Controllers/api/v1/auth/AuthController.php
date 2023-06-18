<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => false], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'data' => $user,
            'message' => 'user registation successfully',
            'status' => true
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user['token'] = $user->createToken('laravel10')->accessToken;
            return response()->json(['data' => $user, 'status' => true], 200);
        } else {
            return response()->json(['message' => 'Unauthorized', 'status' => false], 401);
        }
    }
}
