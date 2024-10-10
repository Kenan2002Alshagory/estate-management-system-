<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderControllerApplication extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }

    public function promotionOrder(Request $request){
        $data = $request->all();
        $user = Auth::user();
        if (count($user->orders) === 0) {
            if($user->verifyOffice){
                return response()->json([
                    'message' => 'You already upgraded your account'
                ],400);
            }
            $this->orderService->promotionOrder($user,$data);
            return response()->json([
                'message' => 'Your order sended'
            ]);
        }
        return response()->json([
            'message' => 'You have order'
        ],400);
    }
}
