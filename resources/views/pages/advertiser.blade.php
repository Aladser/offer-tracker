<x-app-layout class='position-relative'>
    @section('css')
        <link href="/css/advertiserPage.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/frontCtl/OfferFrontCtl.js" defer></script>
        <script src="/js/advertiserPage.js" defer></script>
    @endsection

    <section class='w-50 mx-auto'>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Панель рекламодателя</h2>
        </x-slot>

        <article class='pt-4 text-center'>
            <a href="/offer/create" class='btn btn-outline-dark col-3'>Добавить оффер</a>
            <a href="/advertiser/{{$userId}}/index" class='btn btn-outline-dark col-3'>Статистика офферов</a>
        </article>
        
        <article class="mt-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-white border-b border-gray-200 text-center">
                        <h3 class='h3 pb-3 fw-bolder'>Список офферов</h3>
                        <table class='table w-75 mx-auto fs-4 w-100' id='table-offers'>
                            <tr>
                                <th scope="col">Оффер</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Подписчики</th>
                            </tr>

                            @foreach ($advertiser->offers->all() as $offer)
                                <tr data-id='{{$offer->id}}' class='table-offers__tr position-relative'>
                                    <td class='fw-bolder'>{{$offer->name}}</td>
                                    <td>{{$offer->price}} р.</td>
                                    <td class='p-0'>
                                        <div class='form-switch p-0 h-100'>
                                            @if ($offer->status===1)
                                            <input type="checkbox" name="status" class='table-offers__input-status form-check-input mx-auto' title='выключить' checked> 
                                            @else
                                            <input type="checkbox" name="status" class='table-offers__input-status form-check-input mx-auto' title='включить' >
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{$offer->clicks->count()}} </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
        </article>
    </section>
</x-app-layout>