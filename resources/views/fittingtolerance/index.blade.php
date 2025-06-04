<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格許容値の詳細
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
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
        <tbody>
          @foreach ($fittingTolerances as $fittingTolerance)
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
              <td class="text-center px-2 py-2">{{ $fittingTolerance->min_value }}cm</td>
              <td class="text-center px-2 py-2">~</td>
              <td class="text-center px-2 py-2">{{ $fittingTolerance->max_value }}cm</td>
            </tr>
          @endforeach

        </tbody>
      </table>
      <div class="flex justify-between mx-auto my-5">
        <button
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.tolerance.edit' : 'tolerance.edit') }}'"
          class="text-white bg-amber-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">編集する</button>
        <button type="button"
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.sizechecker.index' : 'sizechecker.index') }}'"
          class="text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">サイズチェッカーへ</button>
      </div>
    </div>
  </section>


</x-app-layout>
