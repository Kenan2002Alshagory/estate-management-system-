<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;

class OrderService{

    public function promotionOrder($user,$data){
        User::where('id',$user->id)->update([
            'name' => $data['name'],
            'whats_number' => $data['whats_number'],
            'location' => $data['location']
        ]);
        Order::create([
            'user_id' => $user->id
        ]);
    }

    public function allPromotionOrder(){
        return Order::with('user')->get();
    }

    public function oneOrder($id){
        return Order::findOrFail($id);
    }

    public function deleteOrder($id){
        return Order::findOrFail($id)->delete();
    }

}
