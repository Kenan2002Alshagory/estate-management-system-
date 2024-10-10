<?php


namespace App\Traits;

trait AddPhotoTrait {
    public function addPhoto($image,$path)
    {
        // $file = $data['image']; 'imagesCompanies/'
        $fileName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('storage/'.$path), $fileName);
        $image = 'storage/'.$path . $fileName;
        return $image;
    }
}
