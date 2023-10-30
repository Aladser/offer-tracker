<x-app-layout>
    @section('title')
        <x-title>Статистика</x-title>
    @endsection

    @section('meta')
        <meta name='websocket' content="{{env('WEBSOCKET_ADDR')}}">
    @endsection

    @section('css')
        <link href="/css/statistics.css" rel="stylesheet" />
    @endsection
    @section('js')
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/StatisticsClientWebsocket.js" defer></script>
        <script src="/js/pages/statistics.js" defer></script>
    @endsection

    <x-slot name="header">
        @if ($user->role->name === 'рекламодатель')
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Статистика расходов и количества переходов офферов</h2>
        @else
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Статистика доходов и количества переходов офферов</h2>
        @endif
    </x-slot>

    <section class='mx-auto section-content'>
        <section class="section-content__stat-content p-6 bg-white border-b border-gray-200 text-center mt-4 mx-auto">
            <a href="{{route('dashboard')}}" class='inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out 
                        hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 hover:text-neutral-800 
                        focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900 w-52 mb-3'>Вернуться в профиль</a><br>

            <article class='time-period-article mb-2 flex justify-center w-full'>
                    <p class='inline-block font-semibold'>Отчетный период: </p>&nbsp;&nbsp;
                    <form id='time-period-article__switcher'>
                        <input type="hidden" value='{{$user->id}}' id='time-period-article__input-id'>
                        <p class='inline-block'><input name="times" type="radio" value="last-day">  Последний день</p>&nbsp;&nbsp;
                        <p class='inline-block'><input name="times" type="radio" value="last-month">  Последний месяц</p>&nbsp;&nbsp;
                        <p class='inline-block'><input name="times" type="radio" value="last-year">  Последний год</p>&nbsp;&nbsp;
                        <p class='inline-block'><input name="times" type="radio" value="all-time" checked> Все время</p>
                    </form>
            </article>

            <!-- сделано намеренно несколько копий таблицы, чтобы не было запросов к БД и выполнения кода построения таблицы -->
            <!-- полная таблица -->
            <table class='section-content__table table-auto mx-auto text-2xl text-left dark:text-gray-400 border w-full' id='table-offers'>
                <thead class='text-xl uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400'>
                    <tr>
                        <th scope="col" class='p-3'>Оффер</th>
                        <th scope="col">Число переходов</th>
                        <th scope="col">{{$user->role->name === 'рекламодатель' ? 'Расходы' : 'Доходы'}}</th>
                    </tr>
                </thead>
                @foreach ($offersAllTime['offers'] as $offer)
                    <tr data-id="{{$offer['id']}}" class='table-offers__tr position-relative'>
                        <td class='p-3 fw-bolder'>{{$offer['name']}}</td>
                        <td class='table-offers__clicks'>{{$offer['clicks']}} </td>
                        <td class='table-offers__money'>{{$offer['money']}} р.</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="p-3 font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">Всего</td>
                    <td class="font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 table-offers__total-clicks">{{$offersAllTime['totalClicks']}}</td>
                    <td class="font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 table-offers__total-money">{{$offersAllTime['totalMoney']}} р.</td>
                </tr>
            </table>

            <!-- последний день id='table-offers-last-day'-->
            <table class='section-content__table table-auto mx-auto text-2xl text-left dark:text-gray-400 border w-full hidden' id='table-offers-last-day'>
                <thead class='text-xl uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400'>
                    <tr>
                        <th scope="col" class='p-3'>Оффер</th>
                        <th scope="col">Число переходов</th>
                        <th scope="col">{{$user->role->name === 'рекламодатель' ? 'Расходы' : 'Доходы'}}</th>
                    </tr>
                </thead>
                @foreach ($offersLastDay['offers'] as $offer)
                    <tr data-id="{{$offer['id']}}" class='table-offers__tr position-relative'>
                        <td class='p-3 fw-bolder'>{{$offer['name']}}</td>
                        <td class='table-offers__clicks'>{{$offer['clicks']}} </td>
                        <td class='table-offers__money'>{{$offer['money']}} р.</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="p-3 font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">Всего</td>
                    <td class="font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 table-offers__total-clicks">{{$offersLastDay['totalClicks']}}</td>
                    <td class="font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 table-offers__total-money">{{$offersLastDay['totalMoney']}} р.</td>
                </tr>
            </table>


            <!-- последний месяц id='table-offers-last-month'-->
            <table class='section-content__table table-auto mx-auto text-2xl text-left dark:text-gray-400 border w-full hidden' id='table-offers-last-month'>
                <thead class='text-xl uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400'>
                    <tr>
                        <th scope="col" class='p-3'>Оффер</th>
                        <th scope="col">Число переходов</th>
                        <th scope="col">{{$user->role->name === 'рекламодатель' ? 'Расходы' : 'Доходы'}}</th>
                    </tr>
                </thead>
                @foreach ($offersLastMonth['offers'] as $offer)
                    <tr data-id="{{$offer['id']}}" class='table-offers__tr position-relative'>
                        <td class='p-3 fw-bolder'>{{$offer['name']}}</td>
                        <td class='table-offers__clicks'>{{$offer['clicks']}} </td>
                        <td class='table-offers__money'>{{$offer['money']}} р.</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="p-3 font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">Всего</td>
                    <td class="font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 table-offers__total-clicks">{{$offersLastMonth['totalClicks']}}</td>
                    <td class="font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 table-offers__total-money">{{$offersLastMonth['totalMoney']}} р.</td>
                </tr>
            </table>
            
            <!-- последний год id='table-offers-last-year'-->
            <table class='section-content__table table-auto mx-auto text-2xl text-left dark:text-gray-400 border w-full hidden' id='table-offers-last-year'>
                <thead class='text-xl uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400'>
                    <tr>
                        <th scope="col" class='p-3'>Оффер</th>
                        <th scope="col">Число переходов</th>
                        <th scope="col">{{$user->role->name === 'рекламодатель' ? 'Расходы' : 'Доходы'}}</th>
                    </tr>
                </thead>
                @foreach ($offersLastYear['offers'] as $offer)
                    <tr data-id="{{$offer['id']}}" class='table-offers__tr position-relative'>
                        <td class='p-3 fw-bolder'>{{$offer['name']}}</td>
                        <td class='table-offers__clicks'>{{$offer['clicks']}} </td>
                        <td class='table-offers__money'>{{$offer['money']}} р.</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="p-3 font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">Всего</td>
                    <td class="font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 table-offers__total-clicks">{{$offersLastYear['totalClicks']}}</td>
                    <td class="font-semibold uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 table-offers__total-money">{{$offersLastYear['totalMoney']}} р.</td>
                </tr>
            </table>
        </section>
    </section>
</x-app-layout>
