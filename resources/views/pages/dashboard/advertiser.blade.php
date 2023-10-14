<x-app-layout class='position-relative'>
    @section('title')
        <x-title>Панель рекламодателя</x-title>
    @endsection

    @section('css')
        <link href="/css/advertiserPage.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/statuses/Status.js" defer></script>
        <script src="/js/statuses/OfferStatus.js" defer></script>
        <script src="/js/TableClientControllers/TableClientController.js" defer></script>
        <script src="/js/TableClientControllers/OfferTableClientController.js" defer></script>
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/AdvertiserClientWebsocket.js" defer></script>
        <script src="/js/pages/dashboard/advertiser.js" defer></script>
    @endsection

    <section class='w-50 mx-auto'>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Панель рекламодателя</h2>
        </x-slot>

        <section class="bg-white overflow-hidden shadow-sm sm:rounded-lg position-relative mt-4">
            <h4 class='h4 text-center p-3 fw-bolder'>Офферы</h4>

            <div class='text-center border-dark pb-4'>
                <a href="{{route('offer.create')}}" class='btn btn-outline-dark'>Добавить оффер</a>
                <a href="{{route('offer.statistics')}}" class='btn btn-outline-dark' title='статистика офферов'>Статистика</a>
            </div>


            <p class='h3 text-center fs-5'>Для деактивации оффера перетащите его в правую колонку</p>
            <p class='h3 text-center fs-5'>Для активации оффера переташите его в левую колонку</p>
            <p id='prg-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>

            <section class="bg-white border-b border-gray-200 m-0 d-flex justify-content-between text-center offers">
                <!-- включенные офферы -->
                <article class='w-50 d-inline-block m-0 p-3 border-2 border-top-0 border-start-0 border-bottom-0'>
                    <h4 class='h4 fw-bolder'>Включены</h4>
                    <article class='w-100 h-100 table-items' id='active-offers'>
                        @foreach ($advertiser->offers->all() as $offer)
                            @if ($offer->status == 1)
                            <article id="{{$offer->id}}" class='border-666 mb-1 rounded cursor-pointer position-relative offers__item active-offers__item' draggable='true'>
                                <p class='fw-bolder'>{{$offer->name}}</p>
                                <p>Цена: {{$offer->price}} р. за переход</p>
                                <p class='table-offers__td-link-count'>Подписчиков: {{$offer->links->count()}} </p>
                                <button class='position-absolute bottom-0 right-0 m-1 offers__btn-remove' title='Удалить'>🗑</button>
                            </article>
                            @endif
                        @endforeach
                    </article>
                </article>
                <!-- выключенные офферы -->
                <article class='w-50 d-inline-block m-0 p-3'>
                    <h4 class='h4 fw-bolder'>Выключены</h4>
                    <article class='w-100 h-100 table-items'  id='deactive-offers'>
                        @foreach ($advertiser->offers->all() as $offer)
                            @if ($offer->status == 0)
                            <article id="{{$offer->id}}" class='border-666 mb-1 rounded cursor-pointer bg-light position-relative offers__item deactive-offers__item' draggable='true'>
                                <p class='fw-bolder'>{{$offer->name}}</p>
                                <p>Цена: {{$offer->price}} р. за переход</p>
                                <p class='table-offers__td-link-count'>Подписчиков: {{$offer->links->count()}} </p>
                                <button class='position-absolute bottom-0 right-0 m-1 offers__btn-remove' title='Удалить'>🗑</button>
                            </article>
                            @endif
                        @endforeach
                    </article>
                </article>
            </section>

        </section>
    </section>
</x-app-layout>