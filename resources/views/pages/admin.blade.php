<x-app-layout>
    @section('css')
        <link href="/css/adminPage.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/OfferThemeFrontCtl.js" defer></script>
        <script src="/js/adminPage.js" defer></script>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Страница администратора
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-75 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center fs-4">
                    <article class='mb-4'>
                    <h3 class='h3 fw-bold'>Добавить новую тему</h3>
                        <form action='/' method='post' id='form-add-theme' class='text-center mt-4 w-75 mx-auto'>
                            @csrf
                            <label for="offer-new__name" class='fw-bolder w-50 text-start ps-2'>Название:</label><br>
                            <input type="text" name="name" class='w-50 mb-2 border' id="offer-new__name" required><br>
                            <input type="submit" class='btn btn-outline-dark col-2' value='Добавить'>
                        </form>
                        <p id='form-add-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
                    </article>

                    <article>
                        <h3 class='h3 fw-bold'>Список тем офферов</h3>
                        <table class='table w-50 mx-auto' id='table-themes'>
                            @foreach ($themes as $theme)
                            <tr data-id="{{$theme['id']}}" class='table-themes__tr position-relative'>
                                <td>{{$theme['name']}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </article>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
