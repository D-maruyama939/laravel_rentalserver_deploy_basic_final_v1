@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <!--投稿フォーム-->
    <!--POSTメソッドでPOSTコントローラのstoreメソッドにアクセス-->
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <div>
            <label>
                <div>コメント:</div>
                <textarea name="comment" rows="20" cols="60"></textarea>
            </label>
        </div>
        
        <input type="submit" value="投稿">
    </form>
@endsection