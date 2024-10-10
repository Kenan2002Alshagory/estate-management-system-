<?php

namespace App\Services;

use App\Http\Resources\EstateResource;
use App\Models\Estate;
use App\Traits\AddPhotoTrait;
use Illuminate\Support\Facades\Auth;

class EstateService{

    use AddPhotoTrait;

    public function createEstate($data , $id){
        $data;
        $data['user_id'] = Auth::user()->id;
        if(array_key_exists('3d_photo', $data)){
            $data['3d_photo'] = $this->addPhoto($data['3d_photo'],'images3DEstate/');
        }
        if(array_key_exists('blueprint', $data)){
        $data['blueprint'] = $this->addPhoto($data['blueprint'],'blueprintEstate/');
        }
        if(array_key_exists('video_url', $data)){
        $data['video_url'] = $this->addPhoto($data['video_url'],'videoEstate/');
        }

        $photos = $data['photos'];
        $count = 0;
        foreach($photos as $photo){
            $photo = $this->addPhoto($photo,'imagesEstate/');
            $data['photos'][$count] = $photo;
            $count++;
        }
        $data['photos'] = json_encode($data['photos']);
        $data['geo_location'] = json_encode($data['geo_location']);
        $data['filters'] = json_encode($data['filters']);
        $data['services'] = json_encode($data['services']);
        if(empty($id)){
            $estate = Estate::create($data);
        }else{
            $estate = Estate::updateOrCreate(
                ['id' => $id],  // Search for a user with id = 5
                $data  // Update or create with this data
            );
        }
        $estate->code = $estate->id.chr(rand(65, 90));
        $estate->save();


        return $estate;
    }

    public function allEstate($type){
        if($type == 'all'){
            return EstateResource::collection(Estate::all());
        }else if($type == 'sale' || $type == 'rent'){
            /////////////////rent _ sale
            return EstateResource::collection(
                Estate::where('type',$type)
                ->get()
            );
        }
        ///////////////commercial _ residential
        return EstateResource::collection(
            Estate::where('property_category',$type)
            ->get()
        );
    }

    public function allEstateSearch($type,$name){
        if($type == 'all'){
            return EstateResource::collection(
                Estate::where("name","like","%{$name}%")
                ->get()
            );
        }else if($type == 'sale' || $type == 'rent'){
            /////////////////rent _ sale
            return EstateResource::collection(
                Estate::where('type',$type)
                ->where("name","like","%{$name}%")
                ->get()
            );
        }
        ///////////////commercial _ residential
        return EstateResource::collection(
            Estate::where('property_category',$type)
            ->where("name","like","%{$name}%")
            ->get()
        );
    }

    public function deleteEstate($id){
        return Estate::findOrFail($id)->delete();
    }

    public function oneEstate($id){
        return Estate::findOrFail($id);
    }

    public function allEstateForOffice($user_id,$type){
        if($type == 'all'){
            return EstateResource::collection(Estate::where('user_id',$user_id)->get());
        }
        return EstateResource::collection(Estate::where('user_id',$user_id)->where('type',$type)->get());
    }

    public function allEstateForOfficeSearch($user_id,$type,$name){
        if($type == 'all'){
            return EstateResource::collection(Estate::where('user_id',$user_id)
            ->where("name","like","%{$name}%")->get());
        }
        return EstateResource::collection(Estate::where('user_id',$user_id)->where('type',$type)
        ->where("name","like","%{$name}%")->get());
    }

    public function countEstateForOffice($user_id){
        $rent = Estate::where('user_id',$user_id)
        ->where('type','rent')->count();
        $rented = Estate::where('user_id',$user_id)
        ->where('type','rented')->count();
        $sale = Estate::where('user_id',$user_id)
        ->where('type','sale')->count();
        $sold = Estate::where('user_id',$user_id)
        ->where('type','sold')->count();
        return response()->json([
            'rent' => $rent,
            'rented' => $rented,
            'sale' => $sale,
            'sold' => $sold,
        ]);
    }

    public function checkHasEstate($user_id){
        return Estate::where('user_id',$user_id)->first();
    }

    public function homeFilterEstate($type,$start_price,$end_price,$code,$year_of_construction){
        return EstateResource::collection(
            Estate::where('type',$type)
            ->where("code","like","%{$code}%")
            ->whereBetween('price', [$start_price, $end_price])
            ->whereRaw('YEAR(year_of_construction) = ?', [$year_of_construction])
            ->get()
        );
    }
}
