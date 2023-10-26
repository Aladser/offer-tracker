<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <noscript><meta http-equiv="refresh" content="0; url=/noscript"></noscript>
        @yield('title')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name='username' content="{{ Auth::user()->name }}">
        @yield('meta')
        
        <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="/css/welcome.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('css')

        <!-- Scripts -->
        <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        @yield('js')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{{ $header }}</div>
            </header>

            <!-- Page Content -->
            <main>{{ $slot }}</main>
        </div>
    </body>
</html>
