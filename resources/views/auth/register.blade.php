<x-guest-layout>
    @section('title')
        <x-title>Регистрация пользователя</x-title>
    @endsection

    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <p class='fw-bold cursor-default pb-3'>Регистрация</p>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('register.name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('register.email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Роль -->
            <div class="mt-4">
                <x-label for="role" :value="__('register.role')" />
                <select class='block mt-1 w-full' style="border-color: rgb(219,219,219)" name="role" id="registerRole">
                    @foreach ($roles as $role)
                    <option>{{$role['name']}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('register.password')" />
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('register.confirm')" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('register.already_registered') }}
                </a>

                <x-button class="ml-4">
                    {{ __('register.register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>