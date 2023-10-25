<x-app-layout>
    @section('title')
        <x-title>Темы офферов</x-title>
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

    <section class="p-6 bg-white border-b border-gray-200 text-center fs-4 w-75 mx-auto mt-4">
        <a href="{{route('dashboard')}}" class='btn btn-outline-dark float-end mb-4'>Вернуться в профиль</a><br>
        <article class='mb-4'>
            <h3 class='fw-bold w-50 mx-auto'>Добавить новую тему</h3>
            <form action='/' method='post' id='form-add-theme' class='text-center mt-4 w-75 mx-auto'>
                @csrf
                <label for="offer-new__name" class='fw-bolder w-75 text-center ps-2'>Название:</label><br>
                <input type="text" name="name" class='w-75 mb-4 border' id="offer-new__name" required><br>
                <input type="submit" class='btn btn-outline-dark' value='Добавить'>
            </form>
            <p id='form-add-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
        </article>

        <article>
            <h3 class='h3 fw-bold'>Список тем офферов</h3>
            <table class='table w-50 mx-auto' id='table-themes'>
                @foreach ($themes as $theme)
                <tr id="{{$theme['id']}}" class='table-themes__tr position-relative'>
                    <td class='cursor-pointer'>{{$theme['name']}}</td>
                </tr>
                @endforeach
            </table>
        </article>
    </section>
</x-app-layout>
