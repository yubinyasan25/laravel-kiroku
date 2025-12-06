<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" 
          crossorigin="anonymous">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/80fb4687fb.js" crossorigin="anonymous"></script>

    <!-- 自作CSS -->
    <link href="{{ asset('css/samuraimart.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="samuraimart-wrapper">
        {{-- ヘッダー --}}
        @component('components.header')
        @endcomponent

        {{-- メインコンテンツ --}}
        <main class="py-4">
            @yield('content')
        </main>

        {{-- フッター --}}
        @component('components.footer')
        @endcomponent
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" 
            crossorigin="anonymous"></script>
</body>
</html>
