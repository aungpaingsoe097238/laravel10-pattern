<?php

namespace App\Http\Controllers\Mobile\api\v1\fcm;

use Auth;
use App\Models\FCM;
use App\Utlis\Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FCMController extends Controller
{
    /**
     * Save Token
     */
    public function saveToken(Request $request)
    {
        $request->validate(['token' => "required"]);
        $sameUser = FCM::where('user_id', Auth::user()->id)->first();

        if (!$sameUser) {

            $f_c_m_s = FCM::create(['user_id' => Auth::user()->id, 'fcm_token' => $request->fcm_token]);
            return Json::success($f_c_m_s, 'Token save successfully.');
        }

        return Json::error('User Token already have been taken.');
    }
}
