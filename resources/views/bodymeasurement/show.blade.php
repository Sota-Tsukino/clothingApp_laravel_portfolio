<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格情報詳細
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
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
      <h3 class="font-semibold text-sm text-gray-800 leading-tight">
        計測日：{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}</h3>
      <table class="w-full whitespace-no-wrap">
        <thead>
          <tr>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">部位</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">体格寸法</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100"></th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">補正値</th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100"></th>
            <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">あなたに合う衣類サイズ</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($fields as $field)
            @if ($field === 'height')
              <tr>
                <td class="text-center px-4 py-3">{{ __("measurement.$field") }}</td>
                <td class="text-center px-4 py-3">{{ $bodyMeasurement->$field ?? '未登録' }}cm</td>
                <td class="text-center px-4 py-3"></td>
                <td class="text-center px-4 py-3">-</td>
                <td class="text-center px-4 py-3"></td>
                <td class="text-center px-4 py-3">-</td>
              </tr>
            @else
              <tr>
                <td class="text-center px-4 py-3">{{ __("measurement.$field") }}</td>
                <td class="text-center px-4 py-3">{{ $bodyMeasurement->$field ?? '未登録' }}cm</td>
                <td class="text-center px-4 py-3">+</td>
                <td class="text-center px-4 py-3">{{ $bodyCorrection->$field }}cm</td>
                <td class="text-center px-4 py-3">=</td>
                <td class="text-center px-4 py-3">{{ $suitableSize[$field] }}cm</td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
      <div class="flex justify-between mx-auto my-5">
        <button
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index') }}'"
          class="text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">計測日一覧へ</button>
        <button
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.edit' : 'measurement.edit', ['measurement' => $bodyMeasurement->id]) }}'"
          class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">体格寸法の編集</button>
        <button
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.correction.edit' : 'correction.edit', ['correction' => $bodyCorrection->id]) }}?from_measurement_id={{ $bodyMeasurement->id }}'"
          class="text-white bg-teal-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">補正値の編集</button>
        <form action="{{ route('admin.measurement.destroy', ['measurement' => $bodyMeasurement->id]) }}" method="post"
          class="inline">
          @csrf
          @method('delete')
          <button
            class="text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-300 rounded">削除</button>
        </form>
      </div>
    </div>
  </section>


</x-app-layout>
