<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use App\Services\CompaniesService;
use Illuminate\Http\Request;

class CompaniesControllerApplication extends Controller
{
    protected $companiesService;

    public function __construct(CompaniesService $companiesService){
        $this->companiesService = $companiesService;
    }

    public function companies(Request $request){
        $data = $request->all();
        if (empty($data['name'])) {
            $companies = $this->companiesService->companies($data['type']);
        }else{
            $companies = $this->companiesService->searchCompany($data['type'],$data['name']);
        }
        return response()->json(['companies'=>$companies]);
    }

    public function detailCompany($id){
        $company = $this->companiesService->detailCompany($id);
        return response()->json(['company'=>$company]);
    }
    
}
