<x-app-layout>
    @section('css')
        <link href="/css/webmaster.css" rel="stylesheet" />
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('app.profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-75 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200 m-0 d-flex justify-content-between text-center">
                    <!-- офферы пользователя -->
                    <section class='w-50 d-inline-block m-0 p-3 border-2 border-top-0 border-start-0 border-bottom-0'>
                        <h4 class='h4 fw-bolder'>Ваши офферы</h4>
                        <section class='w-100'>
                            @foreach ($subscriptions->get() as $subscription)
                            <article class='border-666 mb-1 rounded cursor-pointer'>
                                <p class='fw-bolder'>{{$subscription->offer->name}}</p>
                                <p>цена: {{$subscription->offer->price}}р.</p>
                                <p>тема: {{$subscription->offer->theme->name}}</p>
                                @if ($subscription->offer->status==1)
                                    <p class='text-success'>активен</p>
                                @else
                                    <p class='text-danger'>неактивен</p>
                                @endif
                            </article>
                            @endforeach
                        </section>
                    </section>

                    <!-- доступные активные офферы -->
                    <section class='w-50 d-inline-block m-0 p-3'>
                        <h4 class='h4 fw-bolder'>Доступные офферы</h4>
                        <section class='w-100'>
                            @foreach ($offers->get() as $offer)
                                <article class='border-666 mb-1 rounded cursor-pointer'>
                                    <p>{{$offer->name}}</p>
                                    <p>{{$offer->price}}</p>
                                    <p>{{$offer->theme->name}}</p>
                                </article>
                            @endforeach
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
