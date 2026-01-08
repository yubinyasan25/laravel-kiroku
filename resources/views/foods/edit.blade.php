@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">食レポ編集</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{ route('foods.update', $food) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- メニュー名 --}}
                    <div class="col-md-6">
                        <label class="form-label">メニュー・商品名</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $food->name) }}"
                               required>
                    </div>

                    {{-- 日付 --}}
                    <div class="col-md-6">
                        <label class="form-label">日付</label>
                        <input type="date"
                               name="date"
                               class="form-control"
                               value="{{ old('date', optional($food->date)->format('Y-m-d')) }}"
                               required>
                    </div>

                    {{-- カテゴリ --}}
                    <div class="col-md-12">
                        <label class="form-label d-block mb-1">カテゴリ</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $categories = ['和食','洋食','寿司','ラーメン','中華','カフェ・軽食','ファストフード','居酒屋','デザート','お土産','その他'];
                                $selected = $food->category ? json_decode($food->category, true) : [];
                            @endphp

                            @foreach($categories as $cat)
                                <input type="checkbox"
                                       name="category[]"
                                       value="{{ $cat }}"
                                       id="cat_{{ $loop->index }}"
                                       class="btn-check"
                                       {{ in_array($cat, $selected) ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary"
                                       for="cat_{{ $loop->index }}">
                                    {{ $cat }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- 店名・価格・評価 --}}
                    <div class="col-md-12 d-flex gap-2 align-items-start">

                        <div class="flex-grow-1">
                            <label class="form-label">店名</label>
                            <input type="text"
                                   name="store_name"
                                   class="form-control"
                                   value="{{ old('store_name', $food->store_name) }}">
                        </div>

                        <div class="flex-grow-1">
                            <label class="form-label">価格</label>
                            <div class="input-group">
                                <input type="text"
                                       name="price"
                                       class="form-control"
                                       value="{{ old('price', $food->price) }}">
                                <span class="input-group-text">円</span>
                            </div>
                        </div>

                        {{-- ★評価 --}}
                        <div class="flex-grow-1">
                            <label class="form-label">評価</label>
                            <div class="star-box form-control">
                                <div class="star-rating d-flex justify-content-center align-items-center">
                                    @for($i=5; $i>=1; $i--)
                                        <input type="radio"
                                               id="star{{ $i }}"
                                               name="rating"
                                               value="{{ $i }}"
                                               {{ (int)old('rating', $food->rating) === $i ? 'checked' : '' }}>
                                        <label for="star{{ $i }}"></label>
                                    @endfor
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- コメント --}}
                    <div class="col-md-12">
                        <label class="form-label">コメント</label>
                        <textarea name="comment"
                                  class="form-control"
                                  rows="3">{{ old('comment', $food->comment) }}</textarea>
                    </div>

                    {{-- 既存写真 --}}
                    <div class="col-md-12">
                        <label class="form-label">登録済みの写真</label>

                        @if(app()->isLocal() && !empty($food->photo_paths))
                            @php
                                $photos = json_decode($food->photo_paths, true) ?? [];
                            @endphp

                            <div class="d-flex gap-3 flex-wrap">
                                @foreach($photos as $path)
                                    <div class="photo-box">
                                        <img src="{{ asset('storage/'.$path) }}">
                                        <label class="photo-delete">
                                            <input type="checkbox"
                                                   name="delete_photos[]"
                                                   value="{{ $path }}">
                                            削除
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <img src="{{ asset('img/sample_food.jpg') }}"
                                 style="width:120px;height:120px;object-fit:cover;border-radius:8px;">
                            <p class="text-muted small mt-1">
                                ※ 本番環境では画像編集はできません
                            </p>
                        @endif
                    </div>

                    {{-- 写真追加（ローカルのみ） --}}
                    @if(app()->isLocal())
                        <div class="col-md-12">
                            <label class="form-label">写真追加</label>
                            <div class="d-flex gap-2">
                                @for($i=0; $i<3; $i++)
                                    <input type="file"
                                           name="photo[]"
                                           class="form-control"
                                           accept="image/*">
                                @endfor
                            </div>
                        </div>
                    @endif

                    {{-- 更新 --}}
                    <div class="col-md-12 text-center mt-3">
                        <button type="submit" class="btn samuraimart-submit-button">
                            更新する
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

{{-- CSS --}}
<style>
body, input, textarea, button, label {
    font-family: 'Kosugi Maru', sans-serif;
}

.col-md-12.d-flex > div {
    flex: 1 1 0;
}

.btn-check:checked + .btn {
    background-color: #ffc107;
    color: #fff;
    border-color: #ffc107;
}

/* ★評価 */
.star-box {
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    font-size: 1.5rem;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    color: #ddd;
    width: 2em;
    height: 2em;
    position: relative;
}

.star-rating label::before {
    content: "★";
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #ffc107;
}

/* 写真削除UI */
.photo-box {
    position: relative;
    width: 120px;
    height: 120px;
}

.photo-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}

.photo-delete {
    position: absolute;
    bottom: 6px;
    right: 6px;
    background: rgba(0,0,0,0.7);
    color: #fff;
    font-size: 0.75rem;
    padding: 2px 6px;
    border-radius: 6px;
    cursor: pointer;
}
</style>
@endsection
