<?php
namespace App\Filament\Resources\NotificationResource\Pages;

use App\Filament\Resources\NotificationResource;
use App\Services\NotificationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNotification extends CreateRecord
{
    protected static string $resource = NotificationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $notification = parent::handleRecordCreation($data);

        // Send push notification using Firebase
        $pushNotificationController = new NotificationService();
        $pushNotificationController->sendToAll($data['title'], $data['body'] ,$data['type'] );

        return $notification;
    }
}
