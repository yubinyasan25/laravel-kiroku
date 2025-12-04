{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container text-center floating-container" style="padding-top: 150px; position: relative; min-height: calc(100vh - 56px); transform: translateY(-2cm);">

    {{-- ロゴ --}}
    <img src="{{ asset('img/ajimeguri_sara.png') }}" alt="味めぐり" class="logo mb-4" style="width: 200px; z-index: 1; position: relative;">

    {{-- タイトル --}}
    <h1 class="title mb-3" style="font-size: 2.5rem; font-weight: 700; color: #EF3B2D; z-index: 1; position: relative;">
        味めぐりへようこそ！
    </h1>

    {{-- サブタイトル --}}
    <p class="subtitle mb-4" style="font-size: 1.2rem; color: #555; z-index: 1; position: relative;">
        美味しいものを記録して、日々の食事を楽しもう！
    </p>

    {{-- 浮かぶ画像 --}}
    <img src="{{ asset('img/IMG_1692.jpg') }}" class="floating-photo" id="floatingPhoto1" style="opacity: 1;">
    <img src="{{ asset('img/IMG_2183.jpg') }}" class="floating-photo" id="floatingPhoto2" style="opacity: 0;">

    {{-- ボタン横並び --}}
    <div class="d-flex justify-content-center mb-4" style="gap: 20px; position: relative; z-index: 1;">
        @auth
            <a href="{{ route('mypage') }}" class="btn top-btn">マイページ</a>
            <a href="{{ route('foods.create') }}" class="btn top-btn">記録する</a>
            <a href="{{ route('album.index') }}" class="btn top-btn">アルバム</a>
        @else
            <a href="{{ route('login') }}" class="btn top-btn">ログインして記録する</a>
        @endauth
    </div>

</div>

<style>
body, input, select, textarea, button, h1, p, a, label {
    font-family: 'Kosugi Maru', sans-serif !important;
}

/* トップページボタン共通スタイル */
.top-btn {
    background-color: #0fbe9f;
    color: #ffffff;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    text-decoration: none;
    padding: 0.5rem 2rem;
    font-size: 1.2rem;
}

/* ホバー */
.top-btn:hover {
    background-color: #0ea28c;
    color: #fff;
}

/* 浮かぶ画像 */
.floating-photo {
    position: absolute;
    top: 50%;
    border-radius: 50%;
    object-fit: cover;
    transition: opacity 0.5s;
    transform: translateY(-50%);
    z-index: 0;
}

#floatingPhoto1 { left: 10%; }
#floatingPhoto2 { right: 10%; }

/* 画像サイズ */
@media screen and (min-width: 992px) { .floating-photo { width: 300px; height: 300px; } }
@media screen and (min-width: 768px) and (max-width: 991px) { .floating-photo { width: 200px; height: 200px; } }
@media screen and (max-width: 767px) { .floating-photo { width: 120px; height: 120px; } }
</style>

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
