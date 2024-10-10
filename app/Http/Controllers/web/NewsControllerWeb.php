<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewsRequest;
use App\Services\NewsService;

class NewsControllerWeb extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService){
        $this->newsService = $newsService;
    }

    public function allNews(){
        $news = $this->newsService->AllNews();
        if(count($news) === 0){   
            return response()->json(['message'=>'There are no News']);      
        }
        return response()->json($news,200);
    }

    public function detailsForNews($id){
        $news = $this->newsService->detailNews($id);
        if($news)
            return response()->json($news,200);
        return response()->json(['message'=>'Id is rong']);
    }

    public function createNews(CreateNewsRequest $request){
        $data = $request->all();
        $this->newsService->createNews($data);

        return response()->json([
            'message'=>'your news created'
        ]);
    }

    public function deleteNews($id){
        $this->newsService->deleteNews($id);
        return response()->json([
            'message' => 'news deleted'
        ]);
    }

}
