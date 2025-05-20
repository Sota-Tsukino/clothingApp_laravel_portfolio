<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      コーディネート詳細
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-3xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- バリデーションエラーとフラッシュメッセージ -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <div class="w-full mb-6 ">
        <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2">コーデ画像</h2>
        <div class="flex my-6 justify-between">
          <div class="main w-1/3 text-center">
            <span class="block mb-2 text-gray-700">メイン画像</span>
            <div class="w-2/3 mx-auto">
              @if (isset($coordinate->items[0]))
                <img src="{{ asset('storage/items/' . $coordinate->items[0]->image->file_name) }}" alt="衣類画像"
                  class="mt-4 max-w-xs rounded shadow w-full">
              @endif
            </div>
          </div>
          <div class="sub1 w-1/3 text-center">
            <span class="block mb-2 text-gray-700">サブ画像1</span>
            <div class="w-2/3 mx-auto">
              @if (isset($coordinate->items[1]))
                <img src="{{ asset('storage/items/' . $coordinate->items[1]->image->file_name) }}" alt="衣類画像"
                  class="mt-4 max-w-xs rounded shadow w-full">
              @endif
            </div>
          </div>
          <div class="sub2 w-1/3 text-center">
            <span class="block mb-2 text-gray-700">サブ画像2</span>
            <div class="w-2/3 mx-auto">
              @if (isset($coordinate->items[2]))
                <img src="{{ asset('storage/items/' . $coordinate->items[2]->image->file_name) }}" alt="衣類画像"
                  class="mt-4 max-w-xs rounded shadow w-full">
              @else
                <p>未選択</p>
              @endif
            </div>
          </div>

        </div>
        <div class="mb-8">
          <div class="flex items-center py-2 border-b border-gray-200">
            <span class="text-sm font-medium text-gray-600 w-1/3">シーンタグ</span>
            <span class="text-sm font-semibold">
              {{ __("sceneTag.{$coordinate->sceneTag->name}") }}
            </span>
          </div>
          <div class="flex items-center py-2 border-b border-gray-200">
            <span class="text-sm font-medium text-gray-600 w-1/3">コーデを公開</span>
            <span
              class="text-sm font-semibold
                           {{ $coordinate->is_public == '1' ? 'text-green-600' : 'text-gray-600' }}">
              {{ $coordinate->is_public == '1' ? '公開する' : '公開しない' }}
            </span>
          </div>
          <div class="flex items-center py-2 border-b border-gray-200">
            <span class="text-sm font-medium text-gray-600 w-1/3">お気に入り</span>
            <span
              class="text-sm font-semibold
                           {{ $coordinate->is_favorite == '1' ? 'text-green-600' : 'text-gray-600' }}">
              {{ $coordinate->is_favorite == '1' ? '登録済み' : '未登録' }}
            </span>
          </div>
        </div>

        <div class="mb-8">
          <h3 class="text-sm font-medium text-gray-700 mb-2">メモ</h3>
          <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $coordinate->memo ?? '未登録' }}</p>
          </div>
        </div>
      </div>
      <div class="flex justify-between mx-auto">
        <button
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.edit' : 'coordinate.edit', ['coordinate' => $coordinate->id]) }}'"
          class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">編集する</button>
        <form id="delete_{{ $coordinate->id }}"
          action="{{ route('admin.coordinate.destroy', ['coordinate' => $coordinate->id]) }}" method="post"
          class="inline">
          @csrf
          @method('delete')
          <button type="button" onclick="deletePost(this)" data-id="{{ $coordinate->id }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            削除する
          </button>
        </form>
      </div>
    </div>
    </div>
  </section>
</x-app-layout>
<script>
  function deletePost(e) {
    'use strict';
    if (confirm('本当に削除してもいいですか?')) {
      document.getElementById('delete_' + e.dataset.id).submit();
    }
  }
</script>
