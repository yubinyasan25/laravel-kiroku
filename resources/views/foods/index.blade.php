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
                    // photo_paths(JSON) → 配列
                    $photos = [];
                    if ($food->photo_paths) {
                        $decoded = json_decode($food->photo_paths, true);
                        if (is_array($decoded)) {
                            $photos = $decoded;
                        }
                    }
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card shadow-sm h-100">

                        {{-- 写真 --}}
                        @if(app()->isLocal() && !empty($photos))
                            {{-- ローカル環境：アップロード画像 --}}
                            <img
                                src="{{ asset('storage/' . $photos[0]) }}"
                                class="card-img-top food-img"
                                alt="{{ $food->name }}"
                            >
                        @else
                            {{-- 本番（Heroku） or 画像なし：サンプル画像 --}}
                            <img
                                src="{{ asset('images/sample_food.jpg') }}"
                                class="card-img-top food-img"
                                alt="サンプル画像"
                            >
                        @endif

                        <div class="card-body p-2">

                            <h5 class="card-title fw-bold mb-1" style="font-size:0.95rem;">
                                {{ $food->name }}
                            </h5>

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

                            <div class="text-muted small mb-1">
                                {{ \Carbon\Carbon::parse($food->date)->format('Y年n月j日') }}
                            </div>

                            <div class="text-muted small mb-1">
                                店舗：{{ $food->store_name ?? '-' }}<br>
                                価格：{{ $food->price ?? '-' }}円
                            </div>

                            <div class="mb-1">
                                @if($food->rating)
                                    <span class="star-display">
                                        {!! str_repeat('★', $food->rating) . str_repeat('☆', 5 - $food->rating) !!}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>

                            <p class="text-muted" style="font-size:0.8rem; max-height:3em; overflow:hidden;">
                                {{ $food->comment }}
                            </p>

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

<style>
.samuraimart-submit-button {
    background-color: #0fbe9f !important;
    color: #fff;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 600;
}

.food-img {
    height: 150px;
    object-fit: cover;
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
}

.card {
    border-radius: 0.75rem;
    overflow: hidden;
}

.star-display {
    color: #ffc107;
}

.album-edit-btn {
    background-color: #0fbe9f;
    color: #fff;
    border-radius: 6px;
    font-size: 0.7rem;
}

.album-delete-btn {
    background-color: #dc3545;
    color: #fff;
    border-radius: 6px;
    font-size: 0.7rem;
}
</style>
@endsection
