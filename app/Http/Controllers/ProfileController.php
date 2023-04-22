<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Prefecture;
use App\Http\Requests\ProfileEditRequest;


class ProfileController extends Controller
{
    // プロフィール編集画面
    public function edit($id){
        return view('profile.edit',[
            'title' => 'プロフィール編集',
            'prefectures' => Prefecture::all(),
        ]);
    }
    
    // プロフィール編集処理
    public function update($id, ProfileEditRequest $request){
        \Auth::user()->update($request->only([
            'name',
            'comment',
            'prefecture_id',
        ]));
        
        session()->flash('success', 'プロフィールを編集しました');
        return redirect()->route('users.show', \Auth::user());
    }
    
    // ログインチェック
    public function __construct()
    {
        $this->middleware('auth');
    }
}
