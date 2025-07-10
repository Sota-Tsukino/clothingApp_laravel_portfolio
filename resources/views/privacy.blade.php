<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>FitCloset - 利用規約</title>

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

    <div class="max-w-5xl mx-auto p-6 lg:p-8">
      <div class="flex justify-center">
        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
      </div>
      <div class="mt-16 p-6 md:p-10 bg-white rounded-lg shadow-2xl">
        <div class="w-full">
          <h2 class="text-3xl font-semibold text-gray-900 dark:text-white">プライバシーポリシー</h2>
          <br>
          <p class="text-gray-900 leading-relaxed">
            本プライバシーポリシーは、FitCloset（以下、「当サービス」といいます）が、ユーザーの個人情報をどのように収集・利用・保管・開示するかについて定めたものです。ご利用の際には、本ポリシーをご確認ください。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第1条（収集する情報）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            当サービスは、以下の情報をユーザーから取得することがあります。
          </p>
          <ul class="list-disc pl-6">
            <li class="text-gray-900 leading-relaxed">ニックネーム</li>
            <li class="text-gray-900 leading-relaxed">メールアドレス</li>
            <li class="text-gray-900 leading-relaxed">パスワード（暗号化して保存）</li>
            <li class="text-gray-900 leading-relaxed">都道府県・市区町村</li>
            <li class="text-gray-900 leading-relaxed">ログイン日時やIPアドレス等のアクセス情報</li>
          </ul>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第2条（利用目的）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            収集した個人情報は、以下の目的で利用します。
          </p>
          <ul class="list-disc pl-6">
            <li class="text-gray-900 leading-relaxed">サービス提供およびアカウント管理</li>
            <li class="text-gray-900 leading-relaxed">ユーザーからの問い合わせ対応</li>
            <li class="text-gray-900 leading-relaxed">不正利用防止・セキュリティ対策</li>
            <li class="text-gray-900 leading-relaxed">天気連動の衣類提案機能の最適化</li>
          </ul>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第3条（第三者提供）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            当サービスは、以下の場合を除き、個人情報を第三者に開示・提供することはありません。
          </p>
          <ul class="list-disc pl-6">
            <li class="text-gray-900 leading-relaxed">法令に基づく場合</li>
            <li class="text-gray-900 leading-relaxed">本人の同意がある場合</li>
            <li class="text-gray-900 leading-relaxed">人の生命、身体または財産の保護のために必要で、本人の同意を得ることが困難な場合</li>
          </ul>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第4条（安全管理措置）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            当サービスは、個人情報への不正アクセス、漏洩、滅失または毀損を防止するため、適切な安全管理措置を講じます。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第5条（個人情報の開示・訂正・削除）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            ユーザーは、自己の個人情報について、開示・訂正・利用停止・削除等を求めることができます。ご希望の場合は、当サービスのお問い合わせフォームよりご連絡ください。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第6条（Cookie・アクセス解析）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            当サービスは、ユーザー体験の向上やアクセス解析のためにCookieを使用することがあります。Cookieの使用はブラウザ設定により無効化可能です。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第7条（プライバシーポリシーの変更）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            本ポリシーは、必要に応じて変更されることがあります。変更後の内容は、本サービス上に掲示された時点から効力を持ちます。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第8条（お問い合わせ）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            本ポリシーに関するお問い合わせは、FitCloset運営者までご連絡ください。
          </p>

          <br><br>

        </div>
      </div>

      <div class="mt-16 px-0 text-center">
        <p class="text-sm font-semibold text-gray-800 mb-2">
          <a href="{{ route('terms_of_use') }}" class="underline">利用規約</a>・<a href="{{ route('privacy_policy') }}"
            class="underline">プライバシーポリシー</a>・<a href="{{ route('contact') }}" class="underline">お問い合わせ</a>
        </p>
        <small class="block font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
          &copy; 2025 FitCloset All Rights reserved.
        </small>

      </div>
    </div>
  </div>
</body>

</html>
