<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    // ユーザー詳細画面
    public function show(User $user){
        return view('users.show', [
            'title' => 'ユーザー詳細',
            'user' => $user,
        ]);
    }
    
    // 新規登録完了画面
    public function completion(){
        return view('users.completion',[
            'title' => '登録完了',
        ]);
    }
    
    // ログインチェック
    public function __construct()
    {
        $this->middleware('auth');
    }
}
