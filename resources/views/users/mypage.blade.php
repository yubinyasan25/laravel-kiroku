@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <div class="row justify-content-center">
        <div class="col-md-5">

            {{-- ▼ パンくず（トップ > マイページ） --}}
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">トップ</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">マイページ</li>
                </ol>
            </nav>

            {{-- ▼ タイトル --}}
            <h1 class="mb-3">マイページ</h1>
            <hr class="mb-4">

            {{-- フラッシュメッセージ --}}
            @if (session('flash_message'))
                <div class="alert alert-light">
                    {{ session('flash_message') }}
                </div>
            @endif

            {{-- ▼ 会員情報編集 --}}
            <div class="container">
                <a href="{{ route('mypage.edit') }}" class="link-dark">
                    <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                        <div class="col-1 ps-0 me-3">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <h3 class="mb-0">会員情報の編集</h3>
                            <p class="mb-0 text-secondary">メールアドレスなどを変更できます</p>
                        </div>
                        <div class="col text-end">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </div>

            <hr class="my-0">

            {{-- ▼ アルバム --}}
            <div class="container">
                <a href="{{ route('foods.index') }}" class="link-dark">
                    <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                        <div class="col-1 ps-0 me-3">
                            <i class="fas fa-utensils fa-3x"></i>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <h3 class="mb-0">アルバム</h3>
                            <p class="mb-0 text-secondary">今まで記録した食事を確認できます</p>
                        </div>
                        <div class="col text-end">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </div>

            <hr class="my-0">

            {{-- ▼ パスワード変更 --}}
            <div class="container">
                <a href="{{ route('mypage.edit_password') }}" class="link-dark">
                    <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                        <div class="col-1 ps-0 me-3">
                            <i class="fas fa-lock fa-3x"></i>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <h3 class="mb-0">パスワード変更</h3>
                            <p class="mb-0 text-secondary">ログイン時のパスワードを変更します</p>
                        </div>
                        <div class="col text-end">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                </a>
            </div>

            <hr class="my-0">

            {{-- ▼ ログアウト --}}
            <div class="container">
                <a href="{{ route('logout') }}"
                   class="link-dark"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="row justify-content-between align-items-center py-4 samuraimart-mypage-link">
                        <div class="col-1 ps-0 me-3">
                            <i class="fas fa-sign-out-alt fa-3x"></i>
                        </div>
                        <div class="col-9 d-flex flex-column">
                            <h3 class="mb-0">ログアウト</h3>
                            <p class="mb-0 text-secondary">味めぐりからログアウトします</p>
                        </div>
                        <div class="col text-end">
                            <i class="fas fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <hr class="my-0">

        </div>
    </div>
</div>

{{-- ▼ アイコン色を統一 --}}
<style>
.samuraimart-mypage-link i {
    color: #0fbe9f !important;
}
</style>

@endsection
