<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\Services\AuthorityCheckService;
use App\User;

class PostController extends Controller
{
    public function index(Request $request){
        // ログインユーザーがフォローしているユーザーのidを取得
        $follow_user_ids = \Auth::user()->follow_users->pluck('id');
        // ログインユーザーが未フォローのユーザーを新着順でで3件取得
        $recommended_users = User::whereNotIn('id', $follow_user_ids)->where('id', '<>', \Auth::user()->id)->latest()->limit(3)->get();
        
        // 検索ワードの受け取り
        $search_word = $request->search_word;
        
        if(isset($search_word)){
            // 検索処理をし対象の投稿を取得
            $posts = Post::where('user_id', '<>', \Auth::user()->id)->where('comment', 'like', "%$search_word%")->latest()->get();
        }else{
            // ログインユーザーとフォローユーザーの投稿を取得
            $posts = \Auth::user()->posts()->orWhereIn('user_id', $follow_user_ids)->latest()->get();
        }
       
        return view('posts.index',[
            'title' => '投稿一覧',
            'posts' => $posts,
            'recommended_users' => $recommended_users,
            'search_word' => $search_word,
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
