<x-app-layout>
    @section('title')
        <x-title>Панель вебмастера</x-title>
    @endsection
    
    @section('meta')
        <meta name='websocket' content="{{env('WEBSOCKET_ADDR')}}">
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
            <h4 class='h4 text-center p-3 fw-bolder'>Подписки и доступные офферы</h4>

            <p class='text-center pt-1 p-3'>
                <a href="{{route('offer.statistics')}}" class='btn btn-outline-dark'>Статистика офферов</a>
            </p>
            <p class='h3 text-center fs-5'>Для деактивации оффера перетащите его в правую колонку</p>
            <p class='h3 text-center fs-5'>Для активации оффера переташите его в левую колонку</p>
            <p id='prg-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>

            <section class="bg-white border-b border-gray-200 m-0 d-flex justify-content-between text-center">
                <!-- офферы-подписки пользователя -->
                <article class='w-50 d-inline-block m-0 p-3 border-2 border-top-0 border-start-0 border-bottom-0'>
                    <h4 class='h4 fw-bolder'>Подписки</h4>
                    <article class='w-100 h-100 table-items subscriptions' id='list-subscriptions'>
                        @foreach ($subscriptions->get() as $subscription)
                            @if ($subscription->offer->status == 1)
                                <article id="{{$subscription->offer->id}}" class='border-666 mb-1 rounded cursor-pointer list-subscriptions__item' draggable='true'>
                                    <p class='fw-bolder'>{{$subscription->offer->name}}</p>
                                    <p>цена: {{$subscription->offer->price * $incomePercent}} р. за переход</p>
                                    <p>тема: {{$subscription->offer->theme->name}}</p>
                                    <a href="/?ref={{$subscription->refcode}}" title="{{$subscription->offer->url}}" class='fw-bolder fs-5 text-primary subscriptions__ref'>Реферальная ссылка</a>
                                </article>
                            @endif
                        @endforeach
                    </article>
                </article>

                <!-- доступные активные офферы -->
                <article class='w-50 d-inline-block m-0 p-3'>
                    <h4 class='h4 fw-bolder'>Доступные офферы</h4>
                    <article class='w-100 h-100 table-items offers'  id='list-active-offers'>
                        @foreach ($offers->get() as $offer)
                            <article id="{{$offer->id}}" class='border-666 mb-1 rounded cursor-pointer bg-light list-active-offers__item' draggable='true'>
                                <p class='fw-bolder'>{{$offer->name}}</p>
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
