<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Services\CompaniesService;
use Illuminate\Http\Request;

class CompaniesControllerWeb extends Controller
{
    protected $companiesService;

    public function __construct(CompaniesService $companiesService){
        $this->companiesService = $companiesService;
    }

    public function companies($type,$name = ""){
        if (empty($name)) {
            $companies = $this->companiesService->companies($type);
        }else{
            $companies = $this->companiesService->searchCompany($type,$name);
        }
        if(count($companies) === 0){
            return response()->json([
                'message' => 'there are no companies'
            ]);
        }
        return response()->json(['companies'=>$companies]);
    }

    public function detailCompany($id){
        $company = $this->companiesService->detailCompany($id);
        return response()->json(['company'=>$company]);
    }

    public function blockCompany($id){
        $company = $this->companiesService->detailCompany($id);
        $status = $company->block;
        $company->block = !$status;
        $company->save();
        return $company;
    }

    public function createCompany(CreateCompanyRequest $request){
        $data = $request->all();
        return $data;
        $company =  $this->companiesService->createCompany($data);
        return response()->json([
            'company'=>$company,
            'message'=>'your company is created'
        ]);
    }

    public function deleteCompany($id){
        $this->companiesService->deleteCompany($id);
        return response()->json([
            'message'=>'company deleted'
        ]);
    } 
}
