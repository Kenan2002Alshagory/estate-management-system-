<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteControllerApplication extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService){
        $this->favoriteService = $favoriteService;
    }

    public function addFav($estate_id){
        $user = Auth::user();
        if(!$this->favoriteService->oneFav($user,$estate_id)){
            $this->favoriteService->addFav($user,$estate_id);
            return response()->json([
                'message' => 'Favorite added'
            ]);
        }
        return response()->json([
            'message' => 'Estate is already added'
        ],400);  
    }

    public function removeFav($estate_id){
        $user = Auth::user();
        if($this->favoriteService->oneFav($user,$estate_id)){
            $this->favoriteService->removeFav($user,$estate_id);
            return response()->json([
                'message' => 'Favorite removed'
            ]);
        }
        return response()->json([
            'message' => 'Estate is not favorite for removed'
        ],400);
    }

    public function ShowFav(){
        $user = Auth::user();
        $estate = $this->favoriteService->ShowFav($user);
        return response()->json([
            'estate' => $estate
        ]);
    }
}
