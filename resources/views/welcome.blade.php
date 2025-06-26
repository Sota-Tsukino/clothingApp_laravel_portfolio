<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <!-- Scripts -->
  @vite(['resources/css/app.css'])
</head>

<body class="antialiased">
  <div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    @if (Route::has('login'))
      <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
        @auth
          <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'dashboard') }}"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ダッシュボード</a>
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

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
      <div class="flex justify-center">
        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
      </div>

      <div class="mt-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
          <div
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div class="w-full">
              <div class="p-2 h-16 w-16 bg-gray-100 dark:bg-gray-800/20 flex justify-center rounded-full">
                <img src="{{ asset('images/icons/BodyMeasurement.svg') }}" alt="体格情報アイコン" class="w-9/10">
              </div>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">サイズチェッカー</h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                体格情報を登録すれば、あなたに合う衣類サイズかどうかを判定するサイズチェッカー機能を使用できます。
              </p>
              <div class="img mt-4 bg-no-repeat bg-center w-full h-[200px]"
                style="background-image: url('{{ asset('images/intro_sizechecker.png') }}'); background-size: 100%;">
              </div>
            </div>
          </div>

          <div
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div class="w-full">
              <div class="p-2 h-16 w-16 bg-gray-100 dark:bg-gray-800/20 flex justify-center rounded-full">
                <img src="{{ asset('images/icons/ClothingItems.svg') }}" alt="体格情報アイコン" class="w-9/10">
              </div>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">衣類アイテムの登録</h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                色・ブランド・購入場所・衣類サイズなどの衣類情報を保存できます。
              </p>
              <div class="img mt-4 bg-no-repeat bg-center w-full h-[200px]"
                style="background-image: url('{{ asset('images/intro_clothingItem.png') }}'); background-size: 100%;">
              </div>
            </div>
          </div>

          <div
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div class="w-full">
              <div class="p-2 h-16 w-16 bg-gray-100 dark:bg-gray-800/20 flex justify-center rounded-full">
                <img src="{{ asset('images/icons/Weather.svg') }}" alt="天気情報アイコン" class="w-9/10 object-contain">
              </div>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">天気情報の表示・今日のオススメ衣類</h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                お住まいの地域を登録してお天気情報を表示し、その日の天気に合った衣類を提案します。
              </p>
              <div class="img mt-4 bg-no-repeat bg-center w-full h-[200px]"
                style="background-image: url('{{ asset('images/intro_weatherInfo.png') }}'); background-size: 100%;">
              </div>
            </div>
          </div>

          <div
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <div class="w-full">
              <div class="p-2 h-16 w-16 bg-gray-100 dark:bg-gray-800/20 flex justify-center rounded-full">
                <img src="{{ asset('images/icons/Coordinate.svg') }}" alt="体格情報アイコン" class="w-9/10">
              </div>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">コーデ登録</h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                お好きな衣類の組み合わせを登録できます。
              </p>
              <div class="img mt-4 bg-no-repeat bg-top w-full h-[200px]"
                style="background-image: url('{{ asset('images/intro_coordinate.png') }}'); background-size: 64%;">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
        <div class="text-center text-sm sm:text-left">
          &nbsp;
        </div>

        <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
          Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </div>
      </div>
    </div>
  </div>
</body>

</html>
