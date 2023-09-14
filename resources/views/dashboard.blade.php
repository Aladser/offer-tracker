<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('app.profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center display-5">
                    @if ($user->role->name == 'рекламодатель')
                        <x-advertiser-content :user="$user"></x-advertiser-content>
                    @elseif ($user->role->name == 'веб-мастер')
                        <x-web-master-content :user="$user"></x-web-master-content>
                    @else
                        <x-admin-content :user="$user"></x-admin-content>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
