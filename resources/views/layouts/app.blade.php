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
    <body class="font-sans antialiased transition-colors duration-300">
        <div class="min-h-screen bg-gradient-to-b from-blue-100 via-white to-blue-100 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-200">
            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-blue-50 bg-opacity-70 dark:bg-gray-700 dark:bg-opacity-70 shadow-md py-4">
                    <div class="max-w-7xl mx-auto px-6 lg:px-8 text-gray-800 dark:text-gray-100 text-lg font-medium">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-10 px-6 lg:px-8 bg-white bg-opacity-80 dark:bg-gray-800 dark:bg-opacity-90 shadow-lg rounded-lg mx-auto max-w-5xl mt-8">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
