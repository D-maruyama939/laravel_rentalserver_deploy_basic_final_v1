@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    {{-- おすすめユーザー --}}
    <h2>おすすめユーザー</h2>
    <ul class="index_recommend_users">
        @forelse($recommended_users as $recommended_user)
            <li>
                <a href="{{ route('users.show', $recommended_user) }}">{{ $recommended_user->name }}</a>
                
                {{-- フォロー・削除ボタン --}}
                @if(Auth::user()->isFollowing($recommended_user))
                    <form method="post" action="{{ route('follows.destroy', $recommended_user) }}" class="index_recommend_user_follow">
                        @csrf
                        @method('delete')
                        <input type="submit" value="フォロー解除">
                    </form>
                @else
                    <form method="post" action="{{ route('follows.store') }}" class="index_recommend_user_follow">
                        @csrf
                        <input type="hidden" name="follow_id" value={{ $recommended_user->id }}>
                        <input type="submit" value="フォロー">
                    </form>
                @endif
            </li>
        @empty
            <li>他のユーザーが存在しません</li>
        @endforelse
    </ul>

    {{--タイムライン --}}
    <h2>タイムライン</h2>
    <ul class="index_posts">
        @forelse($posts as $post)
            <li class="index_post">
                <div class="index_post_name">
                    {{ $post->user->name }} ({{ $post->created_at }})
                </div>
                <div class="index_post_comment">
                    {!! nl2br(e($post->comment)) !!}
                </div>
                
                {{-- 編集・削除（ログインユーザーが投稿主の場合のみ表示） --}}
                @if(Auth::user()->id === $post->user_id)
                    <div>
                        <a href="{{ route('posts.edit',$post) }}">[編集]</a>
                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="index_post_delete">
                            @csrf
                            @method('delete')
                            <input type="submit" value="削除">
                        </form>
                    </div>
                @endif
            </li>
        @empty
            <li>投稿がありません</li>
        @endforelse
    </ul>
@endsection