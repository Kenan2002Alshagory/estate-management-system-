<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyControllerWeb extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService){
        $this->currencyService = $currencyService;
    }
    
    public function createCurrency(Request $request){
        $data = $request->all();
        $this->currencyService->createCurrency($data);
        return response()->json([
            'message' => 'your currency created' 
        ]);
    }

    public function deleteCurrency($id){
        $this->currencyService->deleteCurrency($id);
        return response()->json([
            'message' => 'your currency deleted' 
        ]);
    }

    public function updateCurrency($id,Request $request){
        $data = $request->all();
        $this->currencyService->updateCurrency($id,$data);
        return response()->json([
            'message' => 'your currency updated' 
        ]);
    }

    public function allCurrency(){
        $currencies = $this->currencyService->allCurrency();
        return response()->json([
            'currencies' => $currencies 
        ]);
    }

}
