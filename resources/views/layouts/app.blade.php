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
        <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}">
        <!-- Scripts -->
        @php
            $viteFiles = array_filter([
            'resources/css/app.css',
            'resources/js/app.js',//全ページ(blade)で読み込むのでこの中で下記JSをimportしない

            //↓ページ別にJS読み込み
            //管理者用
            Request::routeIs('admin.clothing-item.create') ? 'resources/js/init-item-category-select.js' : null,
            Request::routeIs('admin.clothing-item.create') ? 'resources/js/clothing-item.js' : null,
            Request::routeIs('admin.clothing-item.create') ? 'resources/js/init-size-checker.js' : null,
            Request::routeIs('admin.clothing-item.edit') ? 'resources/js/init-item-category-select.js' : null,
            Request::routeIs('admin.clothing-item.edit') ? 'resources/js/clothing-item.js' : null,
            Request::routeIs('admin.clothing-item.edit') ? 'resources/js/init-size-checker.js' : null,
            Request::routeIs('admin.clothing-item.show') ? 'resources/js/init-size-checker-display.js' : null,
            Request::routeIs('admin.clothing-item.show') ? 'resources/js/init-item-image-display.js' : null,

            Request::routeIs('admin.sizechecker.index') ? 'resources/js/init-size-checker.js' : null,

            Request::routeIs('admin.profile.edit') ? 'resources/js/init-pref-city-select.js' : null,

            Request::routeIs('admin.measurement.edit') ? 'resources/js/calc-armpits-width.js' : null,
            Request::routeIs('admin.measurement.create') ? 'resources/js/calc-armpits-width.js' : null,
            Request::routeIs('admin.measurement.edit') ? 'resources/js/calc-kitake-length.js' : null,
            Request::routeIs('admin.measurement.create') ? 'resources/js/calc-kitake-length.js' : null,

            //一般ユーザー用
            Request::routeIs('clothing-item.create') ? 'resources/js/init-item-category-select.js' : null,
            Request::routeIs('clothing-item.create') ? 'resources/js/clothing-item.js' : null,
            Request::routeIs('clothing-item.create') ? 'resources/js/init-size-checker.js' : null,
            Request::routeIs('clothing-item.edit') ? 'resources/js/init-item-category-select.js' : null,
            Request::routeIs('clothing-item.edit') ? 'resources/js/clothing-item.js' : null,
            Request::routeIs('clothing-item.edit') ? 'resources/js/init-size-checker.js' : null,
            Request::routeIs('clothing-item.show') ? 'resources/js/init-size-checker-display.js' : null,
            Request::routeIs('clothing-item.show') ? 'resources/js/init-item-image-display.js' : null,

            Request::routeIs('sizechecker.index') ? 'resources/js/init-size-checker.js' : null,

            Request::routeIs('profile.edit') ? 'resources/js/init-pref-city-select.js' : null,

            Request::routeIs('measurement.edit') ? 'resources/js/calc-armpits-width.js' : null,
            Request::routeIs('measurement.create') ? 'resources/js/calc-armpits-width.js' : null,
            Request::routeIs('measurement.edit') ? 'resources/js/calc-kitake-length.js' : null,
            Request::routeIs('measurement.create') ? 'resources/js/calc-kitake-length.js' : null,
            ]);
        @endphp
        @vite($viteFiles)

        <!-- alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-8 sm:px-12 lg:px-20">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Page Footer -->
            <x-footer />
        </div>
    </body>
</html>
