<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Статистика доходов и количества переходов офферов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-75 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="p-6 bg-white border-b border-gray-200 text-center display-5 position-relative">
                    <a href="/dashboard" class='btn btn-outline-dark position-absolute top-0 right-0 mt-2 me-2'>Вернуться на главную</a>
                    <p class='fs-4 mt-2 mb-2'>Рекламодатель {{$user->name}}</p>

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
                                <td>{{$product->links->count() * $product->price}}</td>
                            </tr>
                        @endforeach
                    </table>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
