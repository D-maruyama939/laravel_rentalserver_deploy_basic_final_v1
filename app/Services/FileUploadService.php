<?php
 
namespace App\Services;
 
class FileUploadService {
 
    public function saveImage($image){
        $path = '';
        if( isset($image) === true ){
            $path = $image->store('users_image', 'public');
        }
        
        // 画像が存在する場合はファイルパス、しない場合は''をリターン
        return $path;
    }
}