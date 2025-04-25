<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      プロフィール
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden">
    <div class="container max-w-2xl w-1/2 px-8 py-8 mx-auto bg-white rounded-lg mt-7 shadow-lg">
      <div class="w-full mb-6 ">
        <div class="flex mb-6">
          <span class="text-gray-500">ニックネーム</span>
          <span class="ml-auto text-gray-900">admin</span>
        </div>
        <div class="flex mb-6">
          <span class="text-gray-500">パスワード</span>
          <span class="ml-auto text-gray-900">admin</span>
        </div>
        <div class="flex mb-6">
          <span class="text-gray-500">都道府県</span>
          <span class="ml-auto text-gray-900">admin</span>
        </div>
        <div class="flex mb-6">
          <span class="text-gray-500">市区町村</span>
          <span class="ml-auto text-gray-900">admin</span>
        </div>
        <div class="flex justify-between mx-auto">
            <button
                class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">編集</button>
            <button
                class=" text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">削除</button>
        </div>
      </div>
    </div>
  </section>


</x-app-layout>
