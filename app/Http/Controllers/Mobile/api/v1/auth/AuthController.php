<?php

namespace App\Http\Controllers\Mobile\api\v1\auth;

use App\Models\User;
use Illuminate\Http\Response;
use App\Models\OneTimePassword;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Mobile\api\v1\auth\AuthResource;
use App\Http\Requests\Mobile\api\v1\auth\LoginRequest;
use App\Http\Requests\Mobile\api\v1\auth\RegisterRequest;
use App\Http\Requests\Mobile\api\v1\auth\RequestOtpRequest;
use App\Http\Requests\Mobile\api\v1\auth\ChangePasswordRequest;
use App\Http\Requests\Mobile\api\v1\auth\forgotPassword\ForgotPasswordChangePasswordRequest;
use App\Http\Requests\Mobile\api\v1\auth\forgotPassword\ForgotPasswordRequestOtpRequest;
use App\Http\Requests\Mobile\api\v1\auth\forgotPassword\ForgotPasswordVerifyPasswordRequest;
use App\Http\Requests\Mobile\api\v1\auth\VerifyOtpRequest;

class AuthController extends Controller
{

    protected $with = [];

    public function __construct()
    {
        $this->with = ['roles'];
    }


    public function requestOtp(RequestOtpRequest $request)
    {
        $data = [
            'email' => $request->email,
            'status' => false,
            'code' => rand(1000, 9999),
        ];

        $oneTimePassword = OneTimePassword::updateOrCreate(['email' => $request->email], $data);

        return response()->json([
            'message' => 'OTP is ' . $oneTimePassword->code,
            'status'  => false
        ]);
    }

    public function verfiyOtp(VerifyOtpRequest $request)
    {
        $otp = OneTimePassword::where('status', false)
            ->where('code', $request->code)
            ->first();

        if (!$otp) {
            return response()->json([
                'message' => 'Invalid OTP.',
                'status'  => false
            ], Response::HTTP_BAD_REQUEST);
        }

        $otp->status = true;
        $otp->save();

        return response()->json([
            'message' => 'Valid OTP.',
            'status'  => true
        ]);
    }

    public function register(RegisterRequest $request)
    {
        // Check OTP is verify
        $oneTimePassword = OneTimePassword::where('code', $request->code)
            ->where('status', true)->first();

        if (!$oneTimePassword) {
            return response()->json([
                'message' => 'Please verify your email address.',
                'status'  => false
            ], 400);
        }

        $user = User::create($request->validated() + [
            'password' => Hash::make($request->password)
        ]);

        $oneTimePassword->update([
            'user_id' => $user->id
        ]);

        $role = Role::findOrFail(2); // Change your role id
        $user->assignRole($role);
        return new AuthResource($user->load($this->with));
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $user['token'] = $user->createToken('laravel10')->accessToken;
            return new AuthResource($user->load($this->with));
        }
        return response()->json(['message' => 'Unauthorized.', 'status' => false], Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return new AuthResource($user);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'The current password is incorrect.', 'status' => false], Response::HTTP_BAD_REQUEST);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return new AuthResource($user);
    }

    public function forgotPasswordRequestOtp(ForgotPasswordRequestOtpRequest $request)
    {
        $oneTimePassword = OneTimePassword::where('email', $request->email)->first();

        if (!$oneTimePassword) {
            return response()->json([
                'message' => 'Email not found.Please registation first.',
                'status'  => false
            ], Response::HTTP_NOT_FOUND);
        }

        $oneTimePassword->update([
            'code' => rand(1000, 9999)
        ]);

        return response()->json([
            'message' => 'OTP is ' . $oneTimePassword->code,
            'status'  => true
        ]);
    }

    public function forgotPasswordVerify(ForgotPasswordVerifyPasswordRequest $request)
    {
        $otp = OneTimePassword::where('code', $request->code)->first();

        if (!$otp) {
            return response()->json([
                'message' => 'Invalid OTP.',
                'status'  => false
            ]);
        }

        return response()->json([
            'message' => 'Valid OTP.',
            'status'  => true
        ]);
    }

    public function forgotPasswordChangePassword(ForgotPasswordChangePasswordRequest $request)
    {
        $oneTimePassword = OneTimePassword::where('code', $request->code)
            ->where('status', true)
            ->first();

        if (!$oneTimePassword) {
            return response()->json([
                'message' => 'Please verify your email address.',
                'status'  => false
            ]);
        }

        $user = $oneTimePassword->user;
        $user->password = Hash::make($request->new_password);
        $user->save();
        return new AuthResource($user->load($this->with));
    }
}
