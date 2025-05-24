@php
  $sameDesc = $weatherSummary['morning_desc'] === $weatherSummary['afternoon_desc'];
  $msgTypes = ['info', 'warning', 'danger'];
  $alertClasses = [
      'info' => 'bg-blue-100 text-blue-800',
      'warning' => 'bg-yellow-100 text-yellow-800',
      'danger' => 'bg-red-100 text-red-800',
  ];
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden">
    <div
      class="container max-w-3xl px-4 sm:px-6 md:px-8 py-8 md:py-12 mx-auto bg-white rounded-lg my-6 md:my-16 shadow-lg">
      <div class="w-full mb-6">
        <span class="date inline-block">{{ now()->isoFormat('YYYY年MM月DD日(ddd)') }}</span>
        <span class="inline-block ml-3">{{ $user->prefecture->name }}/{{ $user->city->name }}</span>
        @isset($weatherSummary)
          <div class="weather flex items-center">
            <div class="weather__icon flex items-center">
              @if ($sameDesc)
                <x-weather-icon :icon="$weatherSummary['morning_icon']" :desc="$weatherSummary['morning_desc']" />
              @elseif (empty($weatherSummary['morning_icon']))
                <x-weather-icon :icon="$weatherSummary['afternoon_icon']" :desc="$weatherSummary['afternoon_desc']" />
              @elseif (empty($weatherSummary['afternoon_icon']))
                <x-weather-icon :icon="$weatherSummary['morning_icon']" :desc="$weatherSummary['morning_desc']" />
              @else
                <x-weather-icon :icon="$weatherSummary['morning_icon']" :desc="$weatherSummary['morning_desc']" />
                <span class="text-5xl">/</span>
                <x-weather-icon :icon="$weatherSummary['afternoon_icon']" :desc="$weatherSummary['afternoon_desc']" />
              @endif
            </div>
            <div class="weather__info ml-3">
              <div class="text-red-600 font-semibold">最高気温：{{ number_format($weatherSummary['temp_max'], 1) }}℃</div>
              <div class=" text-blue-600 font-semibold">最低気温：{{ number_format($weatherSummary['temp_min'], 1) }}℃</div>
              <div class="text-sky-400 font-semibold">湿度：{{ $weatherSummary['humidity'] }}%</div>
            </div>
          </div>
          @if (isset($weatherMessage))
            @foreach ($msgTypes as $type)
              @if (!empty($weatherMessage[$type]))
                <ul class="my-4 p-4 rounded {{ $alertClasses[$type] }}">
                  @foreach ($weatherMessage[$type] as $msg)
                    <li>{{ $msg }}</li>
                  @endforeach
                </ul>
              @endif
            @endforeach
          @endif
        @else
          <p>天気情報が取得できません</p>
        @endisset
        <div class="w-full mb-6">
          {{-- ここにオススメのコーデを表示させたい
        天気、気温に合わせてコーデ提案できるか？
        コーデデータ
            -シーンタグ
        衣類アイテムのデータ
            -素材
            ―季節
            - --}}
        </div>
      </div>
  </section>
</x-app-layout>
