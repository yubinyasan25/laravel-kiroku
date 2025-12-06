@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="mb-3">新規会員登録</h1>

            <hr class="mb-4">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row mb-3">
                    <label for="name" class="col-md-5 col-form-label text-md-left fw-medium">
                        氏名
                        <span class="ms-1 samuraimart-require-input-label">
                            <span class="samuraimart-require-input-label-text">必須</span>
                        </span>
                    </label>

                    <div class="col-md-7">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror samuraimart-login-input" name="name" value="{{ old('name') }}" required autocomplete="name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>氏名を入力してください</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                     <div class="form-group row mb-3">
                        <label for="nickname" class="col-md-5 col-form-label text-md-left fw-medium">
                         ニックネーム
                        <span class="ms-1 samuraimart-require-input-label">
                             <span class="samuraimart-require-input-label-text">必須</span>
                         </span>
                    </label>

                        <div class="col-md-7">
                             <input id="nickname" type="text" 
                            class="form-control @error('nickname') is-invalid @enderror samuraimart-login-input" 
                            name="nickname" value="{{ old('nickname') }}" >

                              @error('nickname')
                         <span class="invalid-feedback" role="alert">
                    <strong>ニックネームを入力してください</strong>
                     </span>
                    @enderror
                </div>
            </div>


                <div class="form-group row mb-3">
                    <label for="email" class="col-md-5 col-form-label text-md-left fw-medium">
                        メールアドレス
                        <span class="ms-1 samuraimart-require-input-label">
                            <span class="samuraimart-require-input-label-text">必須</span>
                        </span>
                    </label>

                    <div class="col-md-7">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror samuraimart-login-input" name="email" value="{{ old('email') }}" required autocomplete="email" >

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>メールアドレスを入力してください</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="password" class="col-md-5 col-form-label text-md-left fw-medium">
                        パスワード
                        <span class="ms-1 samuraimart-require-input-label">
                            <span class="samuraimart-require-input-label-text">必須</span>
                        </span>
                    </label>

                    <div class="col-md-7">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror samuraimart-login-input" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="password-confirm" class="col-md-5 col-form-label text-md-left fw-medium">
                        パスワード（確認用）
                        <span class="ms-1 samuraimart-require-input-label">
                            <span class="samuraimart-require-input-label-text">必須</span>
                        </span>
                    </label>

                    <div class="col-md-7">
                        <input id="password-confirm" type="password" class="form-control samuraimart-login-input" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <hr class="mb-4">

                <button type="submit" 
                    class="btn samuraimart-submit-button w-100 text-white mb-4" 
                    style="border-radius: 8px; padding: 0.5rem 1rem; font-weight: 600;">
                    アカウント作成
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
