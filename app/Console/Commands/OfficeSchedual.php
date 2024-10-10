<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OfficeSchedual extends Command
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService){
        parent::__construct();
        $this->notificationService = $notificationService;
    }



    protected $signature = 'app:office-schedual';
    protected $description = 'Command description';

    public function handle()
    {

        $users_not_subscription = User::where('type', 'office')
        ->where('verifyOffice', false)
        ->where('created_at', '<', Carbon::now()->subDays(30))
        ->get();

        foreach ($users_not_subscription as $user) {
            $user->update(['type' => 'client']);

            $this->notificationService->sendToUser($user,'Account Status Changed','Your account type has been changed to client.');
        }

        $users_subscription = User::where('type','office')
        ->where('verifyOffice',true)
        ->where('days', '>' ,  0)
        ->update([
            'days' => DB::raw('days - 1')
        ]);


        $users_subscription_ended = User::where('type','office')
        ->where('verifyOffice',true)
        ->where('days', 0)
        ->get();

        foreach ($users_subscription_ended as $user) {
            $user->update([
                'type'=>'client',
                'verifyOffice' => false
            ]);

            $this->notificationService->sendToUser($user,'Account Status Changed','Your subscription has expired.');
        }


    }
}
