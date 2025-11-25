@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">食メモ</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <!-- メニュー・商品名 -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">メニュー・商品名</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <!-- 日付 -->
                    <div class="col-md-6">
                        <label for="date" class="form-label">日付</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <!-- カテゴリ（複数選択可能） -->
                    <div class="col-md-12">
                        <label class="form-label d-block mb-1">カテゴリ</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $categories = ['和食','洋食','寿司','ラーメン','中華','カフェ・軽食','ファストフード','居酒屋','デザート','お土産','その他'];
                            @endphp
                            @foreach($categories as $cat)
                                <input type="checkbox" name="category[]" value="{{ $cat }}" id="cat_{{ $loop->index }}" class="btn-check">
                                <label class="btn btn-outline-secondary" for="cat_{{ $loop->index }}">{{ $cat }}</label>
                            @endforeach
                        </div>
                    </div>

                    <!-- 店名・価格・評価を横並び -->
                    <div class="col-md-12 d-flex gap-2 align-items-start">

                        <!-- 店名 -->
                        <div class="flex-grow-1">
                            <label for="store_name" class="form-label">店名</label>
                            <input type="text" name="store_name" id="store_name" class="form-control">
                        </div>

                        <!-- 価格 -->
                        <div class="flex-grow-1">
                            <label for="price" class="form-label">価格</label>
                            <div class="input-group">
                                <input type="text" name="price" id="price" class="form-control" placeholder="例：500">
                                <span class="input-group-text">円</span>
                            </div>
                        </div>

                        <!-- 評価（★＋枠付き） -->
                        <div class="flex-grow-1">
                            <label class="form-label">評価</label>
                            <div class="star-box form-control">
                                <div class="star-rating d-flex justify-content-center align-items-center">
                                    @for($i=5; $i>=1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                        <label for="star{{ $i }}" title="{{ $i }} stars"></label>
                                    @endfor
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- コメント -->
                    <div class="col-md-12">
                        <label for="comment" class="form-label">コメント</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- 写真 -->
                    <div class="col-md-12 d-flex gap-2">
                        <div class="flex-grow-1">
                            <label class="form-label d-block mb-2">写真</label>
                            <input type="file" name="photo[]" class="form-control" accept="image/*">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label d-block mb-2">&nbsp;</label>
                            <input type="file" name="photo[]" class="form-control" accept="image/*">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label d-block mb-2">&nbsp;</label>
                            <input type="file" name="photo[]" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <!-- 登録ボタン -->
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<style>
body, input, select, textarea, button, label {
    font-family: 'Kosugi Maru', sans-serif;
}

/* 店名・価格・評価の横幅統一 */
.col-md-12.d-flex > div {
    flex: 1 1 0;
}

/* 入力グループ内のテキスト高さ */
.input-group .form-control {
    padding-top: 0.375rem;
    padding-bottom: 0.375rem;
}

/* カテゴリボタン選択時 */
.btn-check:checked + .btn {
    background-color: #ffc107;
    color: #fff;
    border-color: #ffc107;
}
.btn {
    cursor: pointer;
    transition: all 0.2s;
}

/* 枠付きスター評価 */
.star-box {
    height: 2.5rem; /* 入力欄高さに合わせる */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 0.5rem;
}

/* スター評価 */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    font-size: 1.5rem;
    unicode-bidi: bidi-override;
    width: 100%;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    position: relative;
    color: #ddd;
    width: 2em;
    height: 2em;
    line-height: 2em;
    font-size: 1.5rem;
}

.star-rating label::before {
    content: "★";
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
}

.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
}

.star-rating input:checked ~ label {
    color: #ffc107;
}
</style>
@endsection
