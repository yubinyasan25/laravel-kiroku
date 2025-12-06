{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container text-center floating-container" 
     style="padding-top: 150px; position: relative; min-height: calc(100vh - 56px);">

     <body class="home">

    {{-- ロゴ --}}
    <img src="{{ asset('img/ajimeguri_sara.png') }}" 
         alt="味めぐり" 
         class="logo mb-4" 
         style="width: 200px;">

    {{-- タイトル --}}
    <h1 class="title mb-3" 
        style="font-size: 2.5rem; font-weight: 700; color: #EF3B2D;">
        味めぐりへようこそ！
    </h1>

    {{-- サブタイトル --}}
    <p class="subtitle mb-4" 
       style="font-size: 1.2rem; color: #555;">
        美味しいものを記録して、日々の食事を楽しもう！
    </p>

    {{-- 浮かぶ画像 --}}
    <img src="{{ asset('img/IMG_1692.jpg') }}" class="floating-photo" id="floatingPhoto1">
    <img src="{{ asset('img/IMG_2183.jpg') }}" class="floating-photo" id="floatingPhoto2">

    {{-- ボタン横並び --}}
    <div class="d-flex justify-content-center mb-4" style="gap: 20px;">
        @auth
            <a href="{{ route('mypage') }}" class="btn top-btn">マイページ</a>
            <a href="{{ route('foods.create') }}" class="btn top-btn">記録する</a>
            <a href="{{ route('album.index') }}" class="btn top-btn">アルバム</a>
        @else
            <a href="{{ route('login') }}" class="btn top-btn">ログイン</a>
            <a href="{{ route('register') }}" class="btn top-btn top-btn-secondary">新規登録</a>
        @endauth
    </div>

</div>
<script>
const photos = [
    "{{ asset('img/IMG_1692.jpg') }}",
    "{{ asset('img/IMG_2183.jpg') }}",
    "{{ asset('img/IMG_3985.jpg') }}",
    "{{ asset('img/IMG_3989.jpg') }}",
    "{{ asset('img/IMG_4204.jpg') }}"
];

const photo1 = document.getElementById('floatingPhoto1');
const photo2 = document.getElementById('floatingPhoto2');
let currentIndex1 = 0;
let currentIndex2 = 1;

photo1.src = photos[currentIndex1];
photo2.src = photos[currentIndex2];

setInterval(() => {
    if(photo1.style.opacity == '1' || photo1.style.opacity === '') {
        photo1.style.opacity = 0;
        photo2.style.opacity = 1;
        currentIndex1 = Math.floor(Math.random() * photos.length);
        photo1.src = photos[currentIndex1];
    } else {
        photo1.style.opacity = 1;
        photo2.style.opacity = 0;
        currentIndex2 = Math.floor(Math.random() * photos.length);
        photo2.src = photos[currentIndex2];
    }
}, 7000);
</script>
@endsection
