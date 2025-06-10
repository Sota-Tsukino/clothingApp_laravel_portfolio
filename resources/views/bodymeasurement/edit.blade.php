<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格情報編集
    </h2>
  </x-slot>

  <div class="py-6 sm:py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl rounded-lg">
        <div class="p-8 sm:p-12 lg:p-16">
          <!-- Validation Errors -->
          <x-auth-validation-errors class="mb-4" :errors="$errors" />
          <x-flash-message status="session('status')" />

          <!-- タイトルと計測日 -->
          <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-2 sm:mb-0">体格寸法測定ガイド</h2>
          </div>

          <!-- 画像ガイド -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="top-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                <h3 id="upper-img-title" class="text-sm font-medium text-gray-700">体格測定ガイド</h3>
              </div>
              <div class="p-2">
                <img id="tops-img" src="{{ asset('images/body.png') }}" class="w-full h-auto" alt="体格測定ガイド">
              </div>
            </div>
            <div class="bottom-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                <h3 class="text-sm font-medium text-gray-700">足サイズ測定ガイド</h3>
              </div>
              <div class="p-2">
                <img id="bottoms-img" src="{{ asset('images/foot.png') }}" class="w-full h-auto" alt="足サイズ測定ガイド">
              </div>
            </div>
          </div>

          <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">体格情報を登録すると…</h2>
          <div class="mb-6 bg-green-50 p-4 rounded-md">
            <p class="text-sm text-green-700">
              ユーザーに合った衣類サイズを算出し、サイズチェッカー機能が使用できるようになります。</p>
          </div>
          <p class="text-gray-600 font-medium">
            計測日：{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}
          </p>

          <!-- フォーム -->
          <form
            action="{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.update' : 'measurement.update', ['measurement' => $bodyMeasurement->id]) }}"
            method="post" class="space-y-6">
            @csrf
            @method('put')

            <!-- 測定データテーブル -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col"
                        class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider w-1/4">
                        部位
                      </th>
                      <th scope="col"
                        class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider w-1/2">
                        体格寸法
                      </th>
                      <th scope="col"
                        class="px-4 py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider w-1/4">
                        ガイド
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($fields as $field)
                      <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                          {{ __("measurement.$field") }}
                        </td>
                        <td class="px-4 py-4">
                          <div class="flex items-center space-x-2">
                            @if ($field === 'armpit_to_armpit_width')
                              <div class="flex-1">
                                <span id='display_{{ $field }}'
                                  class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 text-sm rounded-md">
                                  {{ $bodyMeasurement->$field ?? '胸囲 / 2' }}
                                </span>
                                <input id='{{ $field }}' type="hidden" name="{{ $field }}"
                                  value="{{ $bodyMeasurement->$field ?? '' }}">
                              </div>
                            @elseif($field === 'kitake_length')
                              <div class="flex-1">
                                <span id='display_{{ $field }}'
                                  class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 text-sm rounded-md">
                                  身長 × 0.42
                                </span>
                                <input id='{{ $field }}' type="hidden" name="{{ $field }}"
                                  value="">
                              </div>
                            @else
                              <div class="flex-1">
                                <div class="relative">
                                  <input id="{{ $field }}" type="number" name="{{ $field }}"
                                    step="0.1" value="{{ $bodyMeasurement->$field }}" min="0.0" max="999.9"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10">
                                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">cm</span>
                                  </div>
                                </div>
                              </div>
                            @endif
                            @if (in_array($field, ['armpit_to_armpit_width', 'kitake_length']))
                              <span class="text-gray-500 text-sm">cm</span>
                            @endif
                          </div>
                        </td>
                        <td x-data="{ show: false }" class="px-4 py-4 text-center relative">
                          <x-popup-guide :field="$field" :guides="$guides" />
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <!-- アクションボタン -->
            <div class="pt-6">
              <div class="flex flex-col sm:flex-row gap-3 justify-around">
                <button type="submit"
                  class="inline-block px-4 py-2 bg-indigo-600 rounded-md font-semibold text-sm text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                  更新する
                </button>

                <button type="button"
                  onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $bodyMeasurement->id]) }}'"
                  class="inline-block px-4 py-2 bg-teal-600 rounded-md font-semibold text-sm text-white hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150">
                  戻る
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
