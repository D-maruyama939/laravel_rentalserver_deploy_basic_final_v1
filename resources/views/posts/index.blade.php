@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <ul class="index_posts">
        @forelse($posts as $post)
            <li class="index_post">
                <div class="index_post_name">
                    {{ $post->user->name }} ({{ $post->created_at }})
                </div>
                <div class="index_post_comment">
                    {!! nl2br(e($post->comment)) !!}
                </div>
                <div>
                    <a href="{{ route('posts.edit',$post) }}">[編集]</a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="index_post_delete">
                        @csrf
                        @method('delete')
                        <input type="submit" value="削除">
                    </form>
                </div>
            </li>
        @empty
            <li>投稿がありません</li>
        @endforelse
    </ul>
@endsection