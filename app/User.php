<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    
    // Postモデルに対してリレーションを設定
    public function posts(){
        return $this->hasMany('App\Post');
    }
    
    // 中間テーブル(フォロー)に対してのリレーション設定
    public function follows(){
        return $this->hasMany('App\Follow');
    }
    
    // 該当のユーザーがフォローしているユーザーを取得できるリレーションの設定
    // 第3引数:参照元のカラム名,第4引数:参照先のカラム名 => 参照先のカラムに紐づいたデータを取得できる。
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
    
    
}
