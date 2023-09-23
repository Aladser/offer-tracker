<x-app-layout>
    @section('js')
        <script src="/js/statistics.js" defer></script>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Статистика доходов и количества переходов офферов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-50 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="p-6 bg-white border-b border-gray-200 text-center">
                    <a href="/dashboard" class='btn btn-outline-dark float-end mb-4'>Вернуться на главную</a><br>

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

                    <table class='table w-75 mx-auto fs-4 w-100' id='table-offers'>
                        <tr>
                            <th scope="col">Оффер</th>
                            <th scope="col">Число переходов</th>
                            <th scope="col">Доходы</th>
                        </tr>

                        @foreach ($user->offers->all() as $product)
                            <tr data-id='{{$product->id}}' class='table-offers__tr position-relative'>
                                <td class='fw-bolder'>{{$product->name}}</td>
                                <td>{{$product->links->count()}} </td>
                                <td>{{$product->links->count() * $product->price}} р.</td>
                            </tr>
                        @endforeach
                    </table>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
