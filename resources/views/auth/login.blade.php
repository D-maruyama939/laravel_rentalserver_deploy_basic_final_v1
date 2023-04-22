@extends('layouts.not_logged_in')

@section('content')
    <h1>ログイン画面</h1>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group form-row">
            <label for="email" class="col-md-12">メールアドレス（ID）</label>
            <div class="col-md-5">
                <input type="email" name="email" class="form-control" id="email">
            </div>
        </div>
        
        <div class="form-group form-row">
            <label for="password" class="col-md-12">パスワード</label>
            <div class="col-md-5">
                <input type="password" name="password" class="form-control" id="password">
            </div>
        </div>
        <div class="col-md-5 text-right">
            <button type="submit" class="btn btn-primary">ログイン</button>
        </div>
        
    </form>
@endsection