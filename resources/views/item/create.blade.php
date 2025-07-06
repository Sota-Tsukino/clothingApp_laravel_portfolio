<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      衣類アイテム登録
    </h2>
  </x-slot>

  <section class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 md:p-8">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <form id="form"
        action="{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.store' : 'clothing-item.store') }}"
        method="post" enctype="multipart/form-data">
        @csrf
        <!-- 必須入力項目 -->
        <div class="mb-8">
          <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-6">必須入力</h2>

          <!-- 画像アップロード -->
          <div class="mb-6">
            <label for="file_name" class="block text-sm font-medium text-gray-700 mb-2">衣類アイテム画像を選択</label>
            <div class="w-full">
              <div
                class="mt-1 px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition-colors">
                <div class="mx-auto aspect-square max-w-xs bg-gray-100 rounded-lg overflow-hidden shadow-md">
                  <img id="preview" src="" alt="プレビュー画像" class="mt-4 max-w-xs rounded shadow w-full"
                    style="display: none;">
                </div>
                <div class="space-y-1 text-center">
                  <div class="text-sm text-gray-600 mt-4">
                    <label for="file_name"
                      class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                      <span class="block">画像をアップロード</span>
                      <input type="file" id="file_name" name="file_name" accept="image/jpg, image/jpeg, image/png"
                        class="file_name sr-only" required autofocus>
                    </label>
                  </div>
                  <p class="text-xs text-gray-500">PNG, JPG, JPEG （最大4MB）</p>
                </div>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">カテゴリー</label>
              <select name="category_id" id="categorySelect"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
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
            <!-- サブカテゴリー -->
            <div>
              <label for="sub_category_id" class="block text-sm font-medium text-gray-700 mb-1">サブカテゴリー</label>
              <select name="sub_category_id" id="sub_category_id"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
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
          </div>

          <!-- ブランド -->
          <div class="mb-4">
            <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">ブランド</label>
            <select name="brand_id" id="brand_id"
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
              required>
              <option value="" {{ old('brand_id') == '' ? 'selected' : '' }}>ブランドを選択してください</option>
              @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                  {{ __("brand.$brand->name") }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- 色 -->
          <div class="mb-4">
            <label for="color" class="block text-sm font-medium text-gray-700 mb-1">色</label>
            <select name="colors[]" id="colors" multiple
              class="mt-1 block w-full text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
              @foreach ($colors as $color)
                <option value="{{ $color->id }}" data-custom-properties='{"hex":"{{ $color->hex_code }}"}'
                  {{ collect(old('colors'))->contains($color->id) ? 'selected' : '' }}>
                  {{ __("color.$color->name") }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <!-- ステータス -->
            <div>
              <label for="status" class="block text-sm font-medium text-gray-700 mb-1">ステータス</label>
              <select name="status" id="status"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
                required>
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

            <!-- 衣類提案 -->
            <div>
              <label for="is_item_suggest" class="block text-sm font-medium text-gray-700 mb-1">衣類提案に</label>
              <select name="is_item_suggest" id="is_item_suggest"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
                required>
                <option value="1" {{ old('is_item_suggest') == '1' ? 'selected' : '' }}>使用する</option>
                <option value="0" {{ old('is_item_suggest') == '0' ? 'selected' : '' }}>使用しない</option>
              </select>
            </div>
          </div>
        </div>
        <!-- 任意入力項目 -->
        <div class="mb-8">
          <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-6">任意入力</h2>
          <!-- タグ -->
          <div class="mb-6">
            <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">タグ</label>
            <select name="tags[]" id="tags" multiple
              class="mt-1 block w-full text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
              @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                  {{ __("tag.$tag->name") }}
                </option>
              @endforeach
            </select>
          </div>
          <!-- 季節 -->
          <div class="mb-6">
            <legend for="season" class="block text-sm font-medium text-gray-700 mb-2">季節 （※複数選択可能）</legend>
            <div class="flex flex-wrap gap-4">
              @foreach ($seasons as $season)
                <div>
                  <input type="checkbox" name="seasons[]"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    value="{{ $season->id }}">
                  <label for="season" class="ml-2 text-sm text-gray-700">{{ __("season.$season->name") }}</label>
                </div>
              @endforeach
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <!-- 主素材 -->
            <div>
              <label for="main_material" class="block text-sm font-medium text-gray-700 mb-1">主素材</label>
              <select name="main_material" id="main_material"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                <option value="" {{ old('main_material') == '' ? 'selected' : '' }}>素材を選択してください</option>
                @foreach ($materials as $material)
                  <option value="{{ $material->id }}" {{ old('main_material') == $material->id ? 'selected' : '' }}>
                    {{ __("material.$material->name") }}
                  </option>
                @endforeach
              </select>
            </div>
            <!-- 副素材 -->
            <div>
              <label for="sub_material" class="block text-sm font-medium text-gray-700 mb-1">副素材</label>
              <select name="sub_material" id="sub_material"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                <option value="" {{ old('sub_material') == '' ? 'selected' : '' }}>素材を選択してください</option>
                @foreach ($materials as $material)
                  <option value="{{ $material->id }}" {{ old('sub_material') == $material->id ? 'selected' : '' }}>
                    {{ __("material.$material->name") }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <!-- 家庭洗濯 -->
          <div class="mb-4">
            <label for="washability_option" class="block text-sm font-medium text-gray-700 mb-1">家庭洗濯</label>
            <select name="washability_option" id="washability_option"
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
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
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <!-- 購入日 -->
            <div>
              <label for="purchased_date" class="block text-sm font-medium text-gray-700 mb-1">購入日</label>
              <input type="date" name="purchased_date" id="purchased_date"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
                value="{{ old('purchased_date', Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>
            <!-- 購入場所 -->
            <div>
              <label for="purchased_at" class="block text-sm font-medium text-gray-700 mb-1">購入場所</label>
              <input type="text" name="purchased_at" id="purchased_at"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm"
                maxlength="20" value="{{ old('purchased_at') }}">
            </div>
          </div>
          <!-- 金額 -->
          <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">金額</label>
            <div class="mt-1 flex rounded-md shadow-sm">
              <input type="number" name="price" id="price"
                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md border-gray-300"
                value="{{ old('price') }}">
              <span
                class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">円</span>
            </div>
          </div>

          <!-- メモ -->
          <div class="mb-4">
            <label for="memo" class="block text-sm font-medium text-gray-700 mb-1">メモ</label>
            <textarea name="memo" id="memo"
              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full border-gray-300 rounded-md"
              maxlength="50">{{ old('memo') }}</textarea>
          </div>
        </div>

        <!-- 衣類サイズ -->
        <div class="mb-8">
          <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">衣類サイズ入力</h2>
          <!-- 画像ガイド -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="top-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                <h3 id="upper-img-title" class="text-sm font-medium text-gray-700">トップス測定ガイド</h3>
              </div>
              <div class="p-2">
                <img id="tops-img" src="{{ asset('images/measurements/shirt-common.svg') }}" class="w-full h-auto"
                  alt="トップス測定ガイド">
              </div>
            </div>
            <div class="bottom-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                <h3 class="text-sm font-medium text-gray-700">ボトムス測定ガイド</h3>
              </div>
              <div class="p-2">
                <img id="bottoms-img" src="{{ asset('images/measurements/slacks-common.svg') }}"
                  class="w-full h-auto" alt="ボトムス測定ガイド">
              </div>
            </div>
          </div>
          <!-- 注意書き -->
          <div class="mb-6 bg-green-50 p-4 rounded-md">
            <p class="text-sm text-green-700">
              サイズ判定は最新の体格計測日：{{ \Carbon\Carbon::parse($bodyMeasurement->measured_at)->format('Y/m/d') }}を元に判定します</p>
          </div>
          <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    部位</th>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    あなたに合う衣類サイズ</th>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    衣類サイズ</th>
                  <th scope="col"
                    class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap min-w-[148px]">判定
                  </th>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    優先度</th>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    ガイド</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($fields as $field)
                  @php
                    $fieldClass = in_array($field, [
                        'total_length',
                        'kitake_length',
                        'neck_circumference',
                        'shoulder_width',
                        'yuki_length',
                        'sleeve_length',
                        'chest_circumference',
                        'armpit_to_armpit_width',
                    ])
                        ? 'top-item'
                        : (in_array($field, ['waist', 'inseam', 'hip'])
                            ? 'bottom-item'
                            : '');
                  @endphp
                  <tr class="{{ $fieldClass }}  hover:bg-gray-50">
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      {{ __("measurement.$field") }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                      <div
                        class="inline-flex text-sm font-semibold px-2 py-1 rounded-full {{ $suitableSize[$field] ? 'text-green-600 bg-green-50' : 'text-gray-700' }}">
                        @if ($field === 'total_length')
                          ー
                        @else
                          {{ $suitableSize[$field] ? number_format($suitableSize[$field], 1) : '未登録' }}<span
                            class="ml-1">cm</span>
                        @endif
                      </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      <div class="flex items-center">
                        <input type="number" name="{{ $field }}" id="{{ $field }}" step="0.1"
                          value="{{ old($field) }}" min="0.0" max="999.0" placeholder="40.0"
                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-20 text-sm border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-600">cm</span>
                      </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      <span id="{{ $field }}_result"
                        class="inline-flex px-2 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ $field == 'total_length' ? 'ー' : '未評価' }}
                      </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      <x-sizechecker-priority-tag :priorityMap="$priorityMap" :field="$field" />
                    </td>
                    <td x-data="{ show: false }" class="relative px-4 py-4">
                      <x-popup-guide :field="$field" :guides="$guides" />
                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>

        <!-- アクションボタン -->
        <div class="flex flex-col sm:flex-row justify-around gap-4 pt-4">
          <button
            class="inline-block text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">登録する</button>
          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index') }}'"
            class="inline-block text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">キャンセル</button>
        </div>
      </form>
    </div>
    </div>
  </section>
</x-app-layout>

{{-- JSファイルにPHPの変数を渡す --}}
<div id="size-checker" data-tolerance='@json($userTolerance)' data-suitable='@json($suitableSize)'>
</div>
<div id="init-item-category-list" data-categories='@json($categories)'
  data-subcategorytranslations='@json(__('subcategory'))'></div>
