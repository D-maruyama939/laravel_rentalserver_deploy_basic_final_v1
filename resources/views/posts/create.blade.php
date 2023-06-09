@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    {{--投稿フォーム--}}
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mt-3 form-row">
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
        
        <div class="form-group">
            <label for="title">投稿タイトル</label>
            <input type="text" name="title" class="form-control" id="title">
        </div>
        
        {{-- 各スポットの入力フォーム --}}
        @for($i=1; $i<=$number_of_spots; $i++)
            <div>【 スポット {{ $i }} / {{ $number_of_spots }} 】</div>
            <div class="form-group">
                <label for="spot_name">スポット名</label>
                <input type="text" name="spot_names[]" class="form-control" id="spot_name">
            </div>
            <div class="form-group">
                <label for="spot_image">スポット画像（2MB未満）</label>
                <input type="file" name="spot_images[]" class="form-control-file" id="spot_image">
            </div>
            <div class="form-group">
                <label for="spot_comment">スポット説明</label>
                <textarea name="spot_comments[]" rows="5" cols="60" class="form-control" id="spot_comment"></textarea>
            </div>
        @endfor
        
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
        
        <input type="hidden" name="number_of_spots" value="{{ $number_of_spots }}">
        
        <div class="form-row">
            <div class="col-12 text-right">
                <button type="submit" class="btn btn-primary mt-2 mb-3">投稿</button>
            </div>
        </div>
        
    </form>
@endsection