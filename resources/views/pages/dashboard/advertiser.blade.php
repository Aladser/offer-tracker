<x-app-layout class='position-relative'>
    @section('title')
        <x-title>Панель рекламодателя</x-title>
    @endsection

    @section('meta')
        <meta name='websocket' content="{{env('WEBSOCKET_ADDR')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection
    
    @section('css')
        <link href="/css/advertiserPage.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/ServerRequest.js" defer></script>
        <script src="/js/statuses/Status.js" defer></script>
        <script src="/js/statuses/OfferStatus.js" defer></script>
        <script src="/js/TableClientControllers/TableClientController.js" defer></script>
        <script src="/js/TableClientControllers/OfferTableClientController.js" defer></script>
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/AdvertiserClientWebsocket.js" defer></script>
        <script src="/js/pages/dashboard/advertiser.js" defer></script>
    @endsection

    <section class='mx-auto section-content'>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Панель рекламодателя</h2>
        </x-slot>

        <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg position-relative mt-4 text-center">
            <h4 class='font-semibold text-2xl mx-auto mb-2 pt-2'>Офферы</h4>

            <div class='text-center border-dark'>
                <a href="{{route('offer.create')}}" class='inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out 
                        hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 hover:text-neutral-800 
                        focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900 w-52'>Добавить оффер</a>
                <a href="{{route('offer.statistics')}}" class='inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out 
                        hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 hover:text-neutral-800 
                        focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900 w-52' title='статистика офферов'>Статистика</a>
            </div>

            <p id='prg-error' class='font-semibold pt-4 fs-4 text-center text-danger'></p>

            <section class="bg-white border-b border-gray-200 m-0 flex justify-between text-center offers">
                <!-- включенные офферы -->
                <section class='w-1/2 inline-block m-0 p-3'>
                    <h4 class='font-semibold text-xl mx-auto'>Включены</h4>
                    <article class='table-items h-full' id='active-offers'>
                        @foreach ($advertiser->offers->all() as $offer)
                            @if ($offer->status == 1)
                            <article id="{{$offer->id}}" class='relative mb-1 rounded cursor-pointer offers__item border-666 active-offers__item' draggable='true'>
                                <p class='font-semibold'>{{$offer->name}}</p>
                                <p>Цена: {{$offer->price}} р. за переход</p>
                                <p class='table-offers__td-link-count'>Подписчиков: {{$offer->links->count()}} </p>
                                <button class='absolute bottom-0 right-0 m-1 offers__btn-remove' title='Удалить'>🗑</button>
                            </article>
                            @endif
                        @endforeach
                    </article>
                </section>

                <!-- выключенные офферы -->
                <section class='w-1/2 inline-block m-0 p-3'>
                    <h4 class='font-semibold text-xl mx-auto'>Выключены</h4>
                    <article class='table-items h-full'  id='deactive-offers'>
                        @foreach ($advertiser->offers->all() as $offer)
                            @if ($offer->status == 0)
                            <article id="{{$offer->id}}" class='relative mb-1 rounded cursor-pointer bg-slate-100 offers__item border-666 deactive-offers__item' draggable='true'>
                                <p class='font-semibold'>{{$offer->name}}</p>
                                <p>Цена: {{$offer->price}} р. за переход</p>
                                <p class='table-offers__td-link-count'>Подписчиков: {{$offer->links->count()}} </p>
                                <button class='absolute bottom-0 right-0 m-1 offers__btn-remove' title='Удалить'>🗑</button>
                            </article>
                            @endif
                        @endforeach
                    </article>
                </section>
            </section>

        </section>
    </section>
</x-app-layout>