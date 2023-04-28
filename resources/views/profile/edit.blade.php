@extends('layouts.logged_in')

@section('title',$title)

@section('content')
    <h1>プロフィール編集フォーム</h1>
    
    <form method="POST" action="{{ route('profile.update', Auth::user()) }}">
        @csrf
        @method('patch')
        
        <div class="form-group form-row">
            <label for="name" class="col-md-12">ユーザー名</label>
            <div class="col-md-5">
                <input class="form-control" type="text" name="name" id="name" value="{{ Auth::user()->name }}" >
            </div>
        </div>
        
        <div class="form-group">
            <label for="comment">コメント（必須）</label>
            <textarea class="form-control" name="comment" rows="5" id="comment">@if(Auth::user()->comment !== ''){{ Auth::user()->comment }}@endif</textarea>
        </div>
        
        <div class="form-group form-row">
            <label for="prefecture" class="col-md-12">居住地</label>
            <div class="col-md-5">
                <select class="form-control" name="prefecture_id" id="prefecture">
                    <option value="" selected disabled>選択してください</option>
                    @foreach($prefectures as $prefecture)
                        <option
                            value={{ $prefecture->id }}
                            @if(Auth::user()->prefecture_id === $prefecture->id)
                                selected
                            @endif
                        >
                            {{ $prefecture->prefecture }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="col-md-5 text-right">
                <button type="submit" class="btn btn-primary">更新</button>
            </div>
        </div>
    </form>
@endsection