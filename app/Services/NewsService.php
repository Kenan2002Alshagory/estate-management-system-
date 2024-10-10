<?php

namespace App\Services;

use App\Models\News;
use App\Models\NewsDepartment;
use App\Traits\AddPhotoTrait;

class NewsService{
    use AddPhotoTrait;

    public function allNews(){
        return News::with('departments')->get();
    }

    public function detailNews($id){
        return News::where('id',$id)->with('departments')->first();
    }

    public function createNews($data){

        $data['image'] = $this->addPhoto($data['image'],'imagesNews/');


        $news = News::create([
            'title'=>$data['title'],
            'body'=>$data['body'],
            'image'=>$data['image']
        ]);

        foreach($data['departments'] as $department){
            NewsDepartment::create([
                'title'=>$department['title'],
                'body'=>$department['body'],
                'video'=>$department['video'],
                'news_id'=>$news->id,
            ]);
        }

        return true;

    }
    
    public function deleteNews($id){
        return News::findOrFail($id)->delete();
    }

}
