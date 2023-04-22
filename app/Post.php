<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'prefecture_id',
        'title'
    ];
    
    // リレーション設定
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function spots(){
        return $this->hasMany('App\Spot');
    }
    
    // タグに関するリレーション
    public function postTags(){
        return $this->hasMany('App\Post_Tag');
    }
    public function tags(){
        return $this->belongsToMany('App\Tag', 'post__tags');
    }
    
    public function prefecture(){
        return $this->belongsTo('App\Prefecture');
    }
    
    // お気に入りに対するリレーション・メソッド
    public function favorites(){
        return $this->hasMany('App\Favorite');
    }
    public function favoritedUsers(){
        return $this->belongsToMany('App\User', 'favorites');
    }
    // 投稿にお気に入りをしているか判別するメソッド
    public function isFavoritedBy($user){
        $favorited_users_ids = $this->favoritedUsers->pluck('id'); //当該の投稿をいいねしているユーザーのidのみ取得
        $result = $favorited_users_ids->contains($user->id); //取得したidに$userのidが含まれていればtrue,否ならfalseをリターン
        return $result;
    }
}
