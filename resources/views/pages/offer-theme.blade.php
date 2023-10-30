<x-app-layout>
    @section('title')
        <x-title>Темы офферов</x-title>
    @endsection

    @section('meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection

    @section('js')
        <script src="/js/ServerRequest.js" defer></script>
        <script src="/js/TableClientControllers/TableClientController.js" defer></script>
        <script src="/js/TableClientControllers/OfferThemeTableClientController.js" defer></script>
        <script src="/js/pages/addOfferTheme.js" defer></script>
    @endsection

    @section('css')
        <link href="/css/addOfferTheme.css" rel="stylesheet" />
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Темы офферов
        </h2>
    </x-slot>

    <section class="p-10 text-center mx-auto mt-4 bg-white border-b border-gray-200 section-content">
        <a href="{{route('dashboard')}}" class="inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                        hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900" float-end mb-4'>Вернуться в профиль</a><br>
        <article class='mb-4 mt-4 text-xl'>
            <h3 class='font-semibold mx-auto'>Добавить новую тему</h3>
            <form action='/' method='post' id='form-add-theme' class='text-center mt-4 mx-auto'>
                @csrf
                <label for="offer-new__name">Название:</label><br>
                <input type="text" name="name" class='mb-4 border text-center p-1 w-1/2' id="offer-new__name" required><br>
                <input type="submit" class="inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                        hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900" value='Добавить'>
            </form>
            <p id='form-add-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
        </article>

        <article class='text-xl'>
            <h3 class='font-semibold mx-auto mb-2'>Список тем офферов</h3>
            <table class='table-auto mx-auto w-1/2' id='table-themes'>
                @foreach ($themes as $theme)
                <tr id="{{$theme['id']}}" class='table-themes__tr relative'>
                    <td class='cursor-pointer p-2'>{{$theme['name']}}</td>
                </tr>
                @endforeach
            </table>
        </article>
    </section>
</x-app-layout>
