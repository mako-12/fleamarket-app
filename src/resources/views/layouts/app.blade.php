<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>coachtech</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-css-reset/dist/reset.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <a href="/" class="header__logo">
                <img src="{{ asset('storage/logo_image/logo.png') }}" alt="COACHTECH">
            </a>

            @unless (isset($simpleHeader) && $simpleHeader)
                <div class="header__search">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="header__search-form">
                            <input class="header__search-form--keyword-input" type="text" name="keyword"
                                value="{{ request('keyword') }}" placeholder="なにをお探しですか？">1
                            <input type="hidden" name="tab" value="{{ request('tab', 'recommend') }}">
                        </div>
                    </form>
                </div>
                <nav class="header__nav">
                    <form action="/logout" method="POST">
                        @csrf
                        <input class="header-nav__logout header-btn" type="submit" value="ログアウト">
                    </form>
                    <a class="header-btn header-nav__mypage" href="{{ route('mypage') }}">マイページ</a>
                    <a class="header-nav__sell header-btn" href="/sell">出品</a>
                </nav>
            @endunless
        </header>


        <div class="content">
            @yield('content')
        </div>
    </div>
</body>

</html>
