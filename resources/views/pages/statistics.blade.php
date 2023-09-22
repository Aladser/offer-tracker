<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Статистика доходов и количества переходов офферов
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-75 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="p-6 bg-white border-b border-gray-200 text-center display-5">
                    <a href="/dashboard" class='btn btn-outline-dark'>Вернуться на главную</a>
                    <p>Рекламодатель {{$user->name}}</p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
