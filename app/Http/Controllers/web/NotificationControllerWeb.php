<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationControllerWeb extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService){
        $this->notificationService = $notificationService;
    }

    
}
