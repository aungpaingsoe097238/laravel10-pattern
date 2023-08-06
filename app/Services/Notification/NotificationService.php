<?php

namespace App\Services\Notification;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationService
{
    public function sendNotification($title = 'Hi', $body = 'This is fcm notification.', $fcm_token)
    {
        // Create a new Firebase Factory instance with the service account credentials
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials'));
        $messaging = $factory->createMessaging();

        // Create a new notification message
        $message = CloudMessage::withTarget('token', $fcm_token)
            ->withNotification(Notification::create(
                $title,
                $body
            ));

        // Send the notification
        $messaging->send($message);
    }
}
