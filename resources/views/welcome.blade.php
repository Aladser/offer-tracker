<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <noscript>
            <meta http-equiv="refresh" content="0; url=/noscript">
        </noscript>
        <title>{{env('APP_NAME')}}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name='websocket' content="{{env('WEBSOCKET_ADDR')}}">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- стили -->
        <link href="/css/welcome.css" rel="stylesheet" />
        <link href="/css/common.css" rel="stylesheet" />
        <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- скрипты -->
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/MainClientWebsocket.js" defer></script>
        <script src="/js/pages/main.js" defer></script>
    </head>

    <body>
        <header class="p-2">
            @if (Route::has('login'))
                <p class="position-relative text-end m-0">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">Профиль</a>
                    @else
                        <div class="text-end mt-2 me-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-dark">Войти</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-dark">Регистрация</a>
                            @endif
                        </div>
                    @endauth
                </p>
            @endif
        </header>

        <main class="p-2">
            <section class="mx-auto section-content">
                <h3 class='h1 text-center pb-4'>Реферальные ссылки</h3>
                <p class='text-center fs-5 mb-4 w-100'>Все активные реферальные ссылки с указанием, какой оффер и вебмастер-подписчик</p>

                <section class="d-flex flex-wrap justify-content-around w-100" id='section-ref-list'>
                    <!-- тестовая нерабочая ссылка -->
                    <article class='p-3 m-2 text-center bg-ddd color-333 fs-5 shadow rounded'>
                        <a href="?ref=1" class='text-decoration-none text-reset fw-bolder'>
                            <p title="{{env('APP_URL')}}?ref=1@1"> Тестовая<br> неработающая<br> ссылка </p>
                        </a>
                    </article>
                    
                    @for ($i = 0; $i < count($subscriptions); $i++)
                        <article class='p-3 m-2 text-center bg-ddd color-333 fs-5 shadow rounded' data-id='{{$subscriptions[$i]->id}}'>
                            <a href="?ref={{$subscriptions[$i]->refcode}}" class='text-decoration-none text-reset fw-bolder'>
                                <p title="{{$subscriptions[$i]->offer->url}}">{{$subscriptions[$i]->offer->name}}</p>
                            </a>
                            <p>веб-мастер: {{$subscriptions[$i]->follower->user->name}}</p>
                            <p>тема: {{$subscriptions[$i]->offer->theme->name}}</p>
                        </article>
                    @endfor
                </section>
            </section>
        </main>        
    </body>
</html>
