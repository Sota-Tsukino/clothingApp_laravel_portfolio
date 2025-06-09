<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      補正値編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">体格寸法測定ガイド</h2>
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
        method="post">
        @csrf
        @method('put')
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">部位</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">体格寸法</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100"></th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">補正値</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($fields as $field)
              <tr>
                <td class="text-center px-2 py-2">{{ __("measurement.$field") }}</td>
                <td class="text-center px-2 py-2">
                  {{ $bodyMeasurement->$field ?? '未登録' }}<span class="ml-1">cm</span>
                </td>
                <td class="text-center px-2 py-2">+</td>
                <td class="text-center px-2 py-2">
                  <input type="number" name="{{ $field }}" step="0.1" value="{{ $bodyCorrection->$field }}"
                    min="0.0" max="9.0">
                  <span class="ml-1">cm</span>
                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
        <div class="flex justify-between mx-auto my-5">
          <button
            class="text-white bg-amber-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">更新する</button>
          <button type="button" onclick="resetToDefault()"
            class="text-white bg-cyan-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">デフォルト値に戻す</button>
          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $fromMeasurementId]) }}'"
            class="text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">戻る</button>
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
