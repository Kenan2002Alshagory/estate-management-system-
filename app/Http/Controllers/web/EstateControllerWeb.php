<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEstateRequest;
use App\Models\Currency;
use App\Services\EstateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstateControllerWeb extends Controller
{
    protected $estateService;

    public function __construct(EstateService $estateService){
        $this->estateService = $estateService;
    }

}
