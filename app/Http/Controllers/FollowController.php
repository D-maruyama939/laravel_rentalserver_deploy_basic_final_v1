<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;

class FollowController extends Controller
{
    // フォロー追加処理
    public function store(Request $request){
        Follow::create([
            'user_id' => \Auth::user()->id,
            'follow_id' => $request->follow_id,
        ]);
        session()->flash('success', 'フォローしました');
        return redirect()->route('users.show', $request->follow_id);
    }
    
    // フォロー削除処理
    public function destroy($id){
        $follow = \Auth::user()->follows->where('follow_id',$id)->first();
        $follow->delete();
        session()->flash('success', 'フォロー解除しました');
        return redirect()->route('users.show', $id);
    }
    
    // フォロー一覧
    public function index(){
        return view('follows.index',[
            'title' => 'フォロー一覧'
        ]);
    }
    
    // ログインチェック
    public function __construct()
    {
        $this->middleware('auth');
    }
}
