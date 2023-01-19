@extends('layouts.default')
 
@section('header')
<header>
    <ul class="header_nav_left">
        <li>
            <img class="header_logo" src="{{ asset('images/site_logo.jpg') }}" alt="サイトロゴ">
        </li>
        <li>
            <a href="{{ route('posts.index') }}">
                投稿一覧
            </a>
        </li>
    </ul>
    <ul class="header_nav_right">
        <li>
            <a href="{{ route('posts.create') }}">
                新規投稿
            </a>
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <input type="submit" value="ログアウト">
            </form>
        </li>
    </ul>
</header>
@endsection