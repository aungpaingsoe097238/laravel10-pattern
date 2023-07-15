<?php

namespace App\Http\Controllers\Mobile\api\v1\auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OneTimePassword;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Mobile\api\v1\auth\AuthResource;
use App\Http\Requests\Mobile\api\v1\auth\LoginAuthenticationRequest;
use App\Http\Requests\Mobile\api\v1\auth\RegisterAuthenticationRequest;
use App\Http\Requests\Mobile\api\v1\auth\ChangePasswordAuthenticationRequest;

class AuthController extends Controller
{
    public function requestOtp(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        $existingRecord = OneTimePassword::where('email', $request->email)->first();

        if ($existingRecord) {
            $existingRecord->code = rand(1000, 9999);
            $existingRecord->status = false;
            $existingRecord->save();
            return response()->json([
                'message' => 'OTP code has been resent. Code is ' . $existingRecord->code,
                'status'  => true
            ]);
        }

        $oneTimePassword = OneTimePassword::create([
            'email' => $request->email,
            'code' => rand(1000, 9999),
            'status' => false
        ]);

        return response()->json([
            'message' => 'Otp code is ' . $oneTimePassword->code,
            'status' => true
        ]);
    }

    public function verfiyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'code'   => 'required',
        ]);

        // Same record data from onetimepassword
        $existingRecord = OneTimePassword::where('status', false)
            ->where('email', $request->email)
            ->where('code', $request->code)->first();

        if (is_null($existingRecord)) {
            return response()->json([
                'message' => 'Otp is invalid',
                'status'  => false
            ], 400);
        }

        $existingRecord->update([
            'status' => true
        ]);

        return response()->json([
            'message' => 'Otp is valid',
            'status'  => true
        ], 200);
    }

    public function register(RegisterAuthenticationRequest $request)
    {
        $existingRecord = OneTimePassword::where('email',$request->email)
        ->where('code',$request->code)
        ->where('status',true)->first();
        
        if(is_null($existingRecord)){
            return response()->json([
                'message' => 'Please verify your email address.',
                'status'  => false 
            ],400);
        }

        $user = User::create($request->validated() + [
            'password' => Hash::make($request->validated()['password'])
        ]);

        $role = Role::findOrFail(2);
        $user->assignRole($role);
        return new AuthResource($user);
    }

    public function login(LoginAuthenticationRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $user['token'] = $user->createToken('laravel10')->accessToken;
            return new AuthResource($user);
        }
        return response()->json(['message' => 'Unauthorized.', 'status' => false], Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return new AuthResource($user);
    }

    public function changePassword(ChangePasswordAuthenticationRequest $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'The current password is incorrect.', 'status' => false], Response::HTTP_BAD_REQUEST);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return new AuthResource($user);
    }
}
