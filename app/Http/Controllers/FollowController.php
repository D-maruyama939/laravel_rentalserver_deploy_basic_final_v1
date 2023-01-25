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
        session()->flash('sucsess', 'フォローしました');
        return redirect()->route('posts.index');
    }
    
    // フォロー削除処理
    public function destroy($id){
        $follow = \Auth::user()->follows->where('follow_id',$id)->first();
        $follow->delete();
        session()->flash('success', 'フォロー解除しました');
        return redirect()->route('posts.index');
    }
    
    public function __construct()
    {
        $this->middleware('auth');
    }
}
