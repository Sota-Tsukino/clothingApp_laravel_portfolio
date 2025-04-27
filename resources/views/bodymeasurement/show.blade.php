<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格情報詳細
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <x-flash-message status="session('status')" />

      <div class="flex justify-between pb-4">
        <div class="w-1/2 border">
          <img src="{{ asset('images/body.png') }}" alt="">
        </div>
        <div class="w-1/2 border">
          <img src="{{ asset('images/foot.png') }}" alt="">
        </div>
      </div>
      <h3 class="font-semibold text-sm text-gray-800 leading-tight">計測日：{{ $bodyMeasurement->measured_at }}</h3>
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
