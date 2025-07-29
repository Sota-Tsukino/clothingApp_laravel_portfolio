<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>FitCloset - お問い合わせ</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <!-- Scripts -->
  @vite(['resources/css/app.css'])
</head>

<body class="antialiased">
  <div
    class="h-[100vh] p-6 lg:p-8 relative bg-dots-darker dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    @if (Route::has('login'))
      <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
        @auth
          <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.home' : 'home') }}"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ホーム</a>
        @else
          <a href="{{ route('login') }}"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ログイン</a>

          @if (Route::has('register'))
            <a href="{{ route('register') }}"
              class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ユーザー登録</a>
          @endif
        @endauth
      </div>
    @endif


    <div class="w-[213px] mx-auto">
      <x-application-logo class="text-center block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </div>
    <div class="w-full">
      <iframe class="w-full h-[864px]"
        src="https://docs.google.com/forms/d/e/1FAIpQLSe3ECHmsJ7tsMPBYuBx0hQ3_WVtZbOGj96KE2769k3COefluA/viewform?embedded=true"
        frameborder="0" marginheight="0" marginwidth="0">読み込んでいます…</iframe>
    </div>

    <div class="mt-16 px-0 text-center">
      <p class="text-sm font-semibold text-gray-800 mb-2">
        <a href="{{ route('terms_of_use') }}" class="underline">利用規約</a>・<a href="{{ route('privacy_policy') }}"
          class="underline">プライバシーポリシー</a>
      </p>
      <small class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
        &copy; 2025 FitCloset All Rights reserved.
      </small>

    </div>
  </div>
</body>

</html>
