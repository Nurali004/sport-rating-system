
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('front/style.css')}}">
</head>
<body>
<!-- ======================== NAVBAR ======================== -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-inner">
            <a class="navbar-brand" href="/">🏆 @lang('messages.sport')<span>@lang('messages.reyting')</span></a>

            <ul class="nav-links">
                <li><a href="/" class="active">@lang('messages.home')</a></li>
                <li><a href="{{route('frontend.ratings.list')}}">@lang('messages.ratings')</a></li>
                <li><a href="{{route('frontend.athletes.list')}}">@lang('messages.athletes')</a></li>
                <li><a href="{{route('frontend.competitions.list')}}">@lang('messages.competitions')</a></li>
                <li><a href="news.html">@lang('messages.news')</a></li>
            </ul>

            <div class="nav-actions">
                <div class="d-flex gap-1">
                    <a href="/lang/uz" class="lang-btn active">UZ</a>
                    <a href="/lang/ru" class="lang-btn">RU</a>
                    <a href="/lang/en" class="lang-btn">EN</a>
                </div>
                <button id="themeToggle">🌙</button>
                <a href="{{route('login')}}" class="btn-login">@lang('messages.login')</a>
            </div>

            <button class="navbar-toggler">☰</button>
        </div>
    </div>
</nav>
<!-- ======================== MAIN ======================== -->
@yield('front')
<!-- ======================== FOOTER ======================== -->
<footer>
    <div class="container">
        <div class="row gap-3">
            <div class="col-lg-4">
                <div class="footer-logo">🏆 SPORT<span>REYTING</span></div>
                <p class="footer-text">O'zbekiston sport reytingi tizimi — milliy sportchilarning yutuqlarini kuzatib boring.</p>
                <div class="footer-social mt-3">
                    <a href="#">📘</a>
                    <a href="#">📷</a>
                    <a href="#">💬</a>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="footer-heading">Havolalar</div>
                <a href="index.html" class="footer-link">Bosh sahifa</a>
                <a href="ratings.html" class="footer-link">Reyting</a>
                <a href="athletes.html" class="footer-link">Sportchilar</a>
                <a href="news.html" class="footer-link">Yangiliklar</a>
            </div>
            <div class="col-lg-2">
                <div class="footer-heading">Sport turlari</div>
                <a href="#" class="footer-link">🥊 Boks</a>
                <a href="#" class="footer-link">🤼 Kurash</a>
                <a href="#" class="footer-link">🥋 Judo</a>
                <a href="#" class="footer-link">🦵 Taekwondo</a>
            </div>
            <div class="col-lg-4">
                <div class="footer-heading">Aloqa</div>
                <div class="footer-link">📧 info@sportreyting.uz</div>
                <div class="footer-link">📞 +998 71 123-45-67</div>
                <div class="footer-link">📍 Toshkent, O'zbekiston</div>
                <div class="d-flex gap-1 mt-3">
                    <button class="lang-btn active" data-lang="uz">UZ</button>
                    <button class="lang-btn" data-lang="ru">RU</button>
                    <button class="lang-btn" data-lang="en">EN</button>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between align-items-center">
            <span>© 2025 Sport Reyting. Barcha huquqlar himoyalangan.</span>
            <span>Laravel · MySQL · Bootstrap 5</span>
        </div>
    </div>
</footer>
<script src="{{asset('front/app.js')}}"></script>
</body>
</html>
