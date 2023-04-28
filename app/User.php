<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','prefecture_id','birthdate', 'comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    // リレーションを設定
    public function posts(){
        return $this->hasMany('App\Post');
    }
    
    // フォローに関するリレーション・メソッド
    // 中間テーブル(フォロー)に対してのリレーション設定
    public function follows(){
        return $this->hasMany('App\Follow');
    }
    // 該当のユーザーがフォローしているユーザーを取得できるリレーションの設定 (第3引数:参照元のカラム名,第4引数:参照先のカラム名 => 参照先のカラムに紐づいたデータを取得できる。)
    public function follow_users(){
        return $this->belongsToMany('App\User','follows','user_id','follow_id');
    }
    // 該当のユーザーのフォロワーを取得できるリレーションを設定
    public function followers(){
        return $this->belongsToMany('App\User','follows','follow_id','user_id');
    }
    // $userをフォローしているか判定するメソッド
    public function isFollowing($user){
        $result = $this->follow_users->pluck('id')->contains($user->id);
        return $result;
    }
    
    public function prefecture(){
        return $this->hasOne('App\Prefecture','id','prefecture_id');
    }
    
    // お気に入りに関するリレーション
    public function favorites(){
        return $this->hasMany('App\Favorite');
    }
    public function favoritePosts(){
        return $this->belongsToMany('App\Post', 'favorites');
    }
    
    // ユーザーの年代を取得するメソッド
    public function getAgeGroup($user){
        $age = Carbon::parse($user->birthdate)->age;
        $age_group = floor($age/10) * 10;
        if($age_group < 10){
            $result = '10歳未満';
        }else{
            $result = $age_group . '代';
        }
        
        return $result;
    }
}
