<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Home') }}
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden">
    <div
      class="container px-4 sm:px-6 md:px-8 py-8 md:py-12 mx-auto max-w-4xl bg-white rounded-lg my-6 md:my-16 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <!-- 日付・場所情報 -->
      <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center text-gray-700 mb-4">
          <span class="text-lg font-medium mb-2 sm:mb-0">{{ now()->isoFormat('YYYY年MM月DD日(ddd)') }}</span>
          <span class="text-sm sm:text-base sm:ml-4 text-gray-600">{{ $user->prefecture->name }} /
            {{ $user->city->name }}</span>
        </div>
      </div>

      <!-- 天気情報 -->
      @if (!empty($weatherSummary))
        @php
          $sameDesc = $weatherSummary['morning_desc'] === $weatherSummary['afternoon_desc'];
        @endphp
        <div class="rounded-lg mb-8">
          <h2 class="text-lg font-medium text-gray-700 mb-4 border-b border-gray-200 pb-2">今日の天気</h2>

          <div class="openWeather block mx-auto sm:mx-0 w-[376px]">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 justify-between">
              <!-- 天気アイコン -->
              <div class="weather__icon flex items-center justify-center sm:justify-start">
                @if ($sameDesc)
                  <x-weather-icon :icon="$weatherSummary['morning_icon']" :desc="$weatherSummary['morning_desc']" />
                @elseif (empty($weatherSummary['morning_icon']))
                  <x-weather-icon :icon="$weatherSummary['afternoon_icon']" :desc="$weatherSummary['afternoon_desc']" />
                @elseif (empty($weatherSummary['afternoon_icon']))
                  <x-weather-icon :icon="$weatherSummary['morning_icon']" :desc="$weatherSummary['morning_desc']" />
                @else
                  <x-weather-icon :icon="$weatherSummary['morning_icon']" :desc="$weatherSummary['morning_desc']" />
                  <span class="text-3xl sm:text-4xl text-gray-400 mx-2">/</span>
                  <x-weather-icon :icon="$weatherSummary['afternoon_icon']" :desc="$weatherSummary['afternoon_desc']" />
                @endif
              </div>

              <!-- 温度・湿度情報 -->
              <div class="weather__info sm:ml-6 text-center sm:text-left">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                  <div class="text-red-600 font-semibold">
                    <span class="block text-xs text-gray-500">最高気温</span>
                    <span class="text-lg">{{ number_format($weatherSummary['temp_max'], 1) }}℃</span>
                  </div>
                  <div class="text-blue-600 font-semibold">
                    <span class="block text-xs text-gray-500">最低気温</span>
                    <span class="text-lg">{{ number_format($weatherSummary['temp_min'], 1) }}℃</span>
                  </div>
                  <div class="text-sky-500 font-semibold">
                    <span class="block text-xs text-gray-500">湿度</span>
                    <span class="text-lg">{{ $weatherSummary['humidity'] }}%</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-sm mt-4">
              <a href="https://openweathermap.org/" target="_blank" rel="noopener noreferrer">
                <div class="w-[100px] block mx-auto">
                  <img src="{{ asset('images/vendors/OpenWeather-Master-Logo RGB.jpg') }}" alt="OpenWeather Logo"
                    class="w-full">
                </div>
                <span class="text-center block font-semibold">Weather data provided by OpenWeather</span>
              </a>
            </div>
          </div>

          <!-- 天気メッセージ -->
          @if (isset($weatherMessage))
            <div class="mt-4 space-y-2">
              @foreach ($weatherMessage as $color => $msgs)
                @if (count($msgs))
                  <div class="p-3 rounded-lg bg-{{ $color }}-100 border border-{{ $color }}-200">
                    @foreach ($msgs as $msg)
                      <p class="text-{{ $color }}-800 text-sm">{{ $msg }}</p>
                    @endforeach
                  </div>
                @endif
              @endforeach
            </div>
          @endif
        </div>
      @else
        <div class="bg-gray-50 rounded-lg p-6 mb-8 text-center">
          <div class="text-gray-400 mb-2 w-16 mx-auto">
            <img src="{{ asset('images/icons/caution.svg') }}" alt="注意ロゴ" class="w-full">
          </div>
          <p class="text-gray-500">天気情報の取得に失敗しました。通信環境や時間帯を変えて再度お試しください。</p>
        </div>
      @endif

      <!-- オススメ衣類 -->
      <div class="w-full">
        <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-6">今日のオススメ衣類</h2>

        @if (!empty($weatherSummary))
          @if (!empty($topsItem) || !empty($bottomsItem) || !empty($outerItem))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
              @if (!empty($topsItem))
                <div class="recommend-item">
                  <h3 class="text-sm font-medium text-gray-600 mb-2 text-center">トップス</h3>
                  <x-item-card :item="$topsItem" :showStatus="false" class="w-full" />
                </div>
              @endif

              @if (!empty($bottomsItem))
                <div class="recommend-item">
                  <h3 class="text-sm font-medium text-gray-600 mb-2 text-center">ボトムス</h3>
                  <x-item-card :item="$bottomsItem" :showStatus="false"  class="w-full" />
                </div>
              @endif

              @if (!empty($outerItem))
                <div class="recommend-item">
                  <h3 class="text-sm font-medium text-gray-600 mb-2 text-center">アウター</h3>
                  <x-item-card :item="$outerItem" :showStatus="false" class="w-full" />
                </div>
              @endif
            </div>
          @else
            <div class="bg-gray-50 rounded-lg p-8 text-center">
              <div class="text-gray-400 mb-2 w-16 mx-auto">
                <img src="{{ asset('images/icons/caution.svg') }}" alt="注意ロゴ" class="w-full">
              </div>
              <p class="text-gray-600 font-medium">衣類アイテムが登録されていません</p>
              <p class="text-gray-500 text-sm mt-1">アイテムを登録してオススメ機能をお試しください</p>
            </div>
          @endif
        @else
          <div class="bg-gray-50 rounded-lg p-8 text-center">
            <div class="text-gray-400 mb-2 w-16 mx-auto">
              <img src="{{ asset('images/icons/caution.svg') }}" alt="注意ロゴ" class="w-full">
            </div>
            <p class="text-gray-500 text-sm mt-1">天気情報が取得できない為、この機能は使用できません。</p>
          </div>
        @endif
      </div>
    </div>
  </section>

</x-app-layout>
