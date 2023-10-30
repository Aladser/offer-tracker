<x-app-layout>
    @section('title')
        <x-title>Панель администратора</x-title>
    @endsection

    @section('meta')
        <meta name='websocket' content="{{env('WEBSOCKET_ADDR')}}">
    @endsection

    @section('css')
        <link href="/css/admin.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/ServerRequest.js" defer></script>
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/AdminClientWebsocket.js" defer></script>
        <script src="/js/CommissionCtl.js" defer></script>
        <script src="/js/pages/dashboard/admin.js" defer></script>
    @endsection

    <section class='mx-auto section-content'>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Панель администратора</h2>
        </x-slot>
        
        <section class="p-6 bg-white border-b border-gray-200 text-center mt-4">
            <a href="{{route('users.index')}}" class="inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                        hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900">Пользователи</a>
            <a href="{{route('offer-theme.index')}}" class="inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                        hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900">Темы офферов</a>

            <article class='pt-5 pb-5'>
                <h3 class='font-semibold text-2xl mx-auto mb-2'>Доход системы за все время</h3>
                <table class='mx-auto text-xl'>
                    <tr> <td class='border-b-2 p-2' id=''>Реферальных ссылок</td><td  class='border-b-2 px-6' id='table-admin-statistics__subscriptions'>{{$subscriptionCount}}</td> </tr>
                    <tr> <td class='border-b-2 p-2'>Число переходов</td><td  class='border-b-2 px-6' id='table-admin-statistics__clicks'>{{$clicks}}</td> </tr>
                    <tr> <td class='border-b-2 p-2'>Доход системы</td><td  class='border-b-2 px-6' id='table-admin-statistics__system-income'>{{$income}} руб.</td> </tr>
                    <tr> <td class='border-b-2 p-2'>Отказы реферальных ссылок</td><td  class='border-b-2 px-6' id='table-admin-statistics__failed_clicks'>{{$failed_references}}</td> </tr>
                </table>
            </article>

            <article class="mt-4 mx-auto article-commission">
                <h3 class='pb-4 font-semibold text-2xl'>Комиссия системы (%)</h3>
                <form id='form-change-commission'>
                    @csrf
                    <div class='mx-auto text-6xl relative'>
                        <input type="number" name='commission' id='input-change-commission' class='text-center border border-solid w-36' value="{{$commission}}" size='100' required>
                        <p class='inline absolute'><input type="submit" value="✓" class='hidden' id='btn-change-commission' title='сохранить'></p>
                    </div>
                </form>
                <p id='prg-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
            </article>
        </section>
    </section>
</x-app-layout>
