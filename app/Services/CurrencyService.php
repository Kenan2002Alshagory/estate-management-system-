<?php

namespace App\Services;

use App\Models\Currency;

class CurrencyService{

    public function createCurrency($data){
        return Currency::create($data);
    }

    public function allCurrency(){
        return Currency::all();
    }

    public function updateCurrency($id , $data){
        return Currency::findOrFail($id)->update($data);
    }

    public function deleteCurrency($id){
        return Currency::findOrFail($id)->delete();
    }
}