@extends('layouts.app')

@section('content')
<div class="container">
    <h2>食事写真アップロード</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('photos.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photo" required>
        <button type="submit" class="btn btn-primary">アップロード</button>
    </form>

    <hr>

    <h3>アップロード済み写真</h3>
    <div class="row">
        @foreach($photos as $photo)
            <div class="col-md-3 mb-3">
                <img src="{{ $photo->url }}" class="img-fluid" alt="食事写真">
            </div>
        @endforeach
    </div>
</div>
@endsection
