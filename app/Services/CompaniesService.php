<?php

namespace App\Services;

use App\Models\Company;
use App\Traits\AddPhotoTrait;

class CompaniesService{

    use AddPhotoTrait;

    public function companies($type){
        if($type == 'engineering_companies')
            return Company::where('type','engineering_companies')->get();
        if($type == 'real_estate_maintenance_companies')
            return Company::where('type','real_estate_maintenance_companies')->get();
        return Company::where('type','real_estate_companies')->get();
    }

    public function detailCompany($id){
        return Company::where('id',$id)->first();
    }

    public function createCompany($data){
        $data['image'] = $this->addPhoto($data['image'],'imagesCompanies/');

        return Company::create($data);
    }

    public function searchCompany($type , $name){
        return Company::where('type', $type)
        ->where('name', 'like', "%{$name}%")
        ->get();
    }

    public function deleteCompany($id){
        return Company::findOrFail($id)->delete();
    }


}
