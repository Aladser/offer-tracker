<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('app.profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-75 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200 text-center">
                <section>
                    <h3 class='h2 pb-3 fw-bolder'>Список офферов</h3>
                    <table class='table w-75 mx-auto fs-4'>
                        <tr>
                            <th scope="col">Оффер</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Подписчики</th>
                        </tr>

                        @foreach ($user->advertiser_products->all() as $product)
                            <tr>
                                <td class='fw-bolder'>{{$product->offer->name}}</td>
                                <td>{{$product->price}} </td>
                                @if ($product->status===1)
                                <td class='fw-bolder text-success'>активен</td> 
                                @else
                                <td class='fw-bolder text-danger'>неактивен</td> 
                                @endif
                                <td>{{$product->links->count()}} </td>
                            </tr>
                        @endforeach
                    </table>
                </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
