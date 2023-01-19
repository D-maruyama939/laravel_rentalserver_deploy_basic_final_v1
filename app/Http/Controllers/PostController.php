<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\Services\AuthorityCheckService;

class PostController extends Controller
{
    public function index(){
        $posts = Post::where('user_id',\Auth::user()->id)->latest()->get();
        return view('posts.index',[
            'title' => '投稿一覧',
            'posts' => $posts,
        ]);
    }
    
    public function create(){
        return view('posts.create',[
            'title' => '新規投稿フォーム',
        ]);
    }
    
    public function store(PostRequest $request){
        Post::create([
            'user_id' => \Auth::user()->id,
            'comment' => $request->comment,
        ]);
        session()->flash('success', '投稿を追加しました');
        return redirect()->route('posts.index');
    }
    
    public function edit(Post $post, AuthorityCheckService $service){
        
        // 該当の投稿がログインユーザーの投稿かチェック
        $is_result = $service->is_owner($post);
        // 不正なアクセスならば、リダイレクトし警告を表示
        $service->if_cheater_indicate_warning($is_result);
        if($is_result !== true){
            return redirect()->route('posts.index');
        }
        
        return view('posts.edit', [
            'title' => '投稿編集フォーム',
            'post' => $post,
        ]);
    }
    
    public function update(Post $post, PostRequest $request, AuthorityCheckService $service){
        
        // 該当の投稿がログインユーザーの投稿かチェック
        $is_result = $service->is_owner($post);
        // 不正なアクセスならば、リダイレクトし警告を表示
        $service->if_cheater_indicate_warning($is_result);
        if($is_result !== true){
            return redirect()->route('posts.index');
        }
        
        // 更新処理
        $post->update($request->only(['comment']));
        
        session()->flash('success', '投稿を編集しました');
        return redirect()->route('posts.index');
    }
    
    public function destroy(Post $post, AuthorityCheckService $service){
        
        // 該当の投稿がログインユーザーの投稿かチェック
        $is_result = $service->is_owner($post);
        // 不正なアクセスならば、リダイレクトし警告を表示
        $service->if_cheater_indicate_warning($is_result);
        if($is_result !== true){
            return redirect()->route('posts.index');
        }
        
        // 削除処理
        $post->delete();
        
        session()->flash('success', '投稿を削除しました');
        return redirect()->route('posts.index');
    }
    
    public function __construct()
    {
        $this->middleware('auth');
    }
}
