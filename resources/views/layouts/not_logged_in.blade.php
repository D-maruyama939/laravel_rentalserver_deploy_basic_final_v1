@extends('layouts.default')

@section('header')
<header>
    <nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
        <span class="navbar-brand">
            <img class="header_logo" src="{{ asset('images/logo.png') }}" alt="サイトロゴ">
        </span>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link"><i class="fas fa-user-plus"></i> 新規登録</a></li>
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> ログイン</a></li>
            </ul>
        </div>
    </nav>
</header>
@endsection