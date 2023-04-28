@extends('layouts.default')
 
@section('header')
<header>
    <nav class="navbar navbar-light bg-light fixed-top">
        <span class="navbar-brand">
            <img class="header_logo" src="{{ asset('images/logo.png') }}" alt="サイトロゴ">
        </span>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="{{ route('posts.index') }}" class="nav-link"><i class="fas fa-home"></i> HOME</a></li>
                <li class="nav-item"><a href="{{ route('posts.search_form') }}" class="nav-link"><i class="fas fa-search"></i> 投稿検索</a></li>
                <li class="nav-item"><a href="{{ route('posts.create_send_number_of_spots') }}" class="nav-link"><i class="fas fa-paper-plane"></i> 新規投稿</a></li>
                <li class="nav-item"><a href="{{ route('users.show', Auth::user()) }}" class="nav-link"><i class="fas fa-user"></i> ユーザーページ</a></li>
                <li class="nav-item"><a href="{{ route('favorites.index') }}" class="nav-link"><i class="fas fa-star"></i> お気に入り</a></li>
            </ul>
            
            {{-- ログアウトボタン --}}
            <ul class="navbar-nav mt-3 mb-1">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" >
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">ログアウト</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>
@endsection