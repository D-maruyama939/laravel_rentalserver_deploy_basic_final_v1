<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function show(User $user){
        
        return view('users.show', [
            'title' => 'ユーザー詳細',
            'user' => $user,
            'posts' => $user->posts()->latest()->get(),
        ]);
    }
    
    public function __construct()
    {
        $this->middleware('auth');
    }
}
