<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      補正値編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-2 sm:px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">体格寸法測定ガイド</h2>
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
      <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">補正値とは？</h2>
      <!-- 注意書き -->
      <div class="mb-6 bg-green-50 p-4 rounded-md">
        <p class="text-sm text-green-700">
          体格寸法 + 補正値 = 適性サイズ（あなたに合う衣類サイズ）として算出します。首回り、胸囲、ウエストは窮屈にならないよう設定しましょう。</p>
      </div>
      @php
        $fromMeasurementId = session('from_measurement_id') ?? $bodyMeasurement->id; //sessionがない場合に$bodyMeasurement->idを追記
      @endphp
      <form
        action="{{ route(Auth::user()->role === 'admin' ? 'admin.correction.update' : 'correction.update', ['correction' => $bodyCorrection->id]) }}?from_measurement_id={{ $fromMeasurementId }}"
        method="post" class="space-y-6">
        @csrf
        @method('put')

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 w-1/4 whitespace-nowrap">部位</th>
                  <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 w-1/4 whitespace-nowrap">体格寸法</th>
                  <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 whitespace-nowrap"></th>
                  <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 w-1/2 whitespace-nowrap min-w-28">補正値
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($fields as $field)
                  <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                      {{ __("measurement.$field") }}</td>
                    <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                      {{ $bodyMeasurement->$field ?? '未登録' }}<span class="ml-1">cm</span>
                    </td>
                    <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">+</td>
                    <td class="px-4 py-4 whitespace-nowrap min-w-28">
                      <div class="relative">
                        <input type="number" name="{{ $field }}" step="0.1"
                          value="{{ $bodyCorrection->$field }}" min="0.0" max="9.0"
                          class="block w-full text-gray-900 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                          <span class="text-gray-500 text-sm">cm</span>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
        <div class="pt-6">
          <div class="flex flex-col sm:flex-row justify-around gap-3">
            <button
              class="block text-center px-4 py-2 bg-indigo-600 rounded-md font-semibold text-sm text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">更新する</button>
            <button type="button" onclick="resetToDefault()"
              class="block text-center px-4 py-2 bg-amber-600 rounded-md font-semibold text-sm text-white hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150">デフォルト値に戻す</button>
            <button type="button"
              onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $fromMeasurementId]) }}'"
              class="block text-center px-4 py-2 bg-teal-600 rounded-md font-semibold text-sm text-white hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150">戻る</button>
          </div>
        </div>
      </form>
    </div>
  </section>


</x-app-layout>
<script>
  const defaultValues = @json($defaultValues); //controllerから渡ってくる変数を変換

  function resetToDefault() {
    for (const key in defaultValues) {
      document.querySelector(`input[name="${key}"]`).value = defaultValues[key];
    }
  }
</script>
