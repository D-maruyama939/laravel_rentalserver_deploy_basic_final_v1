<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagGroup extends Model
{
    // Tagモデルに対してリレーションを設定
    public function tags(){
        return $this->hasMany('App\Tag', 'group_id', 'id');
    }
}
