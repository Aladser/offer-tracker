<x-app-layout>
    @section('title')
        <x-title>Добавить новый оффер</x-title>
    @endsection

    @section('js')
        <script src="/js/StatusFunc.js" defer></script>
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/AdvertiserClientWebsocket.js" defer></script>
        <script src="/js/TableFrontControllers/TableFrontController.js" defer></script>
        <script src="/js/TableFrontControllers/OfferTableFrontController.js" defer></script>
        <script src="/js/pages/addOffer.js" defer></script>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Добавить новый оффер</h2>
    </x-slot>

    <form action='/' method='post' id='form-add-new-product' class='text-center mt-4 w-75 mx-auto'>
        @csrf
        
        <label for="offer-new__name" class='fw-bolder w-50 text-start ps-2'>Имя:</label><br>
        <input type="text" name="name" class='w-50 mb-2 border' id="offer-new__name" required><br>

        <label for="offer-new__price" class='fw-bolder w-50 text-start ps-2'>Цена:</label><br>
        <input type="number" name="price" class='w-50 mb-2 border' id="offer-new__price" required><br>

        <label for="offer-new__name" class='fw-bolder w-50 text-start ps-2'>URL:</label><br>
        <input type="url" name="url" class='w-50 mb-2 border' id="offer-new__url" required><br>

        <label for="offer-new__name" class='fw-bolder w-50 text-start ps-2'>Тема:</label><br>
        <select name="theme" class='w-50 mb-2 border' id="offer-new__theme">
            @foreach ($themes as $theme)
            <option value="{{$theme->name}}">{{$theme->name}}</option>
            @endforeach
        </select><br>
        <div class='mt-3'>
            <input type="submit" class='btn btn-outline-dark col-2' value='Добавить'>
            <a href="{{route('dashboard')}}" class='btn btn-outline-dark col-2'>Назад</a>
        </div>
    </form>
    <p id='form-add-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
</x-app-layout>
