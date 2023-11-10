<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <noscript><meta http-equiv="refresh" content="0; url=/noscript"></noscript>
        <title>{{env('APP_NAME')}}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name='websocket' content="{{env('WEBSOCKET_ADDR')}}">       

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- стили -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="/css/welcome.css" rel="stylesheet" />
        <link href="/css/common.css" rel="stylesheet" />
        <!-- скрипты -->
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/MainClientWebsocket.js" defer></script>
        <script src="/js/pages/main.js" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body>
        <header class="p-2">
            @if (Route::has('login'))
                <p class="text-end">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-reference inline-block rounded border border-gray-600 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-gray-600 transition duration-150 ease-in-out text-center w-48">Профиль</a>
                    @else
                        <div class="text-end mt-2 me-2">
                            <a href="{{ route('login') }}" class="btn-reference inline-block rounded border border-gray-600 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-gray-600 transition duration-150 ease-in-out text-center w-48">Войти</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-reference inline-block rounded border border-gray-600 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-gray-600 transition duration-150 ease-in-out text-center w-48">Регистрация</a>
                            @endif
                        </div>
                    @endauth
                </p>
            @endif
        </header>
        <!-- контент -->
        <main class="p-2">
            <section class="mx-auto section-content">
                <h3 class='text-center pb-8 text-3xl font-semibold'>Реферальные ссылки</h3>

                <section class="flex flex-wrap justify-around" id='section-ref-list'>
                    <!-- тестовая нерабочая ссылка -->
                    <article class='p-3 m-2 text-center bg-ddd color-333 shadow rounded text-xl w-80'>
                        <a href="?ref=1" class='font-semibold'>
                            <p title="{{env('APP_URL')}}?ref=1@1"> Тестовая<br> неработающая<br> ссылка </p>
                        </a>
                    </article>
                    
                    @for ($i = 0; $i < count($subscriptions); $i++)
                        <article class='p-4 m-2 text-center bg-ddd color-333 shadow rounded text-xl w-80 space-y-2' data-id='{{$subscriptions[$i]->id}}'>
                            <a href="?ref={{$subscriptions[$i]->refcode}}" class='font-semibold'>
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
