<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格許容値の編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.tolerance.update' : 'tolerance.update') }}"
        method="post">
        @csrf
        @method('put')
        <div class="flex justify-between pb-4">
          <div class="w-1/2 border">
            <img src="{{ asset('images/topps.png') }}" class="w-full" alt="">
          </div>
          <div class="w-1/2 border">
            <img src="{{ asset('images/bottoms.png') }}" class="w-full" alt="">
          </div>
        </div>
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">部位</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">評価</th>
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
                {{-- 表示部分はそのままでOK --}}
                @if ($fittingTolerance->tolerance_level === 'just')
                  <span class="text-green-600 font-semibold">✅ ちょうどいい</span>
                @elseif ($fittingTolerance->tolerance_level === 'slight')
                  <span class="text-yellow-500 font-semibold">△ やや合わない</span>
                @elseif ($fittingTolerance->tolerance_level === 'long_or_short')
                  <span class="text-red-600 font-semibold">✕ 大きく合わない</span>
                @endif
              </td>
              <td class="text-center px-2 py-2">
                <input type="number" name="tolerances[{{ $key }}][min_value]"
                  value="{{ $fittingTolerance->min_value }}" step="0.1" min="-10.0" max="10.0">
                <span class="ml-1">cm</span>
              </td>
              <td class="text-center px-2 py-2">~</td>
              <td class="text-center px-2 py-2">
                <input type="number" name="tolerances[{{ $key }}][max_value]"
                  value="{{ $fittingTolerance->max_value }}" step="0.1" min="-10.0" max="10.0">
                <span class="ml-1">cm</span>
              </td>
            </tr>
          @endforeach


          </tbody>
        </table>
        <div class="flex justify-between mx-auto my-5">
          <button
            class="text-white bg-amber-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">更新する</button>
          {{-- <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $fromMeasurementId]) }}'"
            class="text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">戻る</button> --}}
        </div>
    </div>
    </form>
  </section>


</x-app-layout>
