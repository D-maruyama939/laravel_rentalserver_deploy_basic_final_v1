@extends('layouts.logged_in')

@section('title',$title)

@section('content')
    <h1>ユーザー詳細</h1>
    
    <div class="user_show">
        {{-- 詳細を表示するユーザーの名前 --}}
        <div class="user_show_name">
            {{ $user->name }}
        </div>
        
        {{-- フォロー・解除ボタン --}}
        @if(Auth::user()->id !== $user->id)
            @if(Auth::user()->isFollowing($user))
                <form method="post" action="{{ route('follows.destroy', $user) }}" class="user_show_follow">
                    @csrf
                    @method('delete')
                    <input type="submit" value="フォロー解除">
                </form>
            @else
                <form method="post" action="{{ route('follows.store') }}" class="user_show_follow">
                    @csrf
                    <input type="hidden" name="follow_id" value={{ $user->id }}>
                    <input type="submit" value="フォロー">
                </form>
            @endif
        @endif
        
        {{-- ユーザーの投稿一覧 --}}
        <ul class="user_show_posts">
            @forelse($posts as $post)
                <li>
                    <div class="user_show_post_name">
                        {{ $post->user->name }} ({{ $post->created_at }})
                    </div>
                    <div class="user_show_post_comment">
                        {!! nl2br(e($post->comment)) !!}
                    </div>
                    
                    {{-- 編集・削除ボタン（ログインユーザーが投稿主の場合のみ表示） --}}
                    @if(Auth::user()->id === $user->id)
                        <div>
                            <a href="{{ route('posts.edit',$post) }}">[編集]</a>
                            <form method="POST" action="{{ route('posts.destroy', $post) }}" class="user_show_post_delete">
                                @csrf
                                @method('delete')
                                <input type="submit" value="削除">
                            </form>
                        </div>
                    @endif
                </li>
            @empty
                <li>投稿はありません</li>
            @endforelse
        </ul>
    </div>
@endsection