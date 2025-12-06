<header>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm samuraimart-header-container h-auto">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/ajimeguri_touka.jpg') }}" style="width: 100px; height:auto;">
            </a>
           
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">

                    {{-- ▼▼ ログイン前は何も表示しない ▼▼ --}}
                    @guest
                    @endguest

                    {{-- ▼▼ ログイン後 ▼▼ --}}
                    @auth
                        {{-- ニックネーム --}}
                        <li class="nav-item me-4 d-flex align-items-center fw-bold">
                           {{ Auth::user()->nickname }}さん
                        </li>

                    {{-- 区切り線（li の中に入れる） --}}
                        <li class="nav-item d-flex align-items-center me-4">
                         <div class="vr samuraimart-vertical-bar"></div>
                        </li>

                    {{-- ログアウト --}}
                        <li class="nav-item">
                        <a class="nav-link d-flex align-items-center"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <i class="fas fa-sign-out-alt"></i>
                        <span class="ms-1">ログアウト</span>
                    </a>
                </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>
</header>
