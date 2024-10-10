<?php

namespace App\Console\Commands;

use App\Models\Estate;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RentedEstateNoti extends Command
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService){
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    protected $signature = 'app:rented-estate-noti';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();
        $user_ids = Estate::where('type', 'rented')
            ->where('end_date', '>', $today)
            ->where(DB::raw('TIMESTAMPDIFF(MONTH, start_date, NOW()) % 2 = 0'))
            ->distinct()
            ->pluck('user_id');
        $users = User::wherein('id',$user_ids)->get();
        foreach($users as $user){
            $this->notificationService->sendToUser($user,
                 'Rent Collection Reminder',
                'It has been two months without receiving rent payment.'
            );
        }
    }
}
