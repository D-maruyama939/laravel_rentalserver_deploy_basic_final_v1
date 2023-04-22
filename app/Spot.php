<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    protected $fillable = [
        'post_id',
        'spot_img',
        'spot_name',
        'spot_comment'
    ];
}
