<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\Services\AuthorityCheckService;
use App\User;
use App\Prefecture;
use App\TagGroup;
use App\Http\Requests\PostNumberOfSpotsRequest;
use App\Spot;
use App\Services\FileUploadService;
use App\Favorite;
use App\Http\Requests\PostEditRequest;
use App\Services\PostCreateService;
use App\Http\Requests\PostSearchRequest;
use App\Tag;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // HOME画面（投稿一覧）
    public function index(PostSearchRequest $request){
        // 初期化
        $key_word = '';
        $prefecture = '';
        $tags = '';
        $post_id = '';
        
        $post_query = Post::query();
        
        // 都道府県名・タイトル・スポット名・スポットコメント・タグのいずれかにキーワードを含む投稿を取得するクエリビルダを追加
        if(isset($request->key_word)){
            $key_word = $request->key_word;
            
            $post_ids = DB::table('posts')
                ->select('posts.id') //posts.idを取得
                ->join('spots', 'posts.id', '=', 'spots.post_id') //検索に必要なテーブルを結合
                ->join('prefectures', 'posts.prefecture_id', '=', 'prefectures.id')
                ->join('post__tags', 'posts.id', '=', 'post__tags.post_id')
                ->join('tags', 'post__tags.tag_id', '=', 'tags.id')
                ->where(DB::raw('CONCAT(posts.title, spots.spot_name, spots.spot_comment, prefectures.prefecture, tags.tag_name)'), 'like', "%$key_word%") //キーワードを含むレコードを絞り込み
                ->groupBy('posts.id') //posts.idを基準に重複を除外
                ->get()
                ->pluck('id'); //該当する投稿のidを取得
                
            $post_query->whereIn('id', $post_ids);
        }
        
        // 選択された都道府県が設定されている投稿を取得するクエリビルダを追加
        if(isset($request->prefecture_id)){
            $prefecture = Prefecture::find($request->prefecture_id);
            $post_query->where('prefecture_id', $request->prefecture_id);
        }
        
        // 選択されたタグが全て設定されている投稿を取得するクエリビルダを追加
        if(isset($request->tag_ids)){
            $tags = Tag::whereIn('id', $request->tag_ids)->get();
            
            foreach($request->tag_ids as $tag_id){ //選択されたタグのidをループで回し、選択されたタグすべてを持つ投稿を絞り込むクエリビルダを生成
                $post_query->whereHas('tags', function($query) use($tag_id){
                    $query->where('tags.id', $tag_id);
                });
            };
        }
        
        // 投稿のidが指定されていれば、対応する投稿を取得するクエリビルダを生成
        if(isset($request->post_id)){
            $post_id = $request->post_id;
            $post_query->where('id', $request->post_id);
        }
        
        // 検索条件がなければ、タイムラインを取得し、おすすめの投稿を絞り込むクエリビルダを生成
        $time_line_posts = null;
        if($key_word==='' && $prefecture==='' && $tags==='' && $post_id===''){
            // タイムラインを取得
            $follow_user_ids = \Auth::user()->follow_users->pluck('id');
            $time_line_posts = \Auth::user()->posts()->orWhereIn('user_id', $follow_user_ids )->latest()->get();


            // おすすめの投稿を取得
            if(\Auth::user()->favorites()->count() !== 0){
                // ユーザーがお気に入りした投稿にお気に入りしたユーザーズが、お気に入りしている投稿をお気に入り数ランキングにして上位5件を取得->ランダムに2件表示
                $user_id = \Auth::user()->id;
                $my_favorite_post_ids = Favorite::where('user_id', $user_id)->get()->pluck('post_id'); //自分ががお気に入りした投稿のidを取得
                $favorited_my_favorite_user_ids = Favorite::whereIn('post_id', $my_favorite_post_ids)->where('user_id', '<>', $user_id)->get()->pluck('user_id')->unique(); //自分がお気に入りした投稿にお気に入りしたユーザーのidを重複をのぞいて取得
                
                $recommend_post_ids = DB::table('favorites')
                    ->select('post_id', DB::raw('count(favorites.post_id) as count_post')) //favoritesテーブルからpost_idとcount_post(post_idの出現回数をcount_postというカラムに格納したもの)を抜き出す
                    ->whereIn('user_id', $favorited_my_favorite_user_ids) //$favorited_my_favorite_user_ids にuser_idが含まれている投稿を絞り込み
                    ->groupBy('post_id') //post_idでクループ化
                    ->orderBy('count_post', 'desc') //count_postの大きさで降順に並び替え
                    ->limit(5) // ランキングの上位5件を取得
                    ->get()
                    ->shuffle()
                    ->take(2)
                    ->pluck('post_id');
                
                $posts = Post::whereIn('id', $recommend_post_ids)->get();
            }else{
                // ユーザーのお気に入りがない場合はランダムに2件取得
                $posts = Post::inRandomOrder()->limit(2)->get();
            }
            
        }else{
            // 検索条件がセットされていれば、条件に該当するの投稿を取得
            $posts = $post_query->latest()->get();
        }
        
        
        return view('posts.index',[
            'title' => 'HOME',
            'posts' => $posts,
            'time_line_posts' => $time_line_posts,
            'key_word' => $key_word,
            'prefecture' => $prefecture,
            'tags' => $tags,
            'post_id' => $post_id,
        ]);
    }
    
    // 新規投稿画面 1/2（投稿のスポット数を選択する画面）
    public function create_send_number_of_spots(){
        return view('posts.create_send_number_of_spots',[
            'title' => '新規投稿フォーム１'
        ]);
    }
    
    // 新規投稿画面 2/2（投稿のメインフォーム画面）
    public function create_main(PostNumberOfSpotsRequest $request){
        return view('posts.create',[
            'title' => '新規投稿フォーム２',
            'prefectures' => Prefecture::all(),
            'tag_groups' => TagGroup::all(),
            'number_of_spots' => $request->number_of_spots,
        ]);
    }
    
    // 投稿投稿作成処理
    public function store(PostRequest $request, AuthorityCheckService $authority_check_service, FileUploadService $file_upload_service, PostCreateService $post_create_service){
    //public function store(Request $request, AuthorityCheckService $authority_check_service, FileUploadService $file_upload_service, PostCreateService $post_create_service){

        // スポット数、スポットに関する各項目（spot_names,spot_images,spot_comments）に不正がないかチェック
        $is_result = $authority_check_service->is_legal_number_of_spots_and_array_keys_for_store($request);
        // 不正があれば、リダイレクトして警告を表示
        $authority_check_service->if_cheater_indicate_warning($is_result);
        if($is_result !== true){
            return redirect()->route('posts.index');
        }
        
        // 投稿の都道府県・タイトルを保存
        $post = Post::create([
            'user_id' => \Auth::user()->id,
            'prefecture_id' => $request->prefecture_id,
            'title' => $request->title,
        ]);
        
        // 投稿のスポット部分を保存
        for($i = 0; $i <= $request->number_of_spots-1; $i++){
            Spot::create([
                'post_id' => $post->id,
                'spot_img' => $file_upload_service->saveImage($request->file('spot_images')[$i]), // spot_image[$i]に画像がセットされていれば、保存しファイルパスをリターン。否ならば''をリターン
                'spot_name' => $request->spot_names[$i],
                'spot_comment' => $request->spot_comments[$i],
            ]);
        }
        
        // 投稿のタグ部分を保存
        $post_create_service->createPostTag($post, $request);
        
        session()->flash('success', '投稿を追加しました');
        return redirect()->route('posts.index');
    }
    
    // 投稿編集画面
    public function edit(Post $post, AuthorityCheckService $service){
        // 該当の投稿がログインユーザーの投稿かチェック、不正なアクセスならばリダイレクトし警告を表示
        $is_result = $service->is_owner($post);
        $service->if_cheater_indicate_warning($is_result);
        if($is_result !== true){
            return redirect()->route('posts.index');
        }
        
        return view('posts.edit', [
            'title' => '投稿編集フォーム',
            'post' => $post,
            'prefectures' => Prefecture::all(),
            'tag_groups' => TagGroup::all(),
        ]);
    }
    
    // 投稿編集処理
    public function update(Post $post, PostEditRequest $request, AuthorityCheckService $authority_check_service, FileUploadService $file_upload_service, PostCreateService $post_create_service){
        // 該当の投稿がログインユーザーの投稿かチェック
        $is_result = $authority_check_service->is_owner($post);
        // 不正なアクセスならばリダイレクトし警告を表示
        $authority_check_service->if_cheater_indicate_warning($is_result);
        if($is_result !== true){
            return redirect()->route('posts.index');
        }
        
        // スポット画像が新たに登録されたキーを取得、画像が登録されていなければnullを代入
        $spot_image_keys = (array)null; //画像更新処理で用いるin_array関数の都合で、配列として初期化
        if(isset($request->spot_images)){
            $spot_image_keys = array_keys($request->spot_images);
        }
        
        // フォームに不正が無いかチェック
        $is_result = $authority_check_service->is_legal_array_keys_for_edit($request, $post, $spot_image_keys);
        // 不正な操作がされていればリダイレクトし警告を表示
        $authority_check_service->if_illegal_indicate_warning($is_result);
        if($is_result !== true){
            return redirect()->route('posts.index');
        }
        
        // 更新処理
        // 都道府県・タイトルを更新
        $post->update([
            'prefecture_id' => $request->prefecture_id,
            'title' => $request->title,
        ]);
        
        // スポットを更新
        foreach($post->spots()->oldest()->get() as $index => $spot){
            $spot->update([ //スポット[$index]のスポット名と、コメントを更新
                'spot_name' => $request->spot_names[$index],
                'spot_comment' => $request->spot_comments[$index],
            ]);
            
            if(in_array($index, $spot_image_keys)){ //スポット[$index]に新たな画像がセットされていれば、画像を更新
                $path = $file_upload_service->saveImage($request->file('spot_images')[$index]); //ファイルをアップロード
                if($spot->spot_img  !== ''){
                    \Storage::disk('public')->delete('users_image/' . $spot->spot_image); //既存のファイルを削除
                }
                $spot->update([
                    'spot_img' => $path, //新画像のファイルパスを保存
                ]);
            }
        }
        
        // 投稿のタグを更新
        foreach($post->postTags as $post_tag){
            $post_tag->delete(); //既に設定されているタグを全て削除
        }
        $post_create_service->createPostTag($post, $request); //新たにタグを設定
        
        session()->flash('success', '投稿を編集しました');
        return redirect()->route('posts.index');
    }
    
    // 投稿削除処理
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
    
    // 投稿のお気に入り追加・削除処理
    public function toggleFavorite(Post $post){
        $user = \Auth::user();
        
        if($post->isFavoritedBy($user)){
            // 既にお気に入りしていれば取り消し
            $post->favorites->where('user_id', $user->id)->first()->delete();
            session()->flash('success', 'お気に入りを解除しました');
        }else{
            // お気に入りされていなければお気に入り追加
            Favorite::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            session()->flash('success', 'お気に入りに追加しました');
        }
        
        return redirect()->route('posts.index');
    }
    
    // 投稿検索画面
    public function search_form(){
        return view('posts.search_form',[
            'title' => '投稿検索',
            'prefectures' => Prefecture::all(),
            'tag_groups' => TagGroup::all(),
        ]);
    }
    
    // ログインチェック
    public function __construct()
    {
        $this->middleware('auth');
    }
}
