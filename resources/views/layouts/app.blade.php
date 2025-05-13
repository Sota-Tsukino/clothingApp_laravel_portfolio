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
        @vite([
            'resources/css/app.css',
            'resources/js/app.js',//全ページ(blade)で読み込むのでこの中で下記JSをimportしない
            //↓ページ別にJS読み込み
            Request::routeIs('admin.clothing-item.create') ? 'resources/js/clothing-item.js' : '',
            Request::routeIs('admin.clothing-item.create') ? 'resources/js/init-size-checker.js' : '',
            Request::routeIs('admin.clothing-item.create') ? 'resources/js/init-item-category-select.js' : '',
            Request::routeIs('admin.clothing-item.edit') ? 'resources/js/clothing-item.js' : '',
            Request::routeIs('admin.clothing-item.edit') ? 'resources/js/init-size-checker.js' : '',
            Request::routeIs('admin.clothing-item.edit') ? 'resources/js/init-item-category-select.js' : '',
            Request::routeIs('admin.clothing-item.show') ? 'resources/js/init-size-checker-display.js' : '',
            Request::routeIs('admin.sizechecker.index') ? 'resources/js/init-size-checker.js' : '',
            Request::routeIs('admin.profile.edit') ? 'resources/js/init-pref-city-select.js' : '',
            //↓一般ユーザー用
            Request::routeIs('profile.edit') ? 'resources/js/init-pref-city-select.js' : '',
            Request::routeIs('clothing-item.create') ? 'resources/js/clothing-item.js' : '',
            Request::routeIs('clothing-item.create') ? 'resources/js/init-size-checker.js' : '',
            Request::routeIs('clothing-item.create') ? 'resources/js/init-item-category-select.js' : '',
            Request::routeIs('clothing-item.edit') ? 'resources/js/clothing-item.js' : '',
            Request::routeIs('clothing-item.edit') ? 'resources/js/init-size-checker.js' : '',
            Request::routeIs('clothing-item.edit') ? 'resources/js/init-item-category-select.js' : '',
            Request::routeIs('clothing-item.show') ? 'resources/js/init-size-checker-display.js' : '',
            Request::routeIs('sizechecker.index') ? 'resources/js/init-size-checker.js' : '',
            ])

            <!-- alpine.js -->
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
