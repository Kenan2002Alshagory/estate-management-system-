<?php

namespace App\Services;

use App\Http\Resources\EstateResource;
use App\Models\Estate;
use App\Models\FavoriteEstate;
use Illuminate\Database\Eloquent\Collection;

class FavoriteService {

    public function addFav($user,$estate_id){
        return $user->favoriteEstates()->attach($estate_id);
    }

    public function removeFav($user,$estate_id){
        return $user->favoriteEstates()->detach($estate_id);
    }

    public function ShowFav($user){
        $estate_id = FavoriteEstate::where('user_id',$user->id)->pluck('estate_id');
        return EstateResource::collection(Estate::whereIn('id',$estate_id)->get());
    }

    public function oneFav($user,$id){
        return FavoriteEstate::where('user_id',$user->id)->where('estate_id',$id)->first();
    }
}