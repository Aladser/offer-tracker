<x-app-layout>
    @section('title')
        <x-title>Панель вебмастера</x-title>
    @endsection
    
    @section('meta')
        <meta name='websocket' content="{{env('WEBSOCKET_ADDR')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection
    
    @section('css')
        <link href="/css/webmaster.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/ServerRequest.js" defer></script>
        <script src="/js/statuses/Status.js" defer></script>
        <script src="/js/statuses/SubscriptionStatus.js" defer></script>
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/WebmasterClientWebsocket.js" defer></script>
        <script src="/js/pages/dashboard/webmaster.js" defer></script>
    @endsection

    <section class='mx-auto section-content'>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Панель вебмастера</h2>
        </x-slot>

        <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg position-relative mt-4">
            <h4 class='font-semibold text-2xl text-center mt-4 mb-4'>Подписки и доступные офферы</h4>

            <p class='text-center pt-1 p-3'>
                <a href="{{route('offer.statistics')}}" class='section-content__btn inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out 
                        hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 hover:text-neutral-800 
                        focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900 w-52'>Статистика офферов</a>
            </p>
            <p id='prg-error' class='font-semibold pt-4 text-xl text-center text-red-500'></p>

            <section class="bg-white m-0 flex justify-between text-center">
                <!-- офферы-подписки пользователя -->
                <article class='w-1/2 inline-block m-0 p-3'>
                    <h4 class='font-semibold text-xl text-center mb-2'>Подписки</h4>
                    <article class='table-items subscriptions w-full h-full' id='list-subscriptions'>
                        @foreach ($subscriptions->get() as $subscription)
                            @if ($subscription->offer->status == 1)
                                <article id="{{$subscription->offer->id}}" class='list-subscriptions__item border-666 mb-1 rounded cursor-pointer p-2' draggable='true'>
                                    <p class='font-semibold'>{{$subscription->offer->name}}</p>
                                    <p>цена: {{$subscription->offer->price * $incomePercent}} р. за переход</p>
                                    <p>тема: {{$subscription->offer->theme->name}}</p>
                                    <a href="/?ref={{$subscription->refcode}}" title="{{$subscription->offer->url}}" class='font-semibold text-xl text-sky-600 subscriptions__ref'>Реферальная ссылка</a>
                                </article>
                            @endif
                        @endforeach
                    </article>
                </article>

                <!-- доступные активные офферы -->
                <article class='w-1/2 d-inline-block m-0 p-3'>
                    <h4 class='font-semibold text-xl text-center mb-2'>Доступные офферы</h4>
                    <article class='w-full h-full table-items offers'  id='list-active-offers'>
                        @foreach ($offers->get() as $offer)
                            <article id="{{$offer->id}}" class='border-666 mb-1 rounded cursor-pointer bg-gray-100 p-2 list-active-offers__item' draggable='true'>
                                <p class='font-semibold'>{{$offer->name}}</p>
                                <p>цена: {{$offer->price * $incomePercent}} р. за переход</p>
                                <p>тема: {{$offer->theme->name}}</p>
                            </article>
                        @endforeach
                    </article>
                </article>
            </section>
            
        </section>
    </section>
</x-app-layout>
