<?php

namespace App\Services;

use App\Post_Tag;

class PostCreateService{
    
    // 投稿のタグを保存
    public function createPostTag($post, $request){
        foreach($request->tag_ids as $tag_id ){
            Post_Tag::create([
                'post_id' => $post->id,
                'tag_id' => $tag_id,
            ]);
        }
    }
}