<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit($user){
        
        return view('profile.edit',[
            'title' => 'プロフィール編集',
        ]);
    }
    
    public function update($user){
        
    }
}
