<x-app-layout>
    @section('title')
        <x-title> пользователи</x-title>
    @endsection

    @section('js')
        <script src="/js/services/TableFrontController.js" defer></script>
        <script src="/js/services/UserService.js" defer></script>
        <script src="/js/pages/users.js" defer></script>
    @endsection

    @section('css')
        <link href="/css/users.css" rel="stylesheet" />
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Пользователи</h2>
    </x-slot>

    <section class="p-6 bg-white border-b border-gray-200 text-center fs-4 w-75 mx-auto mt-4">
        
        <a href="{{route('dashboard')}}" class='btn btn-outline-dark float-end mb-4'>Вернуться в профиль</a><br>

        <article class='mb-4 w-75 mx-auto'>
            <h3 class='fw-bold mx-auto'>Добавить нового пользователя</h3>
            <form method='post' id='form-add-user' class='text-center mt-4 w-75 mx-auto'>
                @csrf
                <label for="form-add-user__name" class='fw-bolder text-start ps-2 w-40'>Имя:</label>
                <input type="text" name="name" class='mb-2 border w-50' id="form-add-user__name" required><br>

                <label for="form-add-user__email" class='fw-bolder text-start ps-2 w-40'>Почта:</label>
                <input type="email" name="email" class='mb-2 border w-50' id="form-add-user__email" required><br>

                <label for="form-add-user__password1" class='fw-bolder text-start ps-2 w-40'>Пароль:</label>
                <input type="password" name="password1" class='mb-2 border w-50' id="form-add-user__password1" required autocomplete="new-password" required><br>

                <label for="form-add-user__password2" class='fw-bolder text-start ps-2 w-40'>Подтвердите пароль:</label>
                <input type="password" name="password2" class='mb-2 border w-50' id="form-add-user__password2" required autocomplete="new-password" required><br>

                <label for="form-add-user__role" class='fw-bolder text-start ps-2 w-40'>Почта:</label>
                <select name="role" class='mb-2 border w-50' id="form-add-user__role">
                    @foreach ($roles as $role)
                        <option value="{{$role['name']}}">{{$role['name']}}</option>
                    @endforeach
                </select><br>

                <input type="submit" class='btn btn-outline-dark' value='Добавить' id='form-add-user__btn-submit' disabled>
            </form>
            <p id='form-add-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
        </article>

        <article>
            <h3 class='h3 fw-bold'>Список пользователей</h3>
            <table class='table w-75 mx-auto' id='table-users'>
                <tr> 
                    <th>Имя</th> 
                    <th>email</th> 
                    <th>Роль</th>
                    <th>Статус</th> 
                </tr>
                @foreach ($users as $user)
                <tr class='table-users__tr position-relative' data-id="{{$user->id}}"> 
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td class='p-0'>
                        <div class='form-switch p-0 h-100'>
                            @if ($user->status===1)
                            <input type="checkbox" name="status" class='table-offers__input-status form-check-input mx-auto' title='выключить' checked> 
                            @else
                            <input type="checkbox" name="status" class='table-offers__input-status form-check-input mx-auto' title='включить'>
                            @endif
                        </div>
                    </td>
                    <td class='pe-3'>{{$user->role->name}}</td>
                </tr>
                @endforeach
            </table>
        </article>

    </section>
</x-app-layout>
