<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;

use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsControllerApplication extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService){
        $this->newsService = $newsService;
    }

    public function allNews(){
        $news = $this->newsService->AllNews();
        return response()->json([
            'news' => $news
        ],200);
    }

    public function detailsForNews($id){
        $news = $this->newsService->detailNews($id);
        return response()->json([
            'news' => $news
        ],200);
    }

}


