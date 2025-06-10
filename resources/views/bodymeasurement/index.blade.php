<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格情報一覧
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font max-w-7xl mx-auto">
    <div class="container px-4 sm:px-5 py-8 sm:py-16 mx-auto bg-white rounded-lg my-6 sm:my-12 md:my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <div class="w-full mx-auto">
        @if (count($bodyMeasurements) > 0)
          <!-- PC・タブレット向けテーブル表示 (md以上のサイズで表示) -->
          <div class="hidden md:block overflow-x-auto">
            <table class="table-auto w-full text-left whitespace-no-wrap">
              <thead>
                <tr>
                  <th class="px-4 py-3 title-font font-medium text-gray-900 text-sm bg-gray-100 rounded-tl-lg">計測日</th>
                  <th class="px-4 py-3 title-font font-medium text-gray-900 text-sm bg-gray-100">身長</th>
                  <th class="px-4 py-3 title-font font-medium text-gray-900 text-sm bg-gray-100">首回り</th>
                  <th class="px-4 py-3 title-font font-medium text-gray-900 text-sm bg-gray-100">胸囲</th>
                  <th class="px-4 py-3 title-font font-medium text-gray-900 text-sm bg-gray-100">ウエスト</th>
                  <th class="px-4 py-3 title-font font-medium text-gray-900 text-sm bg-gray-100">足長</th>
                  <th class="px-4 py-3 title-font font-medium text-gray-900 text-sm bg-gray-100 rounded-tr-lg">操作</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($bodyMeasurements as $bodyMeasurement)
                  <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}
                    </td>
                    <td class="px-4 py-3">{{ $bodyMeasurement->height }}cm</td>
                    <td class="px-4 py-3">{{ $bodyMeasurement->neck_circumference }}cm</td>
                    <td class="px-4 py-3">{{ $bodyMeasurement->chest_circumference }}cm</td>
                    <td class="px-4 py-3">{{ $bodyMeasurement->waist }}cm</td>
                    <td class="px-4 py-3">{{ $bodyMeasurement->foot_length }}cm</td>
                    <td class="px-4 py-3 space-x-2">
                      <button
                        onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $bodyMeasurement->id]) }}'"
                        class="inline-block text-white bg-indigo-500 border-0 py-1.5 px-4 focus:outline-none hover:bg-indigo-600 rounded text-sm transition">詳細</button>
                      <form
                        action="{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.destroy' : 'measurement.destroy', ['measurement' => $bodyMeasurement->id]) }}"
                        method="post" class="inline-block">
                        @csrf
                        @method('delete')
                        <button
                          class="text-white bg-red-500 border-0 py-1.5 px-4 focus:outline-none hover:bg-red-600 rounded text-sm transition">削除</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- スマホ向けカード表示 (md未満のサイズで表示) -->
          <div class="md:hidden space-y-4">
            @foreach ($bodyMeasurements as $bodyMeasurement)
              <div class="border rounded-lg p-4 shadow-sm hover:shadow transition">
                <div class="mb-3 pb-2 border-b">
                  <div class="font-medium">計測日: <span
                      class="font-normal">{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}</span>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-4">
                  <div class="text-sm">
                    <span class="font-medium">身長: </span>
                    <span>{{ $bodyMeasurement->height }}cm</span>
                  </div>
                  <div class="text-sm">
                    <span class="font-medium">首回り: </span>
                    <span>{{ $bodyMeasurement->neck_circumference }}cm</span>
                  </div>
                  <div class="text-sm">
                    <span class="font-medium">胸囲: </span>
                    <span>{{ $bodyMeasurement->chest_circumference }}cm</span>
                  </div>
                  <div class="text-sm">
                    <span class="font-medium">ウエスト: </span>
                    <span>{{ $bodyMeasurement->waist }}cm</span>
                  </div>
                  <div class="text-sm">
                    <span class="font-medium">足長: </span>
                    <span>{{ $bodyMeasurement->foot_length }}cm</span>
                  </div>
                </div>
                <div class="flex space-x-2">
                  <button
                    onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $bodyMeasurement->id]) }}'"
                    class="flex-1 text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded text-sm transition">詳細</button>
                  <form
                    action="{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.destroy' : 'measurement.destroy', ['measurement' => $bodyMeasurement->id]) }}"
                    method="post" class="flex-1">
                    @csrf
                    @method('delete')
                    <button
                      class="w-full text-white bg-red-500 border-0 py-2 px-4 focus:outline-none hover:bg-red-600 rounded text-sm transition">削除</button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="my-3 text-center">体格情報が登録されていません。</p>
        @endif

        <div class="mt-8 flex justify-center md:justify-start">
          <button
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.create' : 'measurement.create') }}'"
            class="text-white bg-green-500 border-0 text-sm px-4 py-2 focus:outline-none hover:bg-green-600 rounded transition">新規登録</button>
        </div>
      </div>
    </div>
  </section>
</x-app-layout>
