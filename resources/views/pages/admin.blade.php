<x-app-layout>
    @section('css')
        <link href="/css/admin.css" rel="stylesheet" />
    @endsection

    @section('js')
        <script src="/js/admin.js" defer></script>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Панель администратора</h2>
    </x-slot>

    <div class="py-12">
        <div class="w-75 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="p-6 bg-white border-b border-gray-200 text-center">
                    <a href="/offer-theme" class='btn btn-outline-dark col-2'>Темы офферов</a>

                    <article class='mt-4'>
                        <h3 class='fw-bold w-50 mx-auto mb-2'>Доход системы за все время</h3>
                        <table class='table mx-auto w-50'>
                            <tr> <td class='w-50 fw-bolder'>Число переходов</td><td>{{$income['clicks']}}</td> </tr>
                            <tr> <td class='w-50 fw-bolder'>Доход</td><td>{{$income['income']}} руб.</td> </tr>
                        </table>
                    </article>

                    <article class='mt-4 position-relative'>
                        <h3 class='fw-bold w-50 mx-auto mb-2'>Комиссия системы (%)</h3>
                        <form id='form-change-commission'>
                            <div class='position-relative col-2 mx-auto'>
                                <input type="number" name='commission' id='input-change-commission' class='text-center fs-4 fw-bolder border border-opacity-25 position-relative' value="{{$income['commission']}}" size='100' required>
                                <input type="submit" value="✓"  class='position-absolute p-1 bg-ddd rounded-circle d-none' id='btn-change-commission' title='сохранить'>
                            </div>
                        </form>
                        <p id='prg-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
                    </article>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
