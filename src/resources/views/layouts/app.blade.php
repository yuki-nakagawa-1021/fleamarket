<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleamarket</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <img class="header__logo" src="{{ asset('img/coachtech.png') }}" alt="coachtechロゴ">
                @if (Auth::check())
                <form class="search-form" action="/search" method="GET">
                    @csrf
                    <div class="search-form__item">
                        <input class="search-form__item-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ old('keyword') }}">
                    </div>
                </form>
                <nav>
                    <ul class="header-nav">
                        <li class="header-nav__item">
                            <form class="form" action="/logout" method="POST">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/mypage">マイページ</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__sell" href="/sell">出品</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>