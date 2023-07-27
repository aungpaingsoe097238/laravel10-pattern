<?php

namespace App\Http\Controllers\Mobile\api\v1\auth;

use App\Utlis\Json;
use App\Models\User;
use App\Mail\OtpVerifyEmail;
use Illuminate\Http\Response;
use App\Models\OneTimePassword;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Mobile\api\v1\auth\LoginRequest;
use App\Http\Resources\Mobile\api\v1\auth\AuthResource;
use App\Http\Requests\Mobile\api\v1\auth\RegisterRequest;
use App\Http\Requests\Mobile\api\v1\auth\VerifyOtpRequest;
use App\Http\Requests\Mobile\api\v1\auth\RequestOtpRequest;
use App\Http\Requests\Mobile\api\v1\auth\ChangePasswordRequest;
use App\Http\Requests\Mobile\api\v1\auth\forgotPassword\ForgotPasswordRequestOtpRequest;
use App\Http\Requests\Mobile\api\v1\auth\forgotPassword\ForgotPasswordChangePasswordRequest;
use App\Http\Requests\Mobile\api\v1\auth\forgotPassword\ForgotPasswordVerifyPasswordRequest;

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

        // Send otp to verify email
        Mail::to($oneTimePassword['email'])->send(new OtpVerifyEmail($oneTimePassword['code']));

        return Json::error('OTP was send to your email.Please verify.');
    }

    public function verfiyOtp(VerifyOtpRequest $request)
    {
        $otp = OneTimePassword::where('status', false)
            ->where('code', $request->code)
            ->first();

        if (!$otp) {
            return Json::error('Invalid OTP.');
        }

        $otp->status = true;
        $otp->save();

        return Json::error(
            'Valid OTP.'
        );
    }

    public function register(RegisterRequest $request)
    {
        // Check OTP is verify
        $oneTimePassword = OneTimePassword::where('code', $request->code)
            ->where('status', true)->first();

        if (!$oneTimePassword) {
            return Json::error('Please verify your email address.');
        }

        $user = User::create($request->validated() + [
            'password' => Hash::make($request->password)
        ]);

        $oneTimePassword->update([
            'user_id' => $user->id
        ]);

        // Change your role id
        $role = Role::findOrFail(2);
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
        return Json::error(
            'Invalid Credentials',
            Response::HTTP_UNAUTHORIZED
        );
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
            return Json::error('The current password is incorrect.');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return new AuthResource($user);
    }

    public function forgotPasswordRequestOtp(ForgotPasswordRequestOtpRequest $request)
    {
        $oneTimePassword = OneTimePassword::where('email', $request->email)
            ->where('status', true)->first();

        if (!$oneTimePassword) {
            return Json::error('Email not found.Please registation first.',Response::HTTP_NOT_FOUND);
        }

        $oneTimePassword->update([
            'code' => rand(1000, 9999)
        ]);

        // Send otp to verify email
        Mail::to($oneTimePassword['email'])->send(new OtpVerifyEmail($oneTimePassword['code']));

        return Json::error('OTP is send to your email.Please verify.');
    }

    public function forgotPasswordVerify(ForgotPasswordVerifyPasswordRequest $request)
    {
        $otp = OneTimePassword::where('code', $request->code)->first();

        if (!$otp) {
            return Json::error('Invalid OTP.');
        }

        return Json::error('Valid OTP.');
    }

    public function forgotPasswordChangePassword(ForgotPasswordChangePasswordRequest $request)
    {
        $oneTimePassword = OneTimePassword::where('code', $request->code)
            ->where('status', true)
            ->first();

        if (!$oneTimePassword) {
            return Json::error('Please verify your email address.');
        }

        $user = $oneTimePassword->user;
        $user->password = Hash::make($request->new_password);
        $user->save();
        return new AuthResource($user->load($this->with));
    }
}
