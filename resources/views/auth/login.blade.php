<x-guest-layout>
    @section('title')
        <x-title>Вход в систему</x-title>
    @endsection

    <x-auth-card>
        <x-slot name="logo">
            <a href="/" title='На главную страницу'>
                <x-application-logo class="w-20 h-20 fill-current text-gray-500 mx-auto" />
            </a>
        </x-slot>
        <p class='font-semibold cursor-default pb-3'>Вход в систему</p>

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-2 mt-2 text-red-600" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Почта:')" />

                <x-input id="email" class="mb-2 border p-2 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Пароль:')" />

                <x-input id="password" class="mb-2 border p-2 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900  m-2 ms-4" href="{{ route('register') }}">Регистрация</a>
                <x-button class="btn-reference inline-block rounded border border-gray-600 px-6 pb-[6px] pt-2 text-xs font-medium uppercase 
                        leading-normal text-gray-600 transition duration-150 ease-in-out text-center w-48">Войти</x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
