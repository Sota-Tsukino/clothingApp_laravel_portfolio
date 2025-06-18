<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格情報詳細
    </h2>
  </x-slot>

  <div class="py-6 sm:py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl rounded-lg">
        <div class="p-4 sm:p-6 lg:p-8">
          <x-flash-message status="session('status')" />

          <!-- タイトルと計測日 -->
          <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-2 sm:mb-0">体格寸法測定ガイド</h2>
          </div>

          <!-- 画像ガイド -->
          <div class="mb-6">
            <div class="top-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                <h3 id="upper-img-title" class="text-sm font-medium text-gray-700">体格測定ガイド</h3>
              </div>
              <div class="p-2">
                <img id="tops-img" src="{{ asset('images/body.png') }}" class="w-full h-auto" alt="体格測定ガイド">
              </div>
            </div>
          </div>
          <p class="text-md text-gray-600 font-medium mb-4">
            計測日：{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}
          </p>
          <!-- 測定データテーブル -->
          <div class="mb-8">
            <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col"
                      class="px-3 py-3 text-center text-sm font-medium text-gray-500 whitespace-nowrap">
                      部位
                    </th>
                    <th scope="col"
                      class="px-3 py-3 text-center text-sm font-medium text-gray-500 whitespace-nowrap">
                      体格寸法
                    </th>
                    <th scope="col"
                      class="px-2 py-3 text-center text-sm font-medium text-gray-500 whitespace-nowrap">
                    </th>
                    <th scope="col"
                      class="px-3 py-3 text-center text-sm font-medium text-gray-500 whitespace-nowrap">
                      補正値
                    </th>
                    <th scope="col"
                      class="px-2 py-3 text-center text-sm font-medium text-gray-500 whitespace-nowrap">
                    </th>
                    <th scope="col"
                      class="px-3 py-3 text-center text-sm font-medium text-gray-500 whitespace-nowrap">
                      あなたに合う衣類サイズ
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach ($fields as $field)
                    @if ($field === 'height')
                      <tr class="hover:bg-gray-50">
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                          <div class="text-sm font-medium text-gray-900">{{ __("measurement.$field") }}</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-gray-900">{{ $bodyMeasurement->$field ?? '未登録' }}cm</div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-gray-400">-</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-gray-400">-</div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-gray-400">-</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-gray-400">-</div>
                        </td>
                      </tr>
                    @else
                      <tr class="hover:bg-gray-50">
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                          <div class="text-sm font-medium text-gray-900">{{ __("measurement.$field") }}</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-gray-900">{{ $bodyMeasurement->$field ?? '未登録' }}cm</div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-green-600 font-semibold">+</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-blue-600 font-medium">{{ $bodyCorrection->$field }}cm</div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center">
                          <div class="text-sm text-gray-600 font-semibold">=</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                          <div
                            class="text-sm font-semibold {{ $suitableSize[$field] ? 'text-green-600 bg-green-50' : 'text-gray-600 bg-gray-50' }} px-2 py-1 rounded-full">
                            {{ $suitableSize[$field] ? number_format($suitableSize[$field], 1) : '未登録' }}<span
                              class="ml-1">cm</span>
                          </div>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- アクションボタン -->
          <div class="pt-6">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-2 justify-around">
              <button
                onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index') }}'"
                class="inline-block px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150 text-center">
                計測日一覧へ
              </button>

              <button
                onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.edit' : 'measurement.edit', ['measurement' => $bodyMeasurement->id]) }}'"
                class="inline-block px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                体格寸法の編集
              </button>

              <button
                onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.correction.edit' : 'correction.edit', ['correction' => $bodyCorrection->id]) }}?from_measurement_id={{ $bodyMeasurement->id }}'"
                class="inline-block px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                補正値の編集
              </button>

              <form
                action="{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.destroy' : 'measurement.destroy', ['measurement' => $bodyMeasurement->id]) }}"
                method="post" class="inline" onsubmit="return confirm('本当に削除しますか？')">
                @csrf
                @method('delete')
                <button type="submit"
                  class="inline-block text-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 w-full">
                  体格寸法の削除
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
