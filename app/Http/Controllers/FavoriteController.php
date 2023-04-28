<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(){
        
        return view('favorites.index',[
            'title' => 'お気に入り一覧',
        ]);
    }
    
    // ログインチェック
    public function __construct()
    {
        $this->middleware('auth');
    }
}
