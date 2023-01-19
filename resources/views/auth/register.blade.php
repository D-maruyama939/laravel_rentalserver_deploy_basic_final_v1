@extends('layouts.not_logged_in')

@section('content')
    <h1>サインアップ</h1>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>
                ユーザー名:
                <input type="text" name="name">
            </label>
        </div>
        <div>
            <label>
                メールアドレス:
                <input type="email" name="email">
            </label>
        </div>
        <div>
            <label>
                パスワード:
                <input type="text" name="password">
            </label>
        </div>
        <div>
            <label>
                パスワード（確認用）:
                <input type="text" name="password_confirmation" placeholder="パスワードを再度入力">
            </label>
        </div>
        
        <div>
            <input type="submit" value="登録">
        </div>
    </form>
@endsection