<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格情報一覧
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font max-w-7xl mx-auto">
    <div class="max-w-3xl px-4 py-4 sm:px-8 sm:py-8 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <div class="w-full mx-auto">
        @if (count($bodyMeasurements) > 0)
          <!-- PC・タブレット向けテーブル表示 (md以上のサイズで表示) -->
          <div class="hidden md:block overflow-x-auto bg-white rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">計測日</th>
                  <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">身長</th>
                  <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">首回り</th>
                  <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">胸囲</th>
                  <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">ウエスト</th>
                  <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">足長</th>
                  <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">操作</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($bodyMeasurements as $bodyMeasurement)
                  <tr class="hover:bg-gray-50">
                    <td class="px-3 py-3 text-sm whitespace-nowrap">{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}
                    </td>
                    <td class="px-3 py-3 text-sm whitespace-nowrap">{{ $bodyMeasurement->height ?? '未登録' }}cm</td>
                    <td class="px-3 py-3 text-sm whitespace-nowrap">{{ $bodyMeasurement->neck_circumference ?? '未登録' }}cm</td>
                    <td class="px-3 py-3 text-sm whitespace-nowrap">{{ $bodyMeasurement->chest_circumference ?? '未登録' }}cm</td>
                    <td class="px-3 py-3 text-sm whitespace-nowrap">{{ $bodyMeasurement->waist ?? '未登録' }}cm</td>
                    <td class="px-3 py-3 text-sm whitespace-nowrap">{{ $bodyMeasurement->foot_length ?? '未登録' }}cm</td>
                    <td class="px-3 py-3 text-sm whitespace-nowrap">
                      <button
                        onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $bodyMeasurement->id]) }}'"
                        class="inline-block px-4 py-2 bg-indigo-600 rounded-md font-semibold text-sm text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">詳細</button>
                      <form
                        action="{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.destroy' : 'measurement.destroy', ['measurement' => $bodyMeasurement->id]) }}"
                        method="post" class="inline-block">
                        @csrf
                        @method('delete')
                        <button
                          class="inline-block px-4 py-2 bg-red-600 rounded-md font-semibold text-sm text-white hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">削除</button>
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
                    <span>{{ $bodyMeasurement->height ?? '未登録' }}cm</span>
                  </div>
                  <div class="text-sm">
                    <span class="font-medium">首回り: </span>
                    <span>{{ $bodyMeasurement->neck_circumference ?? '未登録' }}cm</span>
                  </div>
                  <div class="text-sm">
                    <span class="font-medium">胸囲: </span>
                    <span>{{ $bodyMeasurement->chest_circumference ?? '未登録' }}cm</span>
                  </div>
                  <div class="text-sm">
                    <span class="font-medium">ウエスト: </span>
                    <span>{{ $bodyMeasurement->waist ?? '未登録' }}cm</span>
                  </div>
                  <div class="text-sm">
                    <span class="font-medium">足長: </span>
                    <span>{{ $bodyMeasurement->foot_length ?? '未登録' }}cm</span>
                  </div>
                </div>
                <div class="flex space-x-2">
                  <button
                    onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $bodyMeasurement->id]) }}'"
                    class="w-1/2 inline-block px-4 py-2 bg-indigo-600 rounded-md font-semibold text-sm text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">詳細</button>
                  <form
                    action="{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.destroy' : 'measurement.destroy', ['measurement' => $bodyMeasurement->id]) }}"
                    method="post" class="flex-1">
                    @csrf
                    @method('delete')
                    <button
                      class="w-full inline-block px-4 py-2 bg-red-600 rounded-md font-semibold text-sm text-white hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">削除</button>
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
            class="inline-block px-4 py-2 bg-green-600 rounded-md font-semibold text-sm text-white hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">新規登録</button>
        </div>
      </div>
    </div>
  </section>
</x-app-layout>
