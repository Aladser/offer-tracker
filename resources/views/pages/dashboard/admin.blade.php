<x-app-layout>
    @section('title')
        <x-title>Панель администратора</x-title>
    @endsection

    @section('css')
        <link href="/css/admin.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/websockets/FrontWebsocket.js" defer></script>
        <script src="/js/websockets/AdminFrontWebsocket.js" defer></script>
        <script src="/js/CommissionCtl.js" defer></script>
        <script src="/js/pages/dashboard/admin.js" defer></script>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Панель администратора</h2>
    </x-slot>

    <div class="py-12">
        <div class="w-75 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="p-6 bg-white border-b border-gray-200 text-center">
                    <a href="{{route('users.index')}}" class='btn btn-outline-dark'>Пользователи</a>
                    <a href="{{route('offer-theme.index')}}" class='btn btn-outline-dark'>Темы офферов</a>

                    <article class='mt-4'>
                        <h3 class='fw-bold w-75 mx-auto mb-2'>Доход системы за все время</h3>
                        <table class='table-admin-statistics table mx-auto w-50 fs-5'>
                            <tr> <td class='w-50 fw-bolder' id=''>Реферальных ссылок</td><td id='table-admin-statistics__subscriptions'>{{$subscriptionCount}}</td> </tr>
                            <tr> <td class='w-50 fw-bolder'>Число переходов</td><td id='table-admin-statistics__clicks'>{{$clicks}}</td> </tr>
                            <tr> <td class='w-50 fw-bolder'>Доход системы</td><td id='table-admin-statistics__system-income'>{{$income}} руб.</td> </tr>
                            <tr> <td class='w-50 fw-bolder'>Отказы реферальных ссылок</td><td id='table-admin-statistics__failed_clicks'>{{$failed_references}}</td> </tr>
                        </table>
                    </article>

                    <article class="mt-4 w-75 mx-auto d-flex flex-column align-items-center article-commission">
                        <h3 class='fw-bold w-50 pb-4'>Комиссия системы (%)</h3>
                        <form id='form-change-commission' class='input-group w-50'>
                            @csrf
                            <div class='position-relative w-75 mx-auto'>
                                <input type="number" name='commission' id='input-change-commission' class='form-control text-center' value="{{$commission}}" size='100' required>
                                <p class='article-commission__prg-submit'>
                                    <input type="submit" value="✓"  class='article-commission__btn-submit d-none' id='btn-change-commission' title='сохранить'>
                                </p>
                            </div>
                        </form>
                        <p id='prg-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
                    </article>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
