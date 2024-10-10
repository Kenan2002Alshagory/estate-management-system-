<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyControllerApplication extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService){
        $this->currencyService = $currencyService;
    }
    
    public function allCurrency(){
        $currencies = $this->currencyService->allCurrency();
        return response()->json([
            'currencies' => $currencies 
        ]);
    }
    
}
