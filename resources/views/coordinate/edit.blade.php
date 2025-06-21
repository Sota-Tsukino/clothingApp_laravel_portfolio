<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      コーディネート編集
    </h2>
  </x-slot>

  <section class="text-gray-600 overflow-hidden bg-gray-50 py-12 px-4 sm:px-8">
    <div
      class="container max-w-3xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <form
        action="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.update' : 'coordinate.update', ['coordinate' => $coordinate->id]) }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="w-full mb-6">
          <h2 class="text-xl font-medium text-gray-700 border-b border-gray-200 pb-2">必須入力</h2>

          <!-- 画像選択部分 - レスポンシブ対応 -->
          <div class="flex flex-col sm:flex-row my-6 space-y-8 sm:space-y-0 sm:space-x-4">
            <!-- メイン画像 -->
            <div class="w-full sm:w-1/3 text-center">
              <label class="block mb-2 text-gray-700 font-medium">メイン画像</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                data-target="main">
                衣類を選択
              </button>

              <button type="button" id="cancel-main"
                class="mt-2 mx-auto text-sm text-red-600 hover:text-red-800 hover:underline cancel-button" data-target="main"
                style="display: none;">
                ✕ 選択をキャンセル
              </button>

              <div class="w-2/3 mx-auto mt-3">
                <img id="preview-main" class="rounded shadow w-full object-cover"
                  src="{{ asset('storage/items/' . $coordinate->items[0]->image->file_name) }}">
                <input type="hidden" name="items[]" id="input-main" value="{{ $coordinate->items[0]->id }}">
              </div>
            </div>

            <!-- サブ画像1 -->
            <div class="w-full sm:w-1/3 text-center">
              <label class="block mb-2 text-gray-700 font-medium">サブ画像1</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                data-target="sub1">
                衣類を選択
              </button>

              <button type="button" id="cancel-sub1"
                class="mt-2 text-sm mx-auto text-red-600 hover:text-red-800 hover:underline cancel-button" data-target="sub1"
                style="display: none;">
                ✕ 選択をキャンセル
              </button>

              <div class="w-2/3 mx-auto mt-3">
                <img id="preview-sub1" class="rounded shadow w-full object-cover"
                  src="{{ asset('storage/items/' . $coordinate->items[1]->image->file_name) }}">
                <input type="hidden" name="items[]" id="input-sub1" value="{{ $coordinate->items[1]->id }}">
              </div>
            </div>

            <!-- サブ画像2 -->
            <div class="w-full sm:w-1/3 text-center">
              <label class="block mb-2 text-gray-700 font-medium">サブ画像2</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                data-target="sub2">
                衣類を選択
              </button>

              <button type="button" id="cancel-sub2"
                class="mt-2 mx-auto text-sm text-red-600 hover:text-red-800 hover:underline cancel-button" data-target="sub2"
                style="display: none;">
                ✕ 選択をキャンセル
              </button>

              <div class="w-2/3 mx-auto mt-3">
                @if (isset($coordinate->items[2]))
                  <img id="preview-sub2" class="rounded shadow w-full object-cover"
                    src="{{ asset('storage/items/' . $coordinate->items[2]->image->file_name) }}">
                  <input type="hidden" name="items[]" id="input-sub2" value="{{ $coordinate->items[2]->id }}">
                @else
                  <img id="preview-sub2" class="rounded shadow w-full object-cover" style="display: none;">
                  <input type="hidden" name="items[]" id="input-sub2">
                @endif
              </div>
            </div>
          </div>

          <!-- 衣類選択モーダル -->
          <x-modal-select-item :items="$items" />

          <!-- フォーム項目 -->
          <div class="space-y-4 mt-8">
            <!-- シーンタグ -->
            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
              <label for="sceneTag_id" class="text-sm font-medium text-gray-600 w-full sm:w-1/3">シーンタグ</label>
              <select name="sceneTag_id" id="categorySelect"
                class="w-full sm:w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out"
                required>
                <option value="">シーンタグを選択してください</option>
                @foreach ($sceneTags as $sceneTag)
                  <option value="{{ $sceneTag->id }}"
                    {{ $coordinate->scene_tag_id == $sceneTag->id ? 'selected' : '' }}>
                    {{ __("sceneTag.$sceneTag->name") }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- お気に入り設定 -->
            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
              <label for="is_favorite" class="text-sm font-medium text-gray-600 w-full sm:w-1/3">お気に入り</label>
              <select name="is_favorite" id="is_favorite"
                class="w-full sm:w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out"
                required>
                <option value="1" {{ $coordinate->is_favorite == 1 ? 'selected' : '' }}>登録する</option>
                <option value="0" {{ $coordinate->is_favorite == 0 ? 'selected' : '' }}>登録しない</option>
              </select>
            </div>
          </div>

          <!-- 任意入力セクション -->
          <div class="my-8 pt-6 border-t border-gray-200">
            <h2 class="text-xl font-medium text-gray-700 mb-4">任意入力</h2>

            <div class="flex flex-col sm:flex-row sm:items-start space-y-2 sm:space-y-0">
              <label for="memo" class="text-sm font-medium text-gray-600 w-full sm:w-1/3 pt-2">メモ</label>
              <textarea name="memo" id="memo"
                class="w-full sm:w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-3 leading-relaxed transition-colors duration-200 ease-in-out h-32"
                maxlength="50" placeholder="50文字以内で入力">{{ $coordinate->memo }}</textarea>
            </div>
          </div>
        </div>

        <!-- ボタンエリア -->
        <div class="flex flex-col sm:flex-row justify-around mx-auto space-y-3 sm:space-y-0">
          <button type="submit"
            class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            更新する
          </button>

          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.show' : 'coordinate.show', ['coordinate' => $coordinate->id]) }}'"
            class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            キャンセル
          </button>
        </div>
      </form>
    </div>
  </section>
</x-app-layout>
