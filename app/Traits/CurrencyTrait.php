<?php


namespace App\Traits;

use App\Models\Currency;

trait CurrencyTrait {
    public function updateCurrency($type,$price){
        if($type == ''){
            return $price;  
        }
        $amount = Currency::where('name',$type)->first()->amount;
        $newPrice = $amount * $price;
        return $newPrice;
    }
}