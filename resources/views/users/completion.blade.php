@extends('layouts.logged_in')

@section('title',$title)

@section('content')
    <h1>以下の内容で登録しました</h1>
    
    <div class="container completion">
        <div class="row">
            <div class="col-lg-3 col-4">名前</div>
            <div class="col-lg-9 col-8 text-left">{{ Auth::user()->name }}</div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-4">居住地</div>
            <div class="col-lg-9 col-8 text-left completion_text">{{ Auth::user()->prefecture->prefecture }}</div>
        </div>
        
        <diV class="row">
            <div class="col-lg-3 col-4">生年月日</div>
            <div class="col-lg-9 col-8 text-left">
                {{ explode('-',Auth::user()->birthdate)[0] }}年
                {{ explode('-',Auth::user()->birthdate)[1] }}月
                {{ explode('-',Auth::user()->birthdate)[2] }}日
            </div>
        </diV>
        
        <div class="row">
            <div class="col-lg-3 col-4">メールアドレス</div>
            <div class="col-lg-9 col-8 text-left">{{ Auth::user()->email }}</div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-4">パスワード</div>
            <div class="col-lg-9 col-8 text-left">非表示</div>
        </div>
        
        <div class="row mt-3">
            <div class="text-left">
                <a class="btn btn-primary" href="{{ route('posts.index') }}">HOMEへ</a>
            </div>
        </div>
    </div>
@endsection