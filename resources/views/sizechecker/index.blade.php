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

      <div class="flex justify-between pb-4">
        <div class="w-1/2 border">
          <img src="{{ asset('images/topps.png') }}" class="w-full"alt="">
        </div>
        <div class="w-1/2 border">
          <img src="{{ asset('images/bottoms.png') }}"class="w-full" alt="">
        </div>
      </div>
      @php
        $fromMeasurementId = session('from_measurement_id') ?? $bodyMeasurement->id;//sessionがない場合に$bodyMeasurement->idを追記
      @endphp
      <p>※体格測定日は最新の日付：{{ $bodyMeasurement->measured_at }}を元に判定します</p>
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
                <td class="text-center px-2 py-2">{{ ($field == 'chest_circumference' || $field == 'hip') ? '低い' : '高い' }}</td>
                <td class="text-center px-2 py-2">
                  <div class="img w-8 mx-auto ">
                    <img src="{{ asset('images/question.png') }}" alt="ガイドアイコン画像"
                      class="hover:opacity-50 cursor-pointer">
                  </div>
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
<script>
const userTolerance = @json($userTolerance);
const suitableSize = @json($suitableSize);

const colorClasses = ["text-green-600", "text-yellow-600", "text-red-600"];

for (let field in userTolerance) {
  const inputEl = document.querySelector(`input[name="${field}"]`);

  inputEl.addEventListener("input", function () {
    const inputVal = parseFloat(this.value);
    const ideal = suitableSize[field];
    const resultEl = document.querySelector(`#${field}_result`);

    let result = "未判定";
    let resultClass = '';

    if (isNaN(inputVal)) {
        resultEl.classList.remove(...colorClasses);
        resultEl.innerText = result;
        return;
    }



    // ユーザーの許容値（min~max)を取得
    const toleranceJust = userTolerance[field]['just'];
    const toleranceSlight = userTolerance[field]['slight'];
    const toleranceShortOrLong = userTolerance[field]['long_or_short'];

    const diff = inputVal - ideal;

    if (diff >= toleranceJust.min_value && diff <= toleranceJust.max_value) {
      result = "✅ ちょうどいい";
      resultClass = "text-green-600";
    } else if (diff >= toleranceSlight.min_value && diff <= toleranceSlight.max_value) {
      result = "△ やや合わない";
      resultClass = "text-yellow-600";
    } else {
      result = "✕ 大きく合わない";
      resultClass = "text-red-600";
    }

    // すべての色クラスを削除してから新しいクラスを追加
    resultEl.classList.remove(...colorClasses);
    resultEl.classList.add(resultClass);
    resultEl.innerText = result;
  });
}

</script>
