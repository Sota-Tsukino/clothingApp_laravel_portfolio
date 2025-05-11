<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      衣類アイテム登録
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.store' : 'clothing-item.store') }}"
        method="post" enctype="multipart/form-data">
        @csrf
        <div class="w-full mb-6 ">
          <h2 class='text-black'>必須入力</h2>
          <div class="flex flex-col mb-6">
            <label for="file_name" class="mb-2 text-gray-700">衣類アイテム画像を選択</label>
            <input type="file" id="file_name" name="file_name" accept="image/jpg, image/jpeg, image/png"
              class="file_name" required autofocus>
            <div class="w-2/3">
              <img id="preview" src="" alt="プレビュー画像" class="mt-4 max-w-xs rounded shadow w-full"
                style="display: none;">
            </div>
          </div>
          <div class="flex mb-6 items-center">
            <label for="category_id" class="leading-7 text-sm text-gray-600 w-1/3">カテゴリー</label>
            <select name="category_id" id="categorySelect"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="" {{ old('category_id') == '' ? 'selected' : '' }}>カテゴリーを選択してください</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}
                  data-type="{{ $category->name }}">
                  {{ __("category.$category->name") }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="sub_category_id" class="leading-7 text-sm text-gray-600 w-1/3">サブカテゴリー</label>
            <select name="sub_category_id" id="sub_category_id"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="" {{ old('sub_category_id') == '' ? 'selected' : '' }}>サブカテゴリーを選択してください</option>
              @foreach ($categories as $category)
                @foreach ($category->subCategory as $subCategory)
                  <option value="{{ $subCategory->id }}"
                    {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                    {{ __("subcategory.$subCategory->name") }}
                  </option>
                @endforeach
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="brand_id" class="leading-7 text-sm text-gray-600 w-1/3">ブランド</label>
            <select name="brand_id" id="brand_id"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="" {{ old('brand_id') == '' ? 'selected' : '' }}>ブランドを選択してください</option>
              @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                  {{ $brand->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="color" class="leading-7 text-sm text-gray-600 w-1/3">色</label>
            <select name="colors[]" id="colors" multiple class="w-2/3 bg-gray-100 inline-block" required>
              @foreach ($colors as $color)
                <option value="{{ $color->id }}" data-custom-properties='{"hex":"{{ $color->hex_code }}"}'
                  {{ collect(old('colors'))->contains($color->id) ? 'selected' : '' }}>
                  {{ __("color.$color->name") }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="status" class="leading-7 text-sm text-gray-600 w-1/3">ステータス</label>
            <select name="status" id="status"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="" {{ old('status') == null ? 'selected' : '' }}>ステータスを選択してください</option>
              <option value="owned" {{ old('status') == 'owned' ? 'selected' : '' }}>
                所持中
              </option>
              <option value="cleaning" {{ old('status') == 'cleaning' ? 'selected' : '' }}>
                クリーニング中
              </option>
              <option value="discarded" {{ old('status') == 'discarded' ? 'selected' : '' }}>
                破棄済
              </option>
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="is_public" class="leading-7 text-sm text-gray-600 w-1/3">衣類の公開</label>
            <select name="is_public" id="is_public"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="1" {{ old('is_public') == '1' ? 'selected' : '' }}>公開する</option>
              <option value="0" {{ old('is_public') == '0' ? 'selected' : '' }}>公開しない</option>
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="is_coordinate_suggest" class="leading-7 text-sm text-gray-600 w-1/3">コーデ提案に</label>
            <select name="is_coordinate_suggest" id="is_coordinate_suggest"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              required>
              <option value="1" {{ old('is_coordinate_suggest') == '1' ? 'selected' : '' }}>使用する</option>
              <option value="0" {{ old('is_coordinate_suggest') == '0' ? 'selected' : '' }}>使用しない</option>
            </select>
          </div>
          <hr class="my-6">
          <h2 class='text-black'>任意入力</h2>
          <div class="flex mb-6 items-center">
            <label for="tags" class="leading-7 text-sm text-gray-600 w-1/3">タグ</label>
            <select name="tags[]" id="tags" multiple class="w-2/3 bg-gray-100">
              @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                  {{ __("tag.$tag->name") }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <legend for="season" class="leading-7 text-sm text-gray-600 w-1/3">季節</legend>
            @foreach ($seasons as $season)
              <div>
                <input type="checkbox" name="seasons[]" class="mr-2" value="{{ $season->id }}">
                <label for="season"
                  class="leading-7 text-sm text-gray-600 mr-2">{{ __("season.$season->name") }}</label>
              </div>
            @endforeach
          </div>
          <div class="flex mb-6 items-center">
            <label for="main_material" class="leading-7 text-sm text-gray-600 w-1/3">主素材</label>
            <select name="main_material" id="main_material"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              <option value="" {{ old('main_material') == '' ? 'selected' : '' }}>素材を選択してください</option>
              @foreach ($materials as $material)
                <option value="{{ $material->id }}" {{ old('main_material') == $material->id ? 'selected' : '' }}>
                  {{ __("material.$material->name") }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="sub_material" class="leading-7 text-sm text-gray-600 w-1/3">副素材</label>
            <select name="sub_material" id="sub_material"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              <option value="" {{ old('sub_material') == '' ? 'selected' : '' }}>素材を選択してください</option>
              @foreach ($materials as $material)
                <option value="{{ $material->id }}" {{ old('sub_material') == $material->id ? 'selected' : '' }}>
                  {{ __("material.$material->name") }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="washability_option" class="leading-7 text-sm text-gray-600 w-1/3">家庭洗濯</label>
            <select name="washability_option" id="washability_option"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              <option value="" {{ old('washability_option') == null ? 'selected' : '' }}>選択してください</option>
              <option value="washable_machine"
                {{ old('washability_option') == 'washable_machine' ? 'selected' : '' }}>
                洗濯機可
              </option>
              <option value="washable_hand" {{ old('washability_option') == 'washable_hand' ? 'selected' : '' }}>
                手洗いOK
              </option>
              <option value="not_washable" {{ old('washability_option') == 'not_washable' ? 'selected' : '' }}>
                不可
              </option>
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="purchased_date" class="leading-7 text-sm text-gray-600 w-1/3">購入日</label>
            <input type="date" name="purchased_date" id="purchased_date"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              value="{{ old('purchased_date', Carbon\Carbon::now()->format('Y-m-d')) }}">
          </div>
          <div class="flex mb-6 items-center">
            <label for="price" class="leading-7 text-sm text-gray-600 w-1/3">金額</label>
            <input type="number" name="price" id="price"
              class="w-1/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              value="{{ old('price') }}">
            <span class="w-1/3 inline ml-2">円</span>
          </div>
          <div class="flex mb-6 items-center">
            <label for="purchased_at" class="leading-7 text-sm text-gray-600 w-1/3">購入場所</label>
            <input type="text" name="purchased_at" id="purchased_at"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              maxlength="20" value="{{ old('purchased_at') }}">
          </div>
          <div class="flex mb-6 items-center">
            <label for="memo" class="leading-7 text-sm text-gray-600 w-1/3">メモ</label>
            <textarea name="memo" id="memo"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
              maxlength="50">{{ old('memo') }}</textarea>
          </div>
          <h2 class='text-black'>衣類サイズ入力</h2>
          <div class="flex justify-between pb-4">
            <div class="top-item w-1/2 border">
              <img src="{{ asset('images/topps.png') }}" class="w-full"alt="">
            </div>
            <div class="bottom-item w-1/2 border">
              <img src="{{ asset('images/bottoms.png') }}"class="w-full" alt="">
            </div>
          </div>
          <p>※体格測定日は最新の日付：{{ $bodyMeasurement->measured_at }}を元に判定します</p>
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr>
                <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">部位</th>
                <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">あなたに合う衣類サイズ</th>
                <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">衣類サイズ</th>
                <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">判定</th>
                <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">優先度</th>
                <th class="text-center title-font font-medium text-gray-900 text-sm bg-gray-100">ガイド</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($fields as $field)
                @php
                  $fieldClass = in_array($field, [
                      'neck_circumference',
                      'shoulder_width',
                      'yuki_length',
                      'chest_circumference',
                  ])
                      ? 'top-item'
                      : (in_array($field, ['waist', 'inseam', 'hip'])
                          ? 'bottom-item'
                          : '');
                @endphp
                <tr class="{{ $fieldClass }}">
                  <td class="text-center px-2 py-2">{{ __("measurement.$field") }}</td>
                  <td class="text-center px-2 py-2">
                    {{ number_format($suitableSize[$field], 1) ?? '未登録' }}<span class="ml-1">cm</span>
                  </td>
                  <td class="text-center px-2 py-2">
                    <input type="number" name="{{ $field }}" id="{{ $field }}" step="0.1"
                      value="{{ old($field) }}" min="0.0" max="999.0" placeholder="40.0"
                      class="text-black">
                    <span class="ml-1">cm</span>
                  </td>
                  <td>
                    <span id="{{ $field }}_result" class="font-semibold block">未評価</span>
                  </td>
                  <td class="text-center px-2 py-2">
                    {{ $field == 'chest_circumference' || $field == 'hip' ? '低い' : '高い' }}</td>
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

        </div>
        <div class="flex justify-between mx-auto">
          <button
            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">登録する</button>
          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index') }}'"
            class=" text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">キャンセル</button>
        </div>
    </div>
    </form>
    </div>
  </section>
</x-app-layout>

{{-- JSファイルにPHPの変数を渡す --}}
<div id="size-checker" data-tolerance='@json($userTolerance)' data-suitable='@json($suitableSize)'>
</div>
<div id="init-item-category-list" data-categories='@json($categories)'
  data-subcategorytranslations='@json(__('subcategory'))'></div>
