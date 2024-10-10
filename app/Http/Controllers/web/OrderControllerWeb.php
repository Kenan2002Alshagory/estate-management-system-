<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderControllerWeb extends Controller
{

    protected $orderService;

    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }

    public function allPromotionOrder(){
        $orders = $this->orderService->allPromotionOrder();
        return response()->json([
            'orders' => $orders
        ]);
    }

    public function acceptOrRejectOrder($type_order,$id_order){
        $order = $this->orderService->oneOrder($id_order);
        if($type_order = "accept"){
            User::findOrFail($order->user_id)->update([
                "type" => 'office',
                "verifyOffice" => true
            ]);
            $this->orderService->deleteOrder($id_order);
            return response()->json([
                'message' => 'the order is accepted' 
            ]);
        }
        $this->orderService->deleteOrder($id_order);
        return response()->json([
            'message' => 'the order is rejected' 
        ]);
    }
}
