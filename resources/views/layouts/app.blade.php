<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <div class="bg-white shadow flex flex-row">
                    <header class="">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                    @session('success')
                        <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <h4 class="text-green-400">{{Session::get('success')}}</h4>
                        </div>
                    @endsession
                    @session('error')
                        <div class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <h4 class="text-red-400">{{Session::get('error')}}</h4>
                        </div>
                    @endsession
                </div>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
