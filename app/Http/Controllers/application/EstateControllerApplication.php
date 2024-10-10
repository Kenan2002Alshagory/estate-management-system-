<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEstateRequest;
use App\Http\Resources\EstateResource;
use App\Services\EstateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstateControllerApplication extends Controller
{
    protected $estateService;

    public function __construct(EstateService $estateService){
        $this->estateService = $estateService;
    }

    public function createEstate(CreateEstateRequest $request , $id = ''){
        $user = Auth::user();
        if($user->type == 'client' && $this->estateService->checkHasEstate($user->id)){
            return response()->json([
                'message' => 'you have a estate'
            ]);
        }
        $data = $request->all();
        $this->estateService->createEstate($data,$id);
        return response()->json([
            'message' => 'your estate created'
        ]);
    }

    public function allEstate(Request $request){
        $data = $request->all();
        if(!empty($data['start_price'])){
            $estate = $this->estateService->homeFilterEstate($data['type'],$data['start_price'],$data['end_price'],$data['code'],$data['year_of_construction']);
        }else if(empty($data['name'])){
            $estate = $this->estateService->allEstate($data['type']);
        }else{
            $estate = $this->estateService->allEstateSearch($data['type'],$data['name']);
        }
        return response()->json([
            'estate' => $estate
        ]);
    }

    public function deleteEstate($id){
        if(Auth::user()->id != $this->estateService->oneEstate($id)->user_id){
            return response()->json([
                'message'=>'you cant delete this estate'
            ],400);
        }
        $this->estateService->deleteEstate($id);
        return response()->json([
            'message'=>'the estate deleted'
        ]);
    }

    public function detailEstate($id){
        $estate = EstateResource::collection([$this->estateService->oneEstate($id)]);
        return response()->json([
            'estate' => $estate
        ]);
    }

    public function allEstateForOffice(Request $request){
        $data = $request->all();
        $user_id = Auth::user()->id;
        if(empty($data['name']) && empty($data['start_price'])){
            $estate = $this->estateService->allEstateForOffice($user_id,$data['type']);
        }else if(empty($data['start_price'])){
            $estate = $this->estateService->allEstateForOfficeSearch($user_id,$data['type'],$data['name']);
        }else{
            $estate = $this->estateService->homeFilterEstate($data['type'],$data['start_price'],$data['end_price'],$data['code'],$data['year_of_construction']);
        }
        return response()->json([
            'estate' => $estate
        ]);
    }

    public function countEstateForOffice(){
        $user_id = Auth::user()->id;
        return $this->estateService->countEstateForOffice($user_id);
    }

    public function estateForUserID(Request $request){
        $data = $request->all();
        $user_id = $data['user_id'];
        $estate = $this->estateService->allEstateForOffice($user_id,'all');
        return response()->json([
            'estate' => $estate
        ]);
    }



}
