@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    {{-- 登録スポット数入力フォーム --}}
    <form method="get" action="{{ route('posts.create_main') }}">
        @csrf
        
        {{-- スポット数を選択するドロップダウン --}}
        <div class="form-group mt-3 form-row">
            <label class="col-12" for="number_of_spots">
                登録するスポット数を選択（10スポットまで登録可能)
            </label>
            {{-- 1-10箇所までで選択 --}}
            <select name="number_of_spots" class="form-control col-md-5" id="number_of_spots">
                <option value="" selected disabled>選択してください</option>
                @for($i=1; $i<=10; $i++)
                    <option value={{ $i }} >{{ $i }}</option>
                @endfor
            </select>
        </div>
        
        <div class="form-row">
            <div class="col-md-5 text-right">
                <button type="submit" class="btn btn-primary">送信</button>
            </div>
        </div>
    </form>
@endsection