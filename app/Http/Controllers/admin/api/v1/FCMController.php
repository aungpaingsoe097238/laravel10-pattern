<?php

namespace App\Http\Controllers\admin\api\v1;

use App\Models\FCM;
use App\Utlis\Json;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Services\Notification\NotificationService;

class FCMController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Save Token
     */
    public function saveToken(Request $request)
    {
        $request->validate(['fcm_token' => "required"]);
        $sameUser = FCM::where('user_id', Auth::user()->id)->first();

        if (!$sameUser) {
            $f_c_m_s = FCM::create(['user_id' => Auth::user()->id, 'fcm_token' => $request->fcm_token]);
            return Json::success($f_c_m_s, 'Token save successfully.');
        }

        return Json::error('User Token already have been taken.');
    }

    /**
     * Send Notification
     */
    public function sentNotification(Request $request)
    {
        $request->validate([
            'user_id' => "required|exists:users,id",
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $user = User::with('fcm_token')->find($request->user_id);

        if (is_null($user)) {
            return Json::error('User not found.');
        }

        $fcm_token = $user['fcm_token'];

        if (is_null($fcm_token)) {
            return Json::error('FCM Token not found.');
        }

        // Send FCM notification
        $this->notificationService->sendNotification('Hi', 'This is fcm notification', $fcm_token['fcm_token']);
        return Json::success('Notification send successfully.');
    }
}
