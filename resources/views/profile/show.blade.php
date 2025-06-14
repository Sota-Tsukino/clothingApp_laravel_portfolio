<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      プロフィール
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
    <x-flash-message status="session('status')" />
      <div class="w-full mb-6 ">
        <div class="flex mb-6">
          <span class="text-gray-500">ニックネーム</span>
          <span class="ml-auto text-gray-900">{{ $user->nickname }}</span>
        </div>
        <div class="flex mb-6">
          <span class="text-gray-500">メール</span>
          <span class="ml-auto text-gray-900">{{ $user->email }}</span>
        </div>
        <div class="flex mb-6">
          <span class="text-gray-500">都道府県</span>
          <span class="ml-auto text-gray-900">{{ $user->prefecture->name ?? '未設定' }}</span>
        </div>
        <div class="flex mb-6">
          <span class="text-gray-500">市区町村</span>
          <span class="ml-auto text-gray-900">{{ $user->city->name ?? '未設定' }}</span>
        </div>
        <div class="flex justify-between mx-auto">
          <button onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.profile.edit' : 'profile.edit') }}'"
            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">編集</button>
        </div>
      </div>
    </div>
  </section>


</x-app-layout>
