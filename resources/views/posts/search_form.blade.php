@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    <form method="GET" action="{{route('posts.index')}}">
        {{-- 都道府県 --}}
        <div class="form-group form-row">
            <label for="prefecture" class="col-md-12">都道府県</label>
            <div class="col-md-5">
                <select name="prefecture_id" class="form-control" id="prefecture">
                    <option value="" selected disabled>選択してください</option>
                    @foreach($prefectures as $prefecture)
                        <option value={{ $prefecture->id }}>{{ $prefecture->prefecture }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        {{-- タグ --}}
        <div class="form-check mb-3">
            <div class="mb-2">タグ（複数選択可）</div>
            <div>
                {{-- タグ選択 チェックボックス アコーディオンで表示 --}}
                <div id="accordion-tag" class="container">
                    {{-- タググループごとにアコーディオンで表示 --}}
                    @foreach($tag_groups as $tag_group)
                        <div class="card">
                            {{-- アコーディオンのタイトル（タググループ名） --}}
                            <div class="card-header bg-light" data-toggle="collapse" data-target="#collapse{{ $tag_group->id }}">
                                {{ $tag_group->group_name }}
                            </div>
                            
                            {{-- アコーディオンの中身（タグ名のチェックボックス） --}}
                            <div id="collapse{{ $tag_group->id }}" class="collapse" data-parent="#accordion-tag">
                                <div class="card-body">
                                    @foreach($tag_group->tags as $tag)
                                        <div class="form-check form-check-inline mr-4">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="tag_ids[]" value="{{ $tag->id }}">{{ $tag->tag_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> 
            </div>
        </div>
        
        {{-- キーワード --}}
        <div class="form-group">
            <label for="key_word">キーワード</label>
            <input class="form-control" type="text" name="key_word" id="key_word" placeholder="キーワードを入力してください">
        </div>
        
        <div class="form-row">
            <div class="col-12 text-right">
                <button type="submit" class="btn btn-primary mt-2">検索</button>
            </div>
        </div>
    </form>
@endsection