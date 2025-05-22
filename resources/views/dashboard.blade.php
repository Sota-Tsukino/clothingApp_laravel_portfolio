<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden">

    <div
      class="container max-w-3xl px-4 sm:px-6 md:px-8 py-8 md:py-12 mx-auto bg-white rounded-lg my-6 md:my-16 shadow-lg">
      <div class="date">{{ now()->format('Y年m月d日') }}</div>
      @isset($weatherSummary)
        <div class="weather flex items-center">
          <div class="icon__img">
            <img src="https://openweathermap.org/img/wn/{{ $weatherSummary['morning_icon'] }}@2x.png" class="w-16">
          </div>
          <span>></span>
          <div class="icon__img">
            <img src="https://openweathermap.org/img/wn/{{ $weatherSummary['afternoon_icon'] }}@2x.png" class="w-16">
          </div>
        </div>
        <div class="text-red-600 font-semibold">最高気温：{{ $weatherSummary['temp_max'] }}℃</div>
        <div class=" text-blue-600 font-semibold">最低気温：{{ $weatherSummary['temp_min'] }}℃</div>
        <div class="text-sky-400 font-semibold">湿度：{{ $weatherSummary['humidity'] }}%</div>
      @else
        <p>天気情報が取得できません</p>
      @endisset
      <div>場所：{{ $user->prefecture->name }}/{{ $user->city->name }}</div>
    </div>
  </section>
</x-app-layout>
