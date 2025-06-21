@php
  $main = $coordinate->items->get(0);
  $sub1 = $coordinate->items->get(1);
  $sub2 = $coordinate->items->get(2);
@endphp
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      コーディネート詳細
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-4 sm:px-8">
    <div
      class="container max-w-3xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- バリデーションエラーとフラッシュメッセージ -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <div class="w-full mb-6">
        <h2 class="text-xl font-medium text-gray-700 border-b border-gray-200 pb-2">コーデ画像</h2>

        <!-- 画像表示部分 - レスポンシブ対応 -->
        <div class="flex flex-col sm:flex-row my-6 space-y-6 sm:space-y-0 sm:space-x-4">
          <div class="w-full sm:w-1/3 text-center">
            <span class="block mb-2 text-gray-700 font-medium">メイン画像</span>
            <div class="w-2/3 mx-auto">
              @if ($main)
                <img src="{{ asset('storage/items/' . $main->image->file_name) }}" alt="衣類画像"
                  class="mt-2 rounded shadow w-full object-cover">
              @else
                <div class="bg-gray-100 rounded-lg p-6 flex items-center justify-center">
                  <p class="text-gray-500">未選択</p>
                </div>
              @endif
            </div>
          </div>

          <div class="w-full sm:w-1/3 text-center">
            <span class="block mb-2 text-gray-700 font-medium">サブ画像1</span>
            <div class="w-2/3 mx-auto">
              @if ($sub1)
                <img src="{{ asset('storage/items/' . $sub1->image->file_name) }}" alt="衣類画像"
                  class="mt-2 rounded shadow w-full object-cover">
              @else
                <div class="bg-gray-100 rounded-lg p-6 flex items-center justify-center">
                  <p class="text-gray-500">未登録</p>
                </div>
              @endif
            </div>
          </div>

          <div class="w-full sm:w-1/3 text-center">
            <span class="block mb-2 text-gray-700 font-medium">サブ画像2</span>
            <div class="w-2/3 mx-auto">
              @if ($sub2)
                <img src="{{ asset('storage/items/' . $sub2->image->file_name) }}" alt="衣類画像"
                  class="mt-2 rounded shadow w-full object-cover">
              @else
                <div class="bg-gray-100 rounded-lg p-6 flex items-center justify-center">
                  <p class="text-gray-500">未登録</p>
                </div>
              @endif
            </div>
          </div>
        </div>

        <!-- 詳細情報 -->
        <div class="mb-8">
          <div class="flex flex-wrap items-center py-3 border-b border-gray-200">
            <span class="text-sm font-medium text-gray-600 w-full sm:w-1/3 mb-1 sm:mb-0">シーンタグ</span>
            <span class="text-sm font-semibold">
              {{ __("sceneTag.{$coordinate->sceneTag->name}") }}
            </span>
          </div>

          <div class="flex flex-wrap items-center py-3 border-b border-gray-200">
            <span class="text-sm font-medium text-gray-600 w-full sm:w-1/3 mb-1 sm:mb-0">お気に入り</span>
            <span
              class="text-sm font-semibold
              {{ $coordinate->is_favorite == '1' ? 'text-green-600' : 'text-gray-600' }}">
              {{ $coordinate->is_favorite == '1' ? '登録済み' : '未登録' }}
            </span>
          </div>
        </div>

        <!-- メモ -->
        <div class="mb-8">
          <h3 class="text-sm font-medium text-gray-700 mb-2">メモ</h3>
          <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $coordinate->memo ?? '未登録' }}</p>
          </div>
        </div>
      </div>

      <!-- ボタンエリア -->
      <div class="flex flex-col sm:flex-row justify-around mx-auto gap-4">
        <button
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.edit' : 'coordinate.edit', ['coordinate' => $coordinate->id]) }}'"
          class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          編集する
        </button>
        <button
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.index' : 'coordinate.index') }}'"
          class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          コーデ一覧へ
        </button>

        <form id="delete_{{ $coordinate->id }}"
          action="{{ route('admin.coordinate.destroy', ['coordinate' => $coordinate->id]) }}" method="post"
          class="inline">
          @csrf
          @method('delete')
          <button type="button" onclick="deletePost(this)" data-id="{{ $coordinate->id }}"
            class="w-full text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            削除する
          </button>
        </form>
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
