<?php

namespace App\Services;

use App\Models\PrivateNotification;
use App\Models\PublicNotification;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationService{

    public function allNotification($user){
        $privateNotification = PrivateNotification::where('user_id',$user->id)->get();
        $publicNotification = PublicNotification::where('type',$user->type)->get();

        $allNotification = $publicNotification->merge($privateNotification)->sortByDesc('created_at') ;

        return response()->json([
            'allNotification' => $allNotification,
        ]);
    }


    public function sendToAll($title, $body , $type) //detect type = office , client
    {
        // Path to the service account key JSON file
        $serviceAccountPath = storage_path('app/firebase.json');

        // Initialize the Firebase Factory with the service account
        $factory = (new Factory)->withServiceAccount($serviceAccountPath);

        // Create the Messaging instance
        $messaging = $factory->createMessaging();

        $message = null;

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $title,
                'body' => $body
            ],
            'topic' => $type
        ]);

        try {
            // Send the notification
            $messaging->send($message);

            PublicNotification::create([
                'type' => $type ,
                'title' => $title ,
                'body' => $body
            ]);
            return 1;
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            Log::error($e->getMessage());
            return 0;
        } catch (\Kreait\Firebase\Exception\FirebaseException $e) {
            Log::error($e->getMessage());
            return 0;
        }

    }

    public function sendToUser($user , $title, $message)
    {

        // Path to the service account key JSON file
        $serviceAccountPath = storage_path('app/firebase.json');

        // Initialize the Firebase Factory with the service account
        $factory = (new Factory)->withServiceAccount($serviceAccountPath);

        // Create the Messaging instance
        $messaging = $factory->createMessaging();

        // Prepare the notification array
        $notification = [
            'title' => $title,
            'body' => $message,
            'sound' => 'default',
        ];

        // Additional data payload
        $data = [
            'message' => $message,
        ];

        // Create the CloudMessage instance
        $cloudMessage = CloudMessage::withTarget('token', $user['fcm_token'])
            ->withNotification($notification)
            ->withData($data);

        try {
            // Send the notification
            $messaging->send($cloudMessage);
            PrivateNotification::create([
                'user_id' => $user->id,
                'title' => $title,
                'body' => $message,
            ]);
            return 1;
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            Log::error($e->getMessage());
            return 0;
        } catch (\Kreait\Firebase\Exception\FirebaseException $e) {
            Log::error($e->getMessage());
            return 0;
        }
    }
}
