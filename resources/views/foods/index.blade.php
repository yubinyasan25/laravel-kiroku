@extends('layouts.app')

@section('content')
<div class="container">
    <h1>味メモ記録一覧</h1>
    <a href="{{ route('foods.create') }}" class="btn btn-primary mb-3">新規登録</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($foods as $food)
        <div class="col-md-4 mb-3">
            <div class="card">
                @if($food->photo_path)
                    <img src="{{ asset('storage/'.$food->photo_path) }}" class="card-img-top" alt="{{ $food->name }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $food->name }}</h5>
                    <p class="card-text">
                        ジャンル: {{ $food->genre ?? '-' }}<br>
                        店舗: {{ $food->store_name ?? '-' }}<br>
                        価格: {{ $food->price ?? '-' }}円<br>
                        評価: {{ $food->rating ?? '-' }}
                    </p>
                    <p>{{ $food->comment }}</p>
                    <a href="{{ route('foods.edit', $food) }}" class="btn btn-sm btn-warning">編集</a>
                    <form action="{{ route('foods.destroy', $food) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
