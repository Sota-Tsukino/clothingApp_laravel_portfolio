<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      サイズチェッカー
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-2 sm:px-6">
    <div class="max-w-4xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
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
      <div class="mb-6 bg-green-50 p-4 rounded-md">
        <p class="text-sm text-green-700">
          ※体格寸法は最新の計測日：{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}を参照しています。</p>
      </div>
      <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-4 text-left text-sm font-medium text-gray-500 w-1/7 whitespace-nowrap">部位</th>
                <th class="px-4 py-4 text-left text-sm font-medium text-gray-500 w-1/7 whitespace-nowrap">体格寸法</th>
                <th class="px-4 py-4 text-left text-sm font-medium text-gray-500 w-1/7 whitespace-nowrap">あなたに合う衣類サイズ
                </th>
                <th class="px-4 py-4 text-left text-sm font-medium text-gray-500 w-1/7 whitespace-nowrap min-w-[140px]">
                  衣類サイズ</th>
                <th class="px-4 py-4 text-left text-sm font-medium text-gray-500 w-1/7 whitespace-nowrap min-w-[130px]">
                  判定</th>
                <th class="px-4 py-4 text-left text-sm font-medium text-gray-500 w-1/7 whitespace-nowrap">優先度</th>
                <th class="px-4 py-4 text-left text-sm font-medium text-gray-500 w-1/7 whitespace-nowrap">ガイド</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($fields as $field)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                  <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                    {{ __("measurement.$field") }}</td>
                  <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                    {{ $bodyMeasurement[$field] ? number_format($bodyMeasurement[$field], 1) : '未登録' }}<span class="ml-1">cm</span>
                  </td>
                  <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                    <div class="text-sm font-semibold text-center {{ $suitableSize[$field] ? 'text-green-600 bg-green-50' : 'text-gray-600 bg-gray-50'}}  px-2 py-1 rounded-full">
                      {{ $suitableSize[$field] ? number_format($suitableSize[$field], 1) : '未登録' }}<span class="ml-1">cm</span>
                    </div>
                  </td>
                  <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                    <div class="relative">
                      <input type="number" name="{{ $field }}" id="{{ $field }}" step="0.1"
                        value="" min="0.0" max="999.0" placeholder="40.0"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10">
                      <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm">cm</span>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                    <span id="{{ $field }}_result" class="inline-flex px-2 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">未評価</span>
                  </td>
                  <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                    <x-sizechecker-priority-tag :priorityMap="$priorityMap" :field="$field" />
                  </td>
                  <td x-data="{ show: false }" class="relative px-4 py-4 text-sm text-gray-900">
                    <x-popup-guide :field="$field" :guides="$guides" />
                  </td>
                </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>

      <div class="pt-6">
        <div class="flex flex-col sm:flex-row gap-3 justify-around">
          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.tolerance.index' : 'tolerance.index') }}'"
            class="inline-block px-4 py-2 bg-teal-600 rounded-md font-semibold text-sm text-white hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150">体格許容値を表示</button>
        </div>
      </div>
    </div>
  </section>

</x-app-layout>

{{-- JSファイルにPHPの変数を渡す --}}
<div id="size-checker" data-tolerance='@json($userTolerance)' data-suitable='@json($suitableSize)'></div>
