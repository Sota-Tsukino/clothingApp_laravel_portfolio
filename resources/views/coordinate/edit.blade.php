<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      コーディネート編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-3xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <form
        action="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.update' : 'coordinate.update', ['coordinate' => $coordinate->id]) }}"
        method="post" enctype="multipart/form-data">
        @csrf
        <div class="w-full mb-6 ">
          <h2 class='text-black'>必須入力</h2>
          <div class="flex mb-6 justify-between">
            <div class="main w-1/3 text-center">
              <label class="block mb-2 text-gray-700">メイン画像</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="bg-blue-500 text-white px-4 py-2 rounded" data-target="main">
                衣類を選択
              </button>
              <div class="w-2/3 mx-auto">
                <img id="preview-main" class="mt-4 max-w-xs rounded shadow w-full"
                  src="{{ asset('storage/items/' . $coordinate->items[0]->image->file_name) }}">
                <input type="hidden" name="items[]" id="input-main" value="{{ $coordinate->items[0]->id }}">
              </div>
            </div>
            <div class="sub1 w-1/3 text-center">
              <label class="block mb-2 text-gray-700">サブ画像1</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="bg-blue-500 text-white px-4 py-2 rounded" data-target="sub1">
                衣類を選択
              </button>
              <div class="w-2/3 mx-auto">
                <img id="preview-sub1" class="mt-4 max-w-xs rounded shadow w-full"
                  src="{{ asset('storage/items/' . $coordinate->items[1]->image->file_name) }}">
                <input type="hidden" name="items[]" id="input-sub1" value="{{ $coordinate->items[1]->id }}">
              </div>
            </div>
            <div class="sub2 w-1/3 text-center">
              <label class="block mb-2 text-gray-700">サブ画像2</label>
              <button type="button" data-micromodal-trigger="modal-item-list"
                class="bg-blue-500 text-white px-4 py-2 rounded" data-target="sub2">
                衣類を選択
              </button>
              <div class="w-2/3 mx-auto">
                @if (isset($coordinate->items[2]))
                  <img id="preview-sub2" class="mt-4 max-w-xs rounded shadow w-full"
                    src="{{ asset('storage/items/' . $coordinate->items[2]->image->file_name) }}">
                  <input type="hidden" name="items[]" id="input-sub2" value="{{ $coordinate->items[2]->id }}">
                @else
                  <img id="preview-sub2" class="mt-4 max-w-xs rounded shadow w-full" style="display: none;">
                  <input type="hidden" name="items[]" id="input-sub2">
                @endif

              </div>
            </div>

          </div>
          <x-modal-select-item :items="$items" />
          <div class="flex mb-6 items-center">
            <label for="sceneTag_id" class="leading-7 text-sm text-gray-600 w-1/3">シーンタグ</label>
            <select name="sceneTag_id" id="categorySelect"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="">シーンタグを選択してください</option>
              @foreach ($sceneTags as $sceneTag)
                <option value="{{ $sceneTag->id }}" {{ $coordinate->scene_tag_id == $sceneTag->id ? 'selected' : '' }}>
                  {{ __("sceneTag.$sceneTag->name") }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="is_public" class="leading-7 text-sm text-gray-600 w-1/3">コーデを公開</label>
            <select name="is_public" id="is_public"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="1" {{ $coordinate->is_public == 1 ? 'selected' : '' }}>公開する</option>
              <option value="0" {{ $coordinate->is_public == 0 ? 'selected' : '' }}>公開しない</option>
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="is_favorite" class="leading-7 text-sm text-gray-600 w-1/3">お気に入り</label>
            <select name="is_favorite" id="is_favorite"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="1" {{ $coordinate->is_favorite == 1 ? 'selected' : '' }}>登録する</option>
              <option value="0" {{ $coordinate->is_favorite == 0 ? 'selected' : '' }}>登録しない</option>
            </select>
          </div>

          <hr class="my-6">
          <h2 class='text-black'>任意入力</h2>
          <div class="flex mb-6 items-center">
            <label for="memo" class="leading-7 text-sm text-gray-600 w-1/3">メモ</label>
            <textarea name="memo" id="memo"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              maxlength="50" placeholder="50文字以内で入力">{{ $coordinate->memo }}</textarea>
          </div>
        </div>
        <div class="flex justify-between mx-auto">
          <button
            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">更新する</button>
          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.show' : 'coordinate.show', ['coordinate' => $coordinate->id]) }}'"
            class=" text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">キャンセル</button>
        </div>
    </div>
    </form>
    </div>
  </section>
</x-app-layout>
