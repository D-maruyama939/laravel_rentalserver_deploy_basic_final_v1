@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('patch')
        <div>
            <label>
                <div>コメント:</div>
                <textarea name="comment" rows="20" cols="60">{{ $post->comment }}</textarea>
            </label>
        </div>
        
        <input type="submit" value="更新">
    </form>
@endsection