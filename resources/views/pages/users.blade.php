<x-app-layout>
    @section('title')
        <x-title>: Пользователи</x-title>
    @endsection

    @section('js')
        <script src="/js/users.js" defer></script>
    @endsection

    @section('css')
        <link href="/css/users.css" rel="stylesheet" />
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Пользователи</h2>
    </x-slot>

    <section class="p-6 bg-white border-b border-gray-200 text-center fs-4 w-75 mx-auto mt-4">
        <a href="{{route('dashboard')}}" class='btn btn-outline-dark float-end mb-4'>Вернуться в профиль</a><br>
        <article class='mb-4'>
            <h3 class='fw-bold w-50 mx-auto'>Добавить нового Пользователя</h3>
            <form method='post' id='form-add-user' class='text-center mt-4 w-75 mx-auto'>
                @csrf
                <label for="form-add-user__name" class='fw-bolder w-50 text-start ps-2'>Название:</label><br>
                <input type="text" name="name" class='w-50 mb-2 border' id="form-add-user__name" required><br>

                <label for="form-add-user__email" class='fw-bolder w-50 text-start ps-2'>Почта:</label><br>
                <input type="text" name="name" class='w-50 mb-2 border' id="form-add-user__email" required><br>

                <label for="form-add-user__password" class='fw-bolder w-50 text-start ps-2'>Пароль:</label><br>
                <input type="password" name="name" class='w-50 mb-2 border' id="form-add-user__paasword" required><br>

                <label for="form-add-user__role" class='fw-bolder w-50 text-start ps-2'>Почта:</label><br>
                <select name="theme" class='w-50 mb-2 border' id="form-add-user__role">
                    @foreach ($roles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                    @endforeach
                </select><br>

                <input type="submit" class='btn btn-outline-dark col-2' value='Добавить'>
            </form>
            <p id='form-add-user-error' class='fw-bolder pt-4 fs-4 text-center text-danger'></p>
        </article>

        <article>
            <h3 class='h3 fw-bold'>Список пользователей</h3>
            <table class='table w-50 mx-auto' id='table-users'>

            </table>
        </article>
    </section>
</x-app-layout>
