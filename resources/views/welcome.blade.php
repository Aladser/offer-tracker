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
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="/css/welcome.css" rel="stylesheet" />
        <link href="/css/common.css" rel="stylesheet" />
        <!-- скрипты -->
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/MainClientWebsocket.js" defer></script>
        <script src="/js/pages/main.js" defer></script>
    </head>

    <body>
        <header class="p-2">
            @if (Route::has('login'))
                <p class="text-end">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                        hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900">Профиль</a>
                    @else
                        <div class="text-end mt-2 me-2">
                            <a href="{{ route('login') }}" class="inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                            leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                            hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                            active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                            dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                            dark:active:text-neutral-900">Войти</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                                leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                                hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                                active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                                dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 
                                dark:active:border-neutral-900 dark:active:text-neutral-900">Регистрация</a>
                            @endif
                        </div>
                    @endauth
                </p>
            @endif
        </header>
        <!-- контент -->
        <main class="p-2">
            <section class="mx-auto section-content">
                <h3 class='text-center pb-4 text-3xl font-semibold'>Реферальные ссылки</h3>
                <p class='text-center text-xl mb-4'>Все активные реферальные ссылки с указанием, какой оффер и вебмастер-подписчик</p>

                <section class="flex flex-wrap justify-around" id='section-ref-list'>
                    <!-- тестовая нерабочая ссылка -->
                    <article class='p-3 m-2 text-center bg-ddd color-333 shadow rounded text-xl w-60'>
                        <a href="?ref=1" class='font-semibold'>
                            <p title="{{env('APP_URL')}}?ref=1@1"> Тестовая<br> неработающая<br> ссылка </p>
                        </a>
                    </article>
                    
                    @for ($i = 0; $i < count($subscriptions); $i++)
                        <article class='p-3 m-2 text-center bg-ddd color-333 shadow rounded text-xl w-60' data-id='{{$subscriptions[$i]->id}}'>
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
