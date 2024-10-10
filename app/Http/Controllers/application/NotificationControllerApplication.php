<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationControllerApplication extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService){
        $this->notificationService = $notificationService;
    }

    public function allNoti(){
        $user = Auth::user();
        return $this->notificationService->allNotification($user);
    }

}
