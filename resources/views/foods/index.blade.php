@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- ▼ パンくず（マイページ > アルバム） --}}
            <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mypage') }}">マイページ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">アルバム</li>
                </ol>
            </nav>

            {{-- ▼ タイトル --}}
            <h1 class="mb-3">アルバム</h1>

            <a href="{{ route('foods.create') }}" class="btn samuraimart-submit-button text-white mb-4" 
               style="border-radius: 8px; padding: 0.5rem 1rem; font-weight: 600;">
                新規登録
            </a>

            {{-- ▼ フラッシュメッセージ --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- ▼ アルバム一覧 --}}
            <div class="row">
                @foreach($foods as $food)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        @if($food->photo_path)
                            <img src="{{ asset('storage/'.$food->photo_path) }}" class="card-img-top" alt="{{ $food->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $food->name }}</h5>

                            <p class="card-text mb-2">
                                ジャンル: {{ $food->genre ?? '-' }}<br>
                                店舗: {{ $food->store_name ?? '-' }}<br>
                                価格: {{ $food->price ?? '-' }}円<br>
                                評価: {{ $food->rating ?? '-' }}
                            </p>

                            <p class="text-muted" style="font-size: 0.9rem;">{{ $food->comment }}</p>

                            <a href="{{ route('foods.edit', $food) }}" class="btn btn-warning btn-sm">編集</a>

                            <form action="{{ route('foods.destroy', $food) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('削除しますか？')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

{{-- ▼ ボタンカラー統一（マイページと同じ色） --}}
<style>
.samuraimart-submit-button {
    background-color: #0fbe9f !important;
}
</style>

@endsection
