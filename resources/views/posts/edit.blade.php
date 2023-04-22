@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    
    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        
        <div class="form-group form-row mt-3">
            <label for="prefecture" class="col-md-12">都道府県</label>
            <div class="col-md-5">
                <select name="prefecture_id" class="form-control" id="prefecture">
                    <option value="" selected disabled>選択してください</option>
                    @foreach($prefectures as $prefecture)
                        <option 
                            value={{ $prefecture->id }}
                            @if($prefecture->id === $post->prefecture_id)
                                selected
                            @endif
                        >
                            {{ $prefecture->prefecture }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="title">投稿タイトル</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $post->title }}">
        </div>
        
        {{-- 登録されている各スポットをループで表示 --}}
        @foreach($post->spots()->oldest()->get() as $spot) 
            <div>【 スポット {{ $loop->iteration }} / {{ $loop->count }} 】</div>
            <div class="form-group">
                <label for="spot_name">スポット名</label>
                <input type="text" name="spot_names[]" class="form-control" id="spot_name" value="{{ $spot->spot_name }}">
            </div>
            <div class="form-group">
                <label for="spot_image">スポット画像（2MB未満）</label>
                <input type="file" name="spot_images[]" class="form-control-file" id="spot_image">
                
                <div class="mt-2 mb-1">現在の画像</div>
                <img class="post_edit_images" src="{{ asset('storage/' .$spot->spot_img) }}">
            </div>
            <div class="form-group">
                <label for="spot_comment">スポット説明</label>
                <textarea name="spot_comments[]" class="form-control" id="spot_comment" rows="5" cols="60">{!! nl2br(e($spot->spot_comment)) !!}</textarea>
            </div>
        @endforeach
        
        {{-- タグ選択 --}}
        <div class="form-group">
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
                                            <input
                                                type="checkbox"
                                                name="tag_ids[]"
                                                class="form-check-input"
                                                id="tag{{ $tag->id }}"
                                                value="{{ $tag->id }}"
                                                @if($post->tags->contains('id', $tag->id))
                                                    checked
                                                @endif
                                            >
                                            <label class="form-check-label" for="tag{{ $tag->id }}">{{ $tag->tag_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> 
            </div>
        
        <div class="form-row">
            <div class="col-12 text-right">
                <button type="submit" class="btn btn-primary mt-2">更新</button>
            </div>
        </div>
    </form>
@endsection