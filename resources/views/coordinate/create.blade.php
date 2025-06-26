<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      コーディネート登録
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-4 sm:px-8">
    <div class="container max-w-3xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.store' : 'coordinate.store') }}"
        method="post" enctype="multipart/form-data">
        @csrf
        <div class="w-full mb-6 ">
          <h2 class="text-xl font-medium text-gray-700 border-b border-gray-200 pb-2">必須入力</h2>
          <div class="flex flex-col sm:flex-row my-6 space-y-8 sm:space-y-0 sm:space-x-4">
            <div class="main sm:w-1/3 text-center">
              <label class="block mb-2 text-gray-700 font-medium">メイン画像</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-target="main">
                衣類を選択
              </button>
              <button type="button" id="cancel-main" class="mt-2 mx-auto text-sm text-red-600 hover:underline cancel-button"
                data-target="main" style="display: none;">✕ 選択をキャンセル</button>
              <div class="w-2/3 mx-auto">
                <img id="preview-main" class="mt-4 max-w-xs rounded shadow w-full" style="display: none;">
                <input type="hidden" name="items[]" id="input-main">
              </div>
            </div>
            <div class="sub1 sm:w-1/3 text-center">
              <label class="block mb-2 text-gray-700 font-medium">サブ画像1</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-target="sub1">
                衣類を選択
              </button>
              <button type="button" id="cancel-sub1" class="mt-2 mx-auto text-sm text-red-600 hover:underline cancel-button"
                data-target="sub1" style="display: none;">✕ 選択をキャンセル</button>
              <div class="w-2/3 mx-auto">
                <img id="preview-sub1" class="mt-4 max-w-xs rounded shadow w-full" style="display: none;">
                <input type="hidden" name="items[]" id="input-sub1">
              </div>
            </div>
            <div class="sub2 sm:w-1/3 text-center">
              <label class="block mb-2 text-gray-700 font-medium">サブ画像2</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" data-target="sub2">
                衣類を選択
              </button>
              <button type="button" id="cancel-sub2" class="mt-2 mx-auto text-sm text-red-600 hover:underline cancel-button"
                data-target="sub2" style="display: none;">✕ 選択をキャンセル</button>
              <div class="w-2/3 mx-auto">
                <img id="preview-sub2" class="mt-4 max-w-xs rounded shadow w-full" style="display: none;">
                <input type="hidden" name="items[]" id="input-sub2">
              </div>
            </div>

          </div>
          <x-modal-select-item :items="$items" />
          <div class="flex mb-6 items-center">
            <label for="sceneTag_id" class="text-sm font-medium text-gray-600 w-full sm:w-1/3">シーンタグ</label>
            <select name="sceneTag_id" id="categorySelect"
              class="w-full sm:w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="" {{ old('sceneTag_id') == '' ? 'selected' : '' }}>選択してください</option>
              @foreach ($sceneTags as $sceneTag)
                <option value="{{ $sceneTag->id }}" {{ old('sceneTag_id') == $sceneTag->id ? 'selected' : '' }}>
                  {{ __("sceneTag.$sceneTag->name") }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="is_favorite" class="text-sm font-medium text-gray-600 w-full sm:w-1/3">お気に入り</label>
            <select name="is_favorite" id="is_favorite"
              class="w-full sm:w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              {{-- DB上は型がbooleanになっているのでvalue= true/falseで管理する？ --}}
              <option value="1" {{ old('is_favorite') == 1 ? 'selected' : '' }}>登録する</option>
              <option value="0" {{ old('is_favorite') == 0 ? 'selected' : '' }}>登録しない</option>
            </select>
          </div>

          <!-- 任意入力セクション -->
          <div class="my-8 pt-6 border-t border-gray-200">
            <h2 class="text-xl font-medium text-gray-700 mb-4">任意入力</h2>
            <div class="flex flex-col sm:flex-row sm:items-start space-y-2 sm:space-y-0">
                <label for="memo" class="text-sm font-medium text-gray-600 w-full sm:w-1/3 pt-2">メモ</label>
                <textarea name="memo" id="memo"
                class="w-full sm:w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-2 px-3 leading-relaxed transition-colors duration-200 ease-in-out h-32"
                maxlength="50" placeholder="50文字以内で入力">{{ old('memo') }}</textarea>
            </div>
          </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-around mx-auto space-y-3 sm:space-y-0">
          <button
            class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">登録する</button>
          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index') }}'"
            class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">キャンセル</button>
        </div>
    </div>
    </form>
    </div>
  </section>
</x-app-layout>
