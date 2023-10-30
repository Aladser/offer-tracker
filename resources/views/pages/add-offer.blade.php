<x-app-layout>
    @section('title')
        <x-title>Добавить новый оффер</x-title>
    @endsection

    @section('css')
        <link href="/css/addOffer.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/ServerRequest.js" defer></script>
        <script src="/js/TableClientControllers/TableClientController.js" defer></script>
        <script src="/js/TableClientControllers/OfferTableClientController.js" defer></script>
        <script src="/js/pages/addOffer.js" defer></script>
    @endsection

    <section class='mx-auto section-content bg-white my-2 p-2'>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить новый оффер</h2>
        </x-slot>

        <form action='/' method='post' id='form-add-new-product' class='section-content__form mt-3 mx-auto p-4'>
            @csrf
            
            <label for="offer-new__name" class='font-medium text-gray-900 dark:text-white p-2'>Имя:</label><br>
            <input type="text" name="name" class='border p-2 mt-2 w-full' id="offer-new__name" required><br>

            <label for="offer-new__price" class='font-medium text-gray-900 dark:text-white p-1 text-left'>Цена:</label><br>
            <input type="number" name="price" class='border p-2 w-full' id="offer-new__price" required><br>

            <label for="offer-new__name" class='font-medium text-gray-900 dark:text-white p-1 text-left'>URL:</label><br>
            <input type="url" name="url" class='border p-2 w-full' id="offer-new__url" required><br>

            <label for="offer-new__name" class='font-medium text-gray-900 dark:text-white p-1 text-left'>Тема:</label><br>
            <select name="theme" class='border p-2 bg-white w-full mb-2' id="offer-new__theme">
                @foreach ($themes as $theme)
                <option value="{{$theme->name}}">{{$theme->name}}</option>
                @endforeach
            </select><br>
            <div class='mt-3 w-full text-center'>
                <input type="submit" class='section-content__btn inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out 
                        hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 hover:text-neutral-800 
                        focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900 w-52' value='Добавить'>
                <a href="{{route('dashboard')}}" class='inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out 
                        hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 hover:text-neutral-800 
                        focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900 w-52'>Назад</a>
            </div>
        </form>
        <p id='form-add-error' class='font-semibold pt-2 pb-2 fs-4 text-center text-red-500 text-xl'></p>
    </section>
</x-app-layout>
