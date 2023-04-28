@extends('layouts.not_logged_in')

@section('content')
    <h1>新規登録フォーム</h1>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group form-row">
            <label for="name" class="col-md-12">ユーザー名</label>
            <div class="col-md-5">
                <input type="text" name="name" class="form-control" id="name">
            </div>
        </div>
        
        <div class="form-group form-row">
            <label for="prefecture" class="col-md-12">居住地</label>
            <div class="col-md-5">
                <select name="prefecture_id" class="form-control" id="prefecture">
                    <option value="" selected disabled>選択してください</option>
                    @foreach(\App\Prefecture::all() as $prefecture)
                        <option value={{ $prefecture->id }}>{{ $prefecture->prefecture }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group form-row">
            <label for="birthdate" class="col-md-12">生年月日</label>
            <div class="col-md-5">
                <input type="date" name="birthdate" class="form-control" value="2000-01-01" max="{{date('Y-m-d')}}" id="birthdate">
            </div>
        </div>
        
        <div class="mt-4 mb-3">※メールアドレス、パスワードは以降ログイン時に使用します。</div>
        
        <div class="form-group form-row">
            <label for="email" class="col-md-12">メールアドレス</label>
            <div class="col-md-5">
                <input type="email" name="email" class="form-control" id="email">
            </div>
        </div>
        
        <div class="form-group form-row">
            <label for="password" class="col-md-12">パスワード</label>
            <div class="col-md-5">
                <input type="password" name="password" class="form-control" placeholder="8字以上で入力" id="password">
            </div>
        </div>
        
        <div class="form-group form-row">
            <label for="password_confirmation" class="col-md-12">パスワード（確認用）</label>
            <div class="col-md-5">
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
            </div>
        </div>
        
        <div class="form-group form-row">
            <div class="col-md-5 text-right">
                <button type="submit" class="btn btn-primary">登録</button>
            </div>
        </div>
    </form>
@endsection