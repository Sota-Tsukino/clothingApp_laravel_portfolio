<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      体格情報編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <div class="flex justify-between pb-4">
        <div class="w-1/2 border">
          <img src="{{ asset('images/body.png') }}" alt="">
        </div>
        <div class="w-1/2 border">
          <img src="{{ asset('images/foot.png') }}" alt="">
        </div>
      </div>
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.store' : 'measurement.store') }}"
        method="post">
        @csrf
        <div class="mb-4">
          <label for="measured_at" class="block text-sm font-medium text-gray-700">計測日</label>
          <input type="date" name="measured_at" id="measured_at"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            value="{{ old('measured_at', Carbon\Carbon::now()->format('Y/m/d')) }}" >
        </div>

        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">部位</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">体格寸法</th>
              <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">ガイド</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($fields as $field)
              <tr>
                <td class="text-center px-2 py-2">{{ __("measurement.$field") }}</td>
                <td class="text-center px-2 py-2">
                  <input type="number" name="{{ $field }}" step="0.1" value="{{ old($field) }}"
                    min="0.0" max="999.9">
                  <span class="ml-1">cm</span>
                </td>
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
        <div class="flex justify-between mx-auto my-5 w-1/2">
          <button
            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">作成する</button>
          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index') }}'"
            class="text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">戻る</button>
        </div>
      </form>
    </div>
  </section>


</x-app-layout>
