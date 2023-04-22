<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    
    {{--Bootstrap5 CSS --}}
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
    {{--Bootstrap4 CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    {{-- Bootstrap アイコンCSS --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    {{--オリジナル CSS --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body 
    class="
        container
        background_default
        
        {{-- 季節によって背景クラスを変更 --}}
        @if(date('m') >= 3 && date('m') <= 5 )
            background_spring
        @elseif(date('m') >= 6 && date('m') <= 8)
            background_summer
        @elseif(date('m') >= 9 && date('m') <= 11)
            background_autumn
        @else
            background_winter
        @endif
    "
>
    @yield('header')
 
    {{-- エラーメッセージを出力 --}}
    @foreach($errors->all() as $error)
      <div class="error mb-3">{{ $error }}</div>
    @endforeach
 
    {{-- 成功メッセージを出力 --}}
    @if (\Session::has('success'))
        <div class="success mb-3">
            {{ \Session::get('success') }}
        </div>
    @endif
    
    {{-- 警告メッセージを出力 --}}
    @if (\Session::has('warning'))
        <div class="warning mb-3">
            {{ \Session::get('warning') }}
        </div>
    @endif
 
    @yield('content')
    
    {{--Bootstrap5 JS--}}
    <!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>-->
    
    {{--Bootstrap4 JS--}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>