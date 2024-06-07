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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <div class="bg-white shadow p-1 flex ">
            <header class="max-w-xl mx-auto py-2 basis-2/3 jsutify-start">
                {{-- {{$header}} --}}
                <x-trails title="{{$header ?? ''}}" />
            </header>
            <div class="max-w-xl my-1 mx-auto py-2 px-2 basis-1/3 justify-end ">
                @session('success')
                    <div
                        class="rounded p-1 bg-green-50 shadow-md ring-1 ring-green-300 ">
                        <h4 class="font-semibold text-md ">{{ Session::get('success') }}</h4>
                    </div>
                @endsession
                @session('error')
                    <div
                        class="rounded p-1 bg-red-50 shadow-md ring-1 ring-red-300 ">
                        <h4 class="font-semibold text-md ">{{ Session::get('error') }}</h4>
                    </div>
                @endsession
            </div>
        </div>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
