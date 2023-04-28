@extends('layouts.logged_in')

@section('title',$title)

@section('content')
    <h1 class="mb-4">{{ Auth::user()->name}} がお気に入りした投稿</h1>
    
    {{-- 投稿を表示 --}}
    @forelse(Auth::user()->favoritePosts()->withPivot('created_at AS favorite_created_at')->orderBy('favorite_created_at', 'desc')->get() as $post)
        {{-- 投稿をカードで表示 --}}
        <div class="card post">
            {{-- カードヘッダー --}}
            <div class="card-header">
                <div class="row">
                    {{-- 投稿タイトル --}}
                    <h4 class="mb-0 col-9">
                        {{ $post->title }}
                    </h4>
                
                    {{-- 投稿者名 --}}
                    <div class="col-3 text-right">
                        <a href={{ route('users.show', $post->user ) }}>
                            <i class="fas fa-user"></i>
                            {{ $post->user->name }}
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- カードボディ --}}
            <div class="card-body"> 
                {{-- 投稿の各スポットをカルーセルで表示 --}}
                <div id="cl_{{ $loop->index }}" class="carousel slide" data-ride="false"> {{-- $loop->index :現在のループのインデックス --}}
                    {{-- インジゲーター --}}
                    <ol class="carousel-indicators">
                        @foreach($post->spots as $spot)
                            <li
                                data-target="#cl_{{ $loop->parent->index }}" {{-- $loop->parent->index :現在のループの親ループのインデックス --}}
                                data-slide-to="{{ $loop->index }}" 
                                @if($loop->first) {{-- $loop->first :現在のループのインデックスが0ならtrue --}}
                                    class="active"
                                @endif
                            ></li>
                        @endforeach
                    </ol>
                    
                    {{-- カルーセルメイン部分 --}}
                    <div class="carousel-inner">
                        @foreach($post->spots()->oldest()->get() as $spot)
                            <div class="
                                carousel-item
                                @if($loop->first)
                                    active
                                @endif
                            ">
                                {{-- スポットインデックス --}}
                                <div class="mb-1">
                                    [ スポット {{ $loop->iteration }} / {{ $loop->count }} ]
                                </div>
                                
                                <div class="container">
                                    <div class="row">
                                        {{-- スポット画像 --}}
                                        <div class="col-md-6 col-12">
                                            <img src="{{ asset('storage/' .$spot->spot_img) }}" class="d-block w-100">
                                        </div>
                                        
                                        <div clas="col-md-6 col-12">
                                            {{-- スポット名 --}}
                                            <h5 class="mt-md-0 mt-2">
                                                <i class="fas fa-map-pin"></i>
                                                {{ $spot->spot_name }}
                                            </h5>
                                
                                            {{-- スポットコメント --}}
                                            <div>
                                                <i class="fas fa-comment-dots"></i>
                                                {!! nl2br(e($spot->spot_comment)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- previous(前に戻る),同様にnext(次へ進む）ボタン --}}
                    <a class="carousel-control-prev" href="#cl_{{ $loop->index }}" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#cl_{{ $loop->index }}" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
            
            {{-- カードフッター --}}
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row bd-highlight">
                        {{-- お気に入りボタン --}}
                        <div class="bd-highlight d-flex align-items-center">
                            <a class="favorite_button">
                                @if($post->isFavoritedBy(Auth::user()))
                                    {{-- 既にお気に入り済みならば --}}
                                    <i class="fas fa-heart favorite_mark"></i>
                                @else
                                    {{-- お気に入りされていなければ --}}
                                    <i class="far fa-heart"></i>
                                @endif
                        
                                {{-- お気に入りの件数 --}}
                                {{ $post->favorites()->count() }} 
                            </a>
                            <form method="post" class="favorite" action="{{ route('posts.toggle_favorite', $post) }}">
                                @csrf
                                @method('patch')
                            </form>
                        </div>
                        
                        {{-- Line共有ボタン --}}
                        <div class="pl-3 pt-2">
                            <div class="line-it-button" data-lang="ja" data-type="share-a" data-env="REAL" data-url="https://dm-system-product.tokyo/posts?post_id={{ $post->id }}" data-color="default" data-size="small" data-count="false" data-ver="3" style="display: none;"></div>
                        </div>
                    </div>
                    
                    {{-- 編集・削除ボタン --}}
                    @if(Auth::user()->id === $post->user_id)
                        <div>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i> 編集
                            </a>
                            
                            <a class="btn btn-secondary btn-sm text-light" data-toggle="modal" data-target="#modal_tl{{ $post->id }}">
                                <i class="fas fa-trash-alt"></i> 削除
                            </a>
                            
                            
                            {{-- 削除確認モーダル --}}
                            <div class="modal fade" id="modal_tl{{ $post->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">投稿削除確認</h3>
                                            <button class="close" data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            本当にこの投稿を削除しますか？
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-outline-info" data-dismiss="modal">キャンセル</button>
                                            <form method="post" action="{{ route('posts.destroy', $post) }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-secondary">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                    
                <div>
                    {{-- 都道府県名 --}}
                    <i class="fas fa-map-marked-alt"></i>
                    {{ $post->prefecture->prefecture }} / 
                    
                    {{-- 投稿日時のフォーマットを変更し表示 --}}
                    {{ \Carbon\Carbon::parse($post->created_at)->format("Y年 m月 d日") }} 
                </div>
                
                {{-- タグ --}}
                <div>
                    <i class="fas fa-tags"></i>
                    @foreach($post->tags as $tag)
                        <a class="btn btn-outline-primary btn-sm d-inline-block mt-1" href="/posts?tag_ids%5B%5D={{ $tag->id }}">{{ $tag->tag_name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="mb-5">お気に入りはありません</div>
    @endforelse
    {{-- Line共有ボタン JS --}}
    <script src="https://www.line-website.com/social-plugins/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
    {{-- お気に入りボタン JS --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        /* global $ */
        $('.favorite_button').each(function(){
            $(this).on('click', function(){
                $(this).next().submit();
            });
        });
    </script>
@endsection