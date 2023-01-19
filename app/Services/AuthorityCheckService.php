<?php

namespace App\Services;

class AuthorityCheckService{
    
    public function is_owner($post){
        // アクセスユーザーが投稿者ならtrue、否なら警告を表示しfalseをリターン
        if($post->user_id !== \Auth::user()->id){
            return false;
        }else{
            return true;
        }
    }
    
    public function if_cheater_indicate_warning($is_result){
        // 不正なアクセスユーザーならば警告を表示
        if($is_result !== true){
            session()->flash('warning', '不正なアクセスです');
        }
    }
    
}