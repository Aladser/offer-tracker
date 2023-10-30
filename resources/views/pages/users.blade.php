<x-app-layout>
    @section('title')
        <x-title>Пользователи</x-title>
    @endsection

    @section('meta')
        <meta name='websocket' content="{{env('WEBSOCKET_ADDR')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection
    
    @section('js')
        <script src="/js/ServerRequest.js" defer></script>
        <script src="/js/websockets/ClientWebsocket.js" defer></script>
        <script src="/js/websockets/RegisterClientWebsocket.js" defer></script>
        <script src="/js/TableClientControllers/TableClientController.js" defer></script>
        <script src="/js/TableClientControllers/UserTableClientController.js" defer></script>
        <script src="/js/pages/users.js" defer></script>
    @endsection

    @section('css')
        <link href="/css/users.css" rel="stylesheet" />
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Пользователи</h2>
    </x-slot>

    <section class='mx-auto section-content'>
        <section class="p-6 bg-white border-b border-gray-200 text-center fs-4 mx-auto mt-4">
            
            <a href="{{route('dashboard')}}" class='inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                        hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900 mb-2 w-52'>Вернуться в профиль</a><br>

            <article class='mb-4 mx-auto'>
                <h3 class='header-new-user font-semibold mx-auto p-2 text-2xl'>Добавить нового пользователя</h3>
                <form method='post' id='form-add-user' class='w-1/2 mx-auto'>
                    @csrf
                    <label for="form-add-user__name" class='block mb-2 font-medium text-gray-900 dark:text-white p-1 ps-2 text-left'>Имя:</label>
                    <input type="text" name="name" class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500' id="form-add-user__name" required>

                    <label for="form-add-user__email" class='block mb-2 font-medium text-gray-900 dark:text-white p-1 ps-2 text-left'>Почта:</label>
                    <input type="email" name="email" class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500' id="form-add-user__email" required>

                    <label for="form-add-user__password1" class='block mb-2 font-medium text-gray-900 dark:text-white p-1 ps-2 text-left'>Пароль:</label>
                    <input type="password" name="password1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" id="form-add-user__password1" required autocomplete="new-password" required>

                    <label for="form-add-user__password2" class="block mb-2 font-medium text-gray-900 dark:text-white p-1 ps-2 text-left">Подтвердите пароль:</label>
                    <input type="password" name="password2" class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500' id="form-add-user__password2" required autocomplete="new-password" required>

                    <label for="form-add-user__role" class='block mb-2 font-medium text-gray-900 dark:text-white p-1 ps-2 text-left'>Почта:</label>
                    <select name="role" class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500' id="form-add-user__role">
                    @foreach ($roles as $role)
                        <option value="{{$role['name']}}">{{$role['name']}}</option>
                    @endforeach
                    </select><br>

                    <input type="submit" class='inline-block rounded border border-neutral-800 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-neutral-800 transition duration-150 ease-in-out hover:border-neutral-800 hover:bg-neutral-500 hover:bg-opacity-10 
                        hover:text-neutral-800 focus:border-neutral-800 focus:text-neutral-800 focus:outline-none focus:ring-0 active:border-neutral-900 
                        active:text-neutral-900 dark:border-neutral-900 dark:text-neutral-900 dark:hover:border-neutral-900 dark:hover:bg-neutral-100 
                        dark:hover:bg-opacity-10 dark:hover:text-neutral-900 dark:focus:border-neutral-900 dark:focus:text-neutral-900 dark:active:border-neutral-900 
                        dark:active:text-neutral-900 w-52' value='Добавить' id='form-add-user__btn-submit' disabled>
                </form>
                <p id='form-add-error' class='font-semibold pt-4 text-center text-red-500'></p>
            </article>

            <article>
                <h3 class='font-semibold mx-auto p-2 text-2xl'>Список пользователей</h3>
                <table class='table-auto mx-auto w-11/12 text-sm text-left text-gray-500 dark:text-gray-400 border' id='table-users'>
                    <thead class='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400'>
                        <tr> 
                            <th class='p-2'>Имя</th> 
                            <th class='p-2'>E-mail</th> 
                            <th class='p-2'>Статус</th>
                            <th class='p-2'>Роль</th> 
                        </tr>
                    <thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class='table-users__tr relative' id="{{$user->id}}"> 
                            <td class='p-2'>{{$user->name}}</td>
                            <td class='p-2'>{{$user->email}}</td>
                            
                            <td class='p-2'>
                                <label class='switch'>
                                    @if ($user->status===1)
                                    <input type="checkbox" name="status" class='table-offers__input-status mx-auto' title='выключить' checked> 
                                    @else
                                    <input type="checkbox" name="status" class='table-offers__input-status mx-auto' title='включить'>
                                    @endif
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class='p-2'>{{$user->role->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </article>

        </section>
    </section>
</x-app-layout>
