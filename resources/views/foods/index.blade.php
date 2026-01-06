@extends('layouts.app')

@section('content')
<div class="container pt-2">

    {{-- タイトル --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1>アルバム</h1>
            <a href="{{ route('foods.create') }}"
               class="btn samuraimart-submit-button text-white">
                記録する
            </a>
        </div>
    </div>

    {{-- フラッシュメッセージ --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- 月ごとのループ --}}
    @forelse($foodsByMonth as $month => $foods)
        <h3 class="mt-4 mb-3">{{ $month }}</h3>
        <div class="row g-3">
            @foreach($foods as $food)
                @php
                    // ローカル保存用にJSONを配列化
                    $photos = [];
                    if($food->photo_paths) {
                        $decoded = json_decode($food->photo_paths, true);
                        if(is_array($decoded)) {
                            $photos = $decoded;
                        }
                    }
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card shadow-sm h-100">

                        {{-- 写真 --}}
                        @if(!empty($photos))
                           <img src="{{ asset('storage/' . $photos[0]) }}"
                                class="card-img-top food-img"
                                alt="{{ $food->name }}">
                        @else
                            <div class="food-img no-image d-flex align-items-center justify-content-center">
                                <span class="text-muted">No Image</span>
                            </div>
                        @endif

                        <div class="card-body p-2">
                            {{-- 商品名 --}}
                            <h5 class="card-title fw-bold mb-1" style="font-size:0.95rem;">
                                {{ $food->name }}
                            </h5>

                            {{-- カテゴリ --}}
                            <div class="mb-1">
                                @if($food->category)
                                    @foreach(json_decode($food->category, true) as $category)
                                        <span class="badge bg-category me-1" style="font-size:0.7rem;">
                                            {{ $category }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">カテゴリなし</span>
                                @endif
                            </div>

                            {{-- 日付 --}}
                            <div class="text-muted small mb-1">
                                {{ \Carbon\Carbon::parse($food->date)->format('Y年n月j日') }}
                            </div>

                            {{-- 店舗・価格 --}}
                            <div class="text-muted small mb-1">
                                店舗：{{ $food->store_name ?? '-' }}<br>
                                価格：{{ $food->price ?? '-' }}円
                            </div>

                            {{-- 評価 --}}
                            <div class="mb-1">
                                @if($food->rating)
                                    <span class="star-display">
                                        {!! str_repeat('★', $food->rating) . str_repeat('☆', 5 - $food->rating) !!}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>

                            {{-- コメント --}}
                            <p class="text-muted" style="font-size:0.8rem; max-height:3em; overflow:hidden;">
                                {{ $food->comment }}
                            </p>

                            {{-- 編集・削除ボタン --}}
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('foods.edit', $food) }}"
                                   class="btn btn-sm album-edit-btn">
                                    編集
                                </a>

                                <form action="{{ route('foods.destroy', $food) }}"
                                      method="POST"
                                      onsubmit="return confirm('削除しますか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm album-delete-btn">
                                        削除
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-muted text-center">まだ登録されていません。</p>
    @endforelse
</div>

{{-- CSS --}}
<style>
.samuraimart-submit-button {
    background-color: #0fbe9f !important;
    color: #fff;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    transition: all 0.2s;
}
.samuraimart-submit-button:hover {
    background-color: #0da88d !important;
}

/* 写真 */
.food-img {
    height: 150px; /* 少し小さくして横4列でも収まる */
    object-fit: cover;
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
}

/* 画像がない場合 */
.no-image {
    background-color: #f5f5f5;
    height: 150px;
}

/* カード */
.card {
    border-radius: 0.75rem;
    overflow: hidden;
    height: 100%;
}

/* ★評価 */
.star-display {
    color: #ffc107;
    font-size: 1rem;
    letter-spacing: 1px;
}

/* 編集・削除ボタン */
.album-edit-btn {
    background-color: #0fbe9f;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 0.7rem;
    padding: 0.2rem 0.4rem;
}
.album-edit-btn:hover {
    background-color: #0da88d;
}

.album-delete-btn {
    background-color: #dc3545;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 0.7rem;
    padding: 0.2rem 0.4rem;
}
.album-delete-btn:hover {
    background-color: #bb2d3b;
}
</style>
@endsection
