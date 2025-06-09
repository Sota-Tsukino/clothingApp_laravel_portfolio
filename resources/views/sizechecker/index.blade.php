<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      サイズチェッカー
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-3xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">衣類サイズ測定ガイド</h2>
      <!-- 画像ガイド -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="top-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
          <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
            <h3 id="upper-img-title" class="text-sm font-medium text-gray-700">トップス測定ガイド</h3>
          </div>
          <div class="p-2">
            <img id="tops-img" src="{{ asset('images/measurements/shirt-common.svg') }}" class="w-full h-auto"
              alt="トップス測定ガイド">
          </div>
        </div>
        <div class="bottom-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
          <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
            <h3 class="text-sm font-medium text-gray-700">ボトムス測定ガイド</h3>
          </div>
          <div class="p-2">
            <img id="bottoms-img" src="{{ asset('images/measurements/slacks-common.svg') }}" class="w-full h-auto"
              alt="ボトムス測定ガイド">
          </div>
        </div>
      </div>
      @php
        $fromMeasurementId = session('from_measurement_id') ?? $bodyMeasurement->id; //sessionがない場合に$bodyMeasurement->idを追記
      @endphp
      <!-- 注意書き -->
      <div class="mb-6 bg-yellow-50 p-4 rounded-md">
        <p class="text-sm text-yellow-700">
          ※サイズ判定は最新の体格計測日：{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}を元に判定します</p>
      </div>
      <table class="w-full whitespace-no-wrap">
        <thead>
          <tr>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">部位</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">体格寸法</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">あなたに合う衣類サイズ</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">衣類サイズ</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">判定</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">優先度</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">ガイド</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($fields as $field)
            <tr>
              <td class="text-center px-2 py-2">{{ __("measurement.$field") }}</td>
              <td class="text-center px-2 py-2">
                {{ number_format($bodyMeasurement[$field], 1) ?? '未登録' }}<span class="ml-1">cm</span>
              </td>
              <td class="text-center px-2 py-2">
                {{ number_format($suitableSize[$field], 1) ?? '未登録' }}<span class="ml-1">cm</span>
              </td>
              <td class="text-center px-2 py-2">
                <input type="number" name="{{ $field }}" id="{{ $field }}" step="0.1" value=""
                  min="0.0" max="999.0" placeholder="40.0" class="text-black">
                <span class="ml-1">cm</span>
              </td>
              <td>
                <span id="{{ $field }}_result" class="font-semibold block">未評価</span>
              </td>
              <td class="px-1 py-3 whitespace-nowrap text-sm text-gray-700">
                <x-sizechecker-priority-tag :priorityMap="$priorityMap" :field="$field" />
              </td>
              <td x-data="{ show: false }" class="relative text-center">
                <x-popup-guide :field="$field" :guides="$guides" />
              </td>
            </tr>
          @endforeach

        </tbody>
      </table>
      <div class="flex justify-between mx-auto my-5">
        <button type="button"
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.tolerance.index' : 'tolerance.index') }}'"
          class="text-white bg-violet-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">体格許容値を表示</button>
      </div>
    </div>
  </section>

</x-app-layout>

{{-- JSファイルにPHPの変数を渡す --}}
<div id="size-checker" data-tolerance='@json($userTolerance)' data-suitable='@json($suitableSize)'></div>
