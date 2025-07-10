<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      プロフィール
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-4 md:px-8">
    <div class="max-w-xl px-8 sm:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <x-flash-message status="session('status')" />
      <div class="w-full mb-6 ">
        <div class="flex mb-6 border-b py-2">
          <span class="text-gray-500 text-sm font-semibold">ニックネーム</span>
          <span class="ml-auto text-gray-900">{{ $user->nickname }}</span>
        </div>
        <div class="flex mb-6 border-b py-2">
          <span class="text-gray-500 text-sm font-semibold">メール</span>
          <span class="ml-auto text-gray-900">{{ $user->email }}</span>
        </div>
        <div class="flex mb-6 border-b py-2">
          <span class="text-gray-500 text-sm font-semibold">性別</span>
          <span class="ml-auto text-gray-900">{{ __("user.$user->gender") }}</span>
        </div>
        @if ($user->role == 'admin')
          <div class="flex mb-6 border-b py-2">
            <span class="text-gray-500 text-sm font-semibold">役割</span>
            <span class="ml-auto text-gray-900">{{ __("user.$user->role") }}</span>
          </div>
        @endif
        <div class="flex mb-6 border-b py-2">
          <span class="text-gray-500 text-sm font-semibold">都道府県</span>
          <span class="ml-auto text-gray-900">{{ $user->prefecture->name ?? '未設定' }}</span>
        </div>
        <div class="flex mb-6 border-b py-2">
          <span class="text-gray-500 text-sm font-semibold">市区町村</span>
          <span class="ml-auto text-gray-900">{{ $user->city->name ?? '未設定' }}</span>
        </div>
        <div class="pt-6">
          <div class="flex flex-col sm:flex-row gap-3 justify-around">
            <button
              onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.profile.edit' : 'profile.edit') }}'"
              class="inline-block px-4 py-2 bg-indigo-600 rounded-md font-semibold text-sm text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">編集する</button>
          </div>
        </div>
      </div>
    </div>
  </section>


</x-app-layout>
