<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格情報一覧
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font">
    <div class="container px-5 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <div class="lg:w-2/3 w-full mx-auto overflow-auto">
        <table class="table-auto w-full text-left whitespace-no-wrap">
          <thead>
            <tr>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">計測日</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">身長</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">首回り</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">胸囲</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">ウエスト</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">足長</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">操作</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($bodyMeasurements))
                @foreach ($bodyMeasurements as $bodyMeasurement)
                <tr>
                    <td class="text-center px-4 py-3">{{ $bodyMeasurement->measured_at }}</td>
                    <td class="text-center px-4 py-3">{{ $bodyMeasurement->height }}</td>
                    <td class="text-center px-4 py-3">{{ $bodyMeasurement->neck_circumference }}cm</td>
                    <td class="text-center px-4 py-3">{{ $bodyMeasurement->chest_circumference }}cm</td>
                    <td class="text-center px-4 py-3">{{ $bodyMeasurement->waist }}cm</td>
                    <td class="text-center px-4 py-3">{{ $bodyMeasurement->foot_length }}cm</td>
                    <td class="text-center px-4 py-3">
                    <button
                        onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $bodyMeasurement->id]) }}'"
                        class="inline-block text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">詳細</button>
                    <form action="{{ route('admin.measurement.destroy', ['measurement' => $bodyMeasurement->id]) }}"
                        method="post" class="inline-block">
                        @csrf
                        @method('delete')
                        <button
                        class="text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-300 rounded">削除</button>
                    </form>
                    </td>
                </tr>
                @endforeach
            @endif
            体格情報が登録されていません。
          </tbody>
        </table>
        <button
        onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.create' : 'measurement.create', ['measurement' => $bodyMeasurement->id]) }}'"
        class="text-white bg-teal-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">新規登録</button>
      </div>
    </div>
  </section>


</x-app-layout>
