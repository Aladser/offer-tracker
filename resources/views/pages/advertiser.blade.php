<x-app-layout>
    <section class='w-50 mx-auto'>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Панель офферов</h2>
        </x-slot>

        <article class='pt-4'>
            <h3 class='h3 fw-bolder m-0 text-center pb-2'>Добавление нового оффера</h3>
            <form action='/' method='post' id='form-add-new-product' class='text-center'>
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
                    <option value="{{$theme}}">{{$theme}}</option>
                    @endforeach
                </select><br>
                <input type="submit" class='btn btn-outline-dark' value='Добавить'>
            </form>
        </article>

        <article class="mt-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-white border-b border-gray-200 text-center">
                        <h3 class='h3 pb-3 fw-bolder'>Список офферов</h3>
                        <table class='table w-75 mx-auto fs-4 w-100'>
                            <tr>
                                <th scope="col">Оффер</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Подписчики</th>
                            </tr>

                            @foreach ($user->offers->all() as $product)
                                <tr class='{{$product->id}}'>
                                    <td class='fw-bolder'>{{$product->name}}</td>
                                    <td>{{$product->price}} </td>
                                    <td class='p-0'>
                                        <div class='form-switch p-0 h-100'>
                                            @if ($product->status===1)
                                            <input type="checkbox" name="status" class='form-check-input mx-auto' checked> 
                                            @else
                                            <input type="checkbox" name="status" class='form-check-input mx-auto'>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{$product->links->count()}} </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
        </article>
    </section>
    
    <script src="/js/OfferFrontCtl.js"></script>
    <script src="/js/advertiserPage.js"></script>
</x-app-layout>
