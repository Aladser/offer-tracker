<x-app-layout>
    @section('title')
        <x-title> Статистика</x-title>
    @endsection

    @section('js')
        <script src="/js/statistics.js" defer></script>
    @endsection

    <x-slot name="header">
        @if ($user->role->name === 'рекламодатель')
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Статистика расходов и количества переходов офферов</h2>
        @else
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Статистика доходов и количества переходов офферов</h2>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="w-50 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="p-6 bg-white border-b border-gray-200 text-center">
                    <a href="/dashboard" class='btn btn-outline-dark float-end mb-4'>Вернуться в профиль</a><br>

                    <article class='time-period-article mb-2 d-flex justify-content-center w-100'>
                            <p class='d-inline-block fw-bold'>Отчетный период: </p>&nbsp;&nbsp;
                            <form id='time-period-article__switcher'>
                                <input type="hidden" value='{{$user->id}}' id='time-period-article__input-id'>
                                <p class='d-inline-block'><input name="times" type="radio" value="last-day">  Последний день</p>&nbsp;&nbsp;
                                <p class='d-inline-block'><input name="times" type="radio" value="last-month">  Последний месяц</p>&nbsp;&nbsp;
                                <p class='d-inline-block'><input name="times" type="radio" value="last-year">  Последний год</p>&nbsp;&nbsp;
                                <p class='d-inline-block'><input name="times" type="radio" value="all-time" checked> Все время</p>
                            </form>
                    </article>

                     <!-- сделано намеренно несколько копий таблицы, чтобы не было запросов к БД и выполнения кода построения таблицы -->
                    <!-- полная таблица -->
                    <table class='table w-75 mx-auto fs-4 w-100' id='table-offers'>
                        <tr>
                            <th scope="col">Оффер</th>
                            <th scope="col">Число переходов</th>
                            <th scope="col">{{$user->role->name === 'рекламодатель' ? 'Расходы' : 'Доходы'}}</th>
                        </tr>
                        @foreach ($offersAllTime['offers'] as $offer)
                            <tr data-id="{{$offer['id']}}" class='table-offers__tr position-relative'>
                                <td class='fw-bolder'>{{$offer['name']}}</td>
                                <td>{{$offer['clicks']}} </td>
                                <td>{{$offer['money']}} р.</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="fw-bolder table-secondary">Всего</td>
                            <td class="fw-bolder table-secondary">{{$offersAllTime['totalClicks']}}</td>
                            <td class="fw-bolder table-secondary">{{$offersAllTime['totalMoney']}} р.</td>
                        </tr>
                    </table>


                    <!-- последний день id='table-offers-last-day'-->
                    <table class='table w-75 mx-auto fs-4 w-100 d-none' id='table-offers-last-day'>
                        <tr>
                            <th scope="col">Оффер</th>
                            <th scope="col">Число переходов</th>
                            <th scope="col">{{$user->role->name === 'рекламодатель' ? 'Расходы' : 'Доходы'}}</th>
                        </tr>
                        @foreach ($offersLastDay['offers'] as $offer)
                            <tr data-id="{{$offer['id']}}" class='table-offers__tr position-relative'>
                                <td class='fw-bolder'>{{$offer['name']}}</td>
                                <td>{{$offer['clicks']}} </td>
                                <td>{{$offer['money']}} р.</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="fw-bolder table-secondary">Всего</td>
                            <td class="fw-bolder table-secondary">{{$offersLastDay['totalClicks']}}</td>
                            <td class="fw-bolder table-secondary">{{$offersLastDay['totalMoney']}} р.</td>
                        </tr>
                    </table>


                    <!-- последний месяц id='table-offers-last-month'-->
                    <table class='table w-75 mx-auto fs-4 w-100 d-none' id='table-offers-last-month'>
                        <tr>
                            <th scope="col">Оффер</th>
                            <th scope="col">Число переходов</th>
                            <th scope="col">{{$user->role->name === 'рекламодатель' ? 'Расходы' : 'Доходы'}}</th>
                        </tr>
                        @foreach ($offersLastMonth['offers'] as $offer)
                            <tr data-id="{{$offer['id']}}" class='table-offers__tr position-relative'>
                                <td class='fw-bolder'>{{$offer['name']}}</td>
                                <td>{{$offer['clicks']}} </td>
                                <td>{{$offer['money']}} р.</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="fw-bolder table-secondary">Всего</td>
                            <td class="fw-bolder table-secondary">{{$offersLastMonth['totalClicks']}}</td>
                            <td class="fw-bolder table-secondary">{{$offersLastMonth['totalMoney']}} р.</td>
                        </tr>
                    </table>

                    
                    <!-- последний год id='table-offers-last-year'-->
                    <table class='table w-75 mx-auto fs-4 w-100 d-none' id='table-offers-last-year'>
                        <tr>
                            <th scope="col">Оффер</th>
                            <th scope="col">Число переходов</th>
                            <th scope="col">{{$user->role->name === 'рекламодатель' ? 'Расходы' : 'Доходы'}}</th>
                        </tr>
                        @foreach ($offersLastYear['offers'] as $offer)
                            <tr data-id="{{$offer['id']}}" class='table-offers__tr position-relative'>
                                <td class='fw-bolder'>{{$offer['name']}}</td>
                                <td>{{$offer['clicks']}} </td>
                                <td>{{$offer['money']}} р.</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="fw-bolder table-secondary">Всего</td>
                            <td class="fw-bolder table-secondary">{{$offersLastYear['totalClicks']}}</td>
                            <td class="fw-bolder table-secondary">{{$offersLastYear['totalMoney']}} р.</td>
                        </tr>
                    </table>

                </section>
            </div>
        </div>
    </div>
</x-app-layout>
