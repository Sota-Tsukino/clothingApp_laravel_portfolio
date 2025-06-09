<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格許容値の編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-4xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      {{-- onsubmit="return validateForm()" とは? returnの記載が必要？ --}}
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.tolerance.update' : 'tolerance.update') }}"
        method="post" onsubmit="return validateForm()">
        @csrf
        @method('put')
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
        <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">体格許容値とは？</h2>
        <!-- ガイド -->
        <div class="mb-6 bg-green-50 p-4 rounded-md">
          <p class="text-sm text-green-700">
            サイズチェッカー機能で、衣類サイズがユーザーの体格寸法に合っているかどうか判定する際に使用されます。例えば、首回り:36cmの場合で下限値:-0.5cm, 上限値:1.0cmの場合は
            35.5cm~37cmの範囲が「✅ちょどいい」判定となります。</p>
        </div>
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">部位</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">判定</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">下限値</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100"></th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">上限値</th>
            </tr>
          </thead>
          @foreach ($fittingTolerances as $index => $fittingTolerance)
            @php
              $key = $fittingTolerance->body_part . '-' . $fittingTolerance->tolerance_level;
            @endphp
            <tr>
              <td class="text-center px-2 py-2">{{ __('measurement.' . $fittingTolerance->body_part) }}</td>
              <td class="text-center px-2 py-2">
                @if ($fittingTolerance->tolerance_level === 'just')
                  <span class="text-green-600 font-semibold">✅ ちょうどいい</span>
                @elseif ($fittingTolerance->tolerance_level === 'slight')
                  <span class="text-yellow-500 font-semibold">△ やや合わない</span>
                @elseif ($fittingTolerance->tolerance_level === 'long_or_short')
                  <span class="text-red-600 font-semibold">✕ 合わない</span>
                @endif
              </td>
              <td class="text-center px-2 py-2">
                <input type="number" id="min_value_{{ $key }}"
                  name="tolerances[{{ $key }}][min_value]" value="{{ $fittingTolerance->min_value }}"
                  step="0.1" min="-15.0" max="15.0">
                <span class="ml-1">cm</span>
                <div id="error-message-min-{{ $key }}" style="color: red;"></div>
              </td>

              <td class="text-center px-2 py-2">～</td>
              <td class="text-center px-2 py-2">
                <input type="number" id="max_value_{{ $key }}"
                  name="tolerances[{{ $key }}][max_value]" value="{{ $fittingTolerance->max_value }}"
                  step="0.1" min="-15.0" max="15.0">
                <span class="ml-1">cm</span>
                <div id="error-message-max-{{ $key }}" style="color: red;"></div>
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
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.tolerance.index' : 'tolerance.index') }}'"
            class="text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">戻る</button>
        </div>
    </div>
    </form>
  </section>


</x-app-layout>

<script>
  const defaultValues = @json($defaultValues);

  function resetToDefault() {
    for (const key in defaultValues) {
      document.querySelector(`input[name="tolerances[${key}][min_value]"]`).value = defaultValues[key]['min_value'];
      document.querySelector(`input[name="tolerances[${key}][max_value]"]`).value = defaultValues[key]['max_value'];
    }
  }

  function validateForm() {
    let isValid = true;

    //以下のコードの解説をお願いします。
    //JS内にphpの記述ができる?
    @foreach ($fittingTolerances as $index => $fittingTolerance)
      @php
        $key = $fittingTolerance->body_part . '-' . $fittingTolerance->tolerance_level;
      @endphp
        (function() { //なぜ即時関数を使う？
          const minInput = document.getElementById('min_value_{{ $key }}');
          const maxInput = document.getElementById('max_value_{{ $key }}');
          const errorDivMin = document.getElementById('error-message-min-{{ $key }}');
          const errorDivMax = document.getElementById('error-message-max-{{ $key }}');

          const min = parseFloat(minInput.value); //文字列をfloat型に変換している？
          const max = parseFloat(maxInput.value);

          if (!isNaN(min) && !isNaN(max) && min > max) { //minとmaxの変数が空かどうか判定？
            errorDivMin.textContent = "下限値は上限値以下にしてください。";
            errorDivMax.textContent = "上限値は下限値以上にしてください。";
            isValid = false;
          } else {
            errorDivMin.textContent = "";
            errorDivMax.textContent = "";
          }
        })();
    @endforeach

    return isValid;
  }
</script>
