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
      <div class="w-[213px] mx-auto">
        <a href="/">
          <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
      </div>
      <div class="mt-16 p-6 md:p-10 mb-16 bg-white rounded-lg shadow-2xl">
        <div class="w-full">
          <h2 class="text-3xl font-semibold text-gray-900 dark:text-white">利用規約</h2>
          <br>
          <p class="text-gray-900 leading-relaxed">
            この利用規約（以下、「本規約」といいます。）は、FitCloset（以下、「本サービス」といいます。）が提供するすべてのサービスに関する利用条件を定めるものです。
            本サービスをご利用いただくことで、利用者は以下の規約に同意したものとみなされます。</p>
          <br><br>
          <h3 class="text-lg font-semibold text-gray-900">第1条（適用）</h3><br>
          <p class="text-gray-900 leading-relaxed">本規約は、利用者と本サービス提供者との間のすべての関係に適用されます。</p>
          <br>
          <br>


          <h3 class="text-lg font-semibold text-gray-900">第2条（禁止事項）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            利用者は、以下の行為をしてはなりません。
          </p>
          <ul class="list-disc pl-6">
            <li class="text-gray-900 leading-relaxed">法令または公序良俗に反する行為</li>
            <li class="text-gray-900 leading-relaxed">他のユーザーまたは第三者への誹謗中傷・迷惑行為</li>
            <li class="text-gray-900 leading-relaxed">本サービスの運営を妨げる行為</li>
            <li class="text-gray-900 leading-relaxed">不正アクセス・ハッキング等のセキュリティ侵害行為</li>
          </ul>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第3条（アカウント情報の管理）</h3>
          <br>
          <p class="text-gray-900 leading-relaxed">
            利用者は、登録したメールアドレスおよびパスワードの管理に責任を負うものとし、これを第三者に譲渡または貸与してはなりません。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第4条（個人情報の取り扱い）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            本サービスの利用によって取得する個人情報については，当社「プライバシーポリシー」に従い適切に取り扱うものとします。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第5条（免責事項）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            本サービスは、可能な限り正確な情報提供に努めますが、提供される情報の完全性・正確性・有用性について保証するものではありません。<br>
            また、本サービスの利用に関連して発生したいかなる損害についても、当方は一切責任を負いません。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第6条（サービスの変更・終了）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            本サービスは、予告なく機能の変更・中断・終了を行うことがあります。これによって生じた損害について、当方は一切責任を負いません。
          </p>

          <br><br>
          <h3 class="text-lg font-semibold text-gray-900">第7条（利用制限及び登録抹消）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            本サービスは、ユーザーが以下のいずれかに該当する場合には，事前の通知なく，ユーザーに対して，本サービスの全部もしくは一部の利用を制限し，またはユーザーとしての登録を抹消することができるものとします
          </p>
          <br>
          <ul class="list-disc pl-6">
            <li class="text-gray-900 leading-relaxed">本規約のいずれかの条項に違反した場合</li>
            <li class="text-gray-900 leading-relaxed">本サービスについて，最終の利用から一定期間利用がない場合</li>
            <li class="text-gray-900 leading-relaxed">その他，当社が本サービスの利用を適当でないと判断した場合</li>
          </ul>
          <br>
          <p class="text-gray-900 leading-relaxed">
            当サービスは，本条に基づき当社が行った行為によりユーザーに生じた損害について，一切の責任を負いません。
          </p>


          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第8条（規約の変更）</h3>
          <br>
          <p class="text-gray-900 leading-relaxed">
            本規約は、必要に応じて変更されることがあります。変更後の利用規約は、本サービス上に掲載された時点で効力を生じます。
          </p>

          <br><br>

          <h3 class="text-lg font-semibold text-gray-900">第9条（準拠法・管轄）</h3><br>
          <p class="text-gray-900 leading-relaxed">
            本規約の解釈にあたっては、日本法を準拠法とします。<br>
            本サービスに関して紛争が生じた場合には、提供者の所在地を管轄する裁判所を第一審の専属的合意管轄とします。
          </p>

          <br><br>
        </div>
      </div>

    </div>
</div>
<!-- Page Footer -->
<x-footer />
</body>

</html>
