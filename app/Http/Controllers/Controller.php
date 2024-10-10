<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}


// <?php

// namespace App\Http\Controllers;

// use App\Models\News;
// use App\Services\NewsService;
// use Illuminate\Http\Request;

// class NewsControllerWeb extends Controller
// {
//     protected $newsService;

//     public function __construct(NewsService $newsService){
//         $this->newsService = $newsService;
//     }

//     public function createNews(Request $request){
//         $data = $request->all();
//         $this->newsService->createNews($data);
//         return response()->json([
//             'message'=>'your message created'
//         ]);
//     }

// }













// <?php

// namespace App\Http\Controllers;

// use App\Models\News;
// use App\Services\NewsService;
// use Illuminate\Http\Request;

// class NewsControllerApplicatione extends Controller
// {
//     protected $newsService;

//     public function __construct(NewsService $newsService){
//         $this->newsService = $newsService;
//     }

//     public function allNews(){
//         $news = $this->newsService->AllNews();
//         return response()->json($news,200);
//     }

//     public function detailsForNews($id){
//         $news = $this->newsService->detailNews($id);
//         return response()->json($news,200);
//     }

// }
