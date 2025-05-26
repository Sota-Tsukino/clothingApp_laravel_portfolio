@php
  $sameDesc = $weatherSummary['morning_desc'] === $weatherSummary['afternoon_desc'];
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden">
    <div class="container p-6 md:p-8 mx-auto max-w-3xl bg-white rounded-lg my-24 shadow-lg">
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
            @foreach ($weatherMessage as $color => $msgs)
              @if (count($msgs))
                <div class="p-4 mb-4 rounded-lg bg-{{ $color }}-100 text-{{ $color }}-800">
                  @foreach ($msgs as $msg)
                    <p>{{ $msg }}</p>
                  @endforeach
                </div>
              @endif
            @endforeach
          @endif
        @else
          <p>天気情報が取得できません</p>
        @endisset
        <div class="w-full mb-6">
          <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2">今日のオススメ衣類</h2>
          @if (!empty($topsItem) || !empty($bottomsItem) || !empty($outerItem))
            <div class="sm:flex sm:flex-wrap sm:justify-between">
              @if (!empty($topsItem))
                <x-item-card :item="$topsItem" class="sm:w-1/3" />
              @endif
              @if (!empty($bottomsItem))
                <x-item-card :item="$bottomsItem" class="sm:w-1/3" />
              @endif
              @if (!empty($outerItem))
                <x-item-card :item="$outerItem" class="sm:w-1/3" />
              @endif
            </div>
          @else
            <p class="mt-4 text-md font-medium text-gray-700 border-gray-200 pb-2">衣類アイテムが登録されていません。</p>
          @endif

        </div>
      </div>
  </section>
</x-app-layout>
