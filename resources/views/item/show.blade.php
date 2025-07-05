<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      衣類アイテム詳細
    </h2>
  </x-slot>
  <section class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="p-6 md:p-8">
        <!-- バリデーションエラーとフラッシュメッセージ -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <x-flash-message status="session('status')" />
        <!-- 画像とプライマリ情報のグリッド -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          <!-- 左側: 画像 -->
          <div class="flex flex-col space-y-4">
            <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2">衣類アイテム画像</h2>
            <div class="aspect-square w-full overflow-hidden rounded-lg bg-gray-100 shadow-md">
              <img class="w-full h-full object-cover" id="item-img"
                src="{{ asset('storage/items/' . $item->image->file_name) }}" alt="衣類画像">
            </div>
          </div>

          <!-- 右側: 重要情報 -->
          <div class="flex flex-col space-y-4">
            <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2">基本情報</h2>

            <div class="grid grid-cols-1 gap-3">
              <div class="flex items-center py-2 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-600 w-1/3">カテゴリー</span>
                <span id="categorySelect" class="text-sm text-gray-900 font-semibold"
                  data-type="{{ $item->category->name }}">{{ __("category.{$item->category->name}") }}</span>
              </div>

              <div class="flex items-center py-2 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-600 w-1/3">サブカテゴリー</span>
                <span id="sub_category_id" class="text-sm text-gray-900 font-semibold"
                  data-type="{{ $item->subCategory->name }}">{{ __("subcategory.{$item->subCategory->name}") ?? '未登録' }}</span>
              </div>

              <div class="flex items-center py-2 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-600 w-1/3">ブランド</span>
                <span class="text-sm text-gray-900 font-semibold">{{ __("brand.{$item->brand->name}") }}</span>
              </div>

              <div class="flex items-center py-2 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-600 w-1/3">色</span>
                <div class="flex flex-wrap gap-2">
                  @foreach ($item->colors as $color)
                    <div class="flex items-center">
                      <span class="inline-block w-5 h-5 rounded-md border border-gray-300"
                        style="background-color: {{ $color->hex_code }}"></span>
                      <span class="ml-1.5 text-sm text-gray-900">{{ __("color.$color->name") ?? '未登録' }}</span>
                    </div>
                  @endforeach
                </div>
              </div>

              <div class="flex items-center py-2 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-600 w-1/3">ステータス</span>
                @if ($item->status === 'owned')
                  <div class="flex items-center px-1 py-1 rounded-full text-green-600 bg-green-100">
                    <span class="inline-block w-6 h-6 mr-2">
                      <img src="{{ asset('images/icons/owned.svg') }}" alt="所持中アイコン" class="w-full h-full">
                    </span>
                    <span class="text-sm/6 font-semibold">
                      {{ __("status.$item->status") }}
                    </span>
                  </div>
                @elseif($item->status === 'cleaning')
                  <div class="flex items-center px-1 py-1 rounded-full bg-yellow-100 text-yellow-800">
                    <span class="inline-block w-6 h-6 mr-2">
                      <img src="{{ asset('images/icons/cleaning.svg') }}" alt="クリーニングアイコン" class="w-full h-full">
                    </span>
                    <span class="text-sm/6 font-semibold ">
                      {{ __("status.$item->status") }}
                    </span>
                  </div>
                @else
                  <div class="flex items-center px-1 py-1 rounded-full bg-gray-100 text-gray-800">
                    <span class="inline-block w-6 h-6 mr-2">
                      <img src="{{ asset('images/icons/discarded.svg') }}" alt="破棄済アイコン" class="w-full h-full">
                    </span>
                    <span class="text-sm/6 font-semibold ">
                      {{ __("status.$item->status") }}
                    </span>
                  </div>
                @endif
              </div>
              <div class="flex items-center py-2 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-600 w-1/3">衣類提案に</span>
                <span
                  class="text-sm font-semibold rounded-full px-1 py-1
                       {{ $item->is_item_suggest == '1' ? 'text-green-600 bg-green-100' : 'bg-gray-100 text-gray-800' }}">
                  {{ $item->is_item_suggest == '1' ? '使用する' : '使用しない' }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- 詳細情報セクション -->
        <div class="mb-8">
          <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">詳細情報</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">

            <div class="flex items-center py-2 border-b border-gray-200">
              <span class="text-sm font-medium text-gray-600 w-1/3">主素材</span>
              <span class="text-sm text-gray-900">
                {{ $item->mainMaterial !== null ? __("material.{$item->mainMaterial->name}") : '未登録' }}
              </span>
            </div>

            <div class="flex items-center py-2 border-b border-gray-200">
              <span class="text-sm font-medium text-gray-600 w-1/3">副素材</span>
              <span class="text-sm text-gray-900">
                {{ $item->subMaterial !== null ? __("material.{$item->subMaterial->name}") : '未登録' }}
              </span>
            </div>

            <div class="flex items-center py-2 border-b border-gray-200">
              <span class="text-sm font-medium text-gray-600 w-1/3">家庭洗濯</span>
              <span class="text-sm text-gray-900">
                {{ $item->washability_option !== null ? __("washability.$item->washability_option") : '未登録' }}
              </span>
            </div>

            <div class="flex items-center py-2 border-b border-gray-200">
              <span class="text-sm font-medium text-gray-600 w-1/3">購入日</span>
              <span class="text-sm text-gray-900">
                {{ $item->purchased_date ? \Carbon\Carbon::parse($item->purchased_date)->format('Y/m/d') : '未登録' }}
              </span>
            </div>

            <div class="flex items-center py-2 border-b border-gray-200">
              <span class="text-sm font-medium text-gray-600 w-1/3">金額</span>
              <div class="flex items-center">
                <span class="text-sm text-gray-900 font-semibold">
                  {{ number_format($item->price) ?? '未登録' }}
                </span>
                <span class="ml-1 text-sm text-gray-600">円</span>
              </div>
            </div>

            <div class="flex items-center py-2 border-b border-gray-200">
              <span class="text-sm font-medium text-gray-600 w-1/3">購入場所</span>
              <span class="text-sm text-gray-900">{{ $item->purchased_at ?? '未登録' }}</span>
            </div>
          </div>
        </div>

        <!-- タグと季節 -->
        <div class="mb-8">
          <div class="flex flex-col space-y-4">
            <div>
              <h3 class="text-sm font-medium text-gray-700 mb-2">タグ</h3>
              <div class="flex flex-wrap gap-2">
                @foreach ($item->tags as $tag)
                  <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ __("tag.$tag->name") ?? '未登録' }}
                  </span>
                @endforeach
                @if (count($item->tags) === 0)
                  <span class="text-sm text-gray-500">設定されていません</span>
                @endif
              </div>
            </div>

            <div>
              <h3 class="text-sm font-medium text-gray-700 mb-2">季節</h3>
              <div class="flex flex-wrap gap-2">
                @foreach ($item->seasons as $season)
                  <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    {{ __("season.$season->name") ?? '未登録' }}
                  </span>
                @endforeach
                @if (count($item->seasons) === 0)
                  <span class="text-sm text-gray-500">設定されていません</span>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- メモ -->
        <div class="mb-8">
          <h3 class="text-sm font-medium text-gray-700 mb-2">メモ</h3>
          <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $item->memo ?? '未登録' }}</p>
          </div>
        </div>

        <!-- サイズ情報テーブル -->
        <div class="mb-8">
          <h2 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4">サイズ情報</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            @if ($item->category->name == 'tops' || $item->category->name == 'outer')
              <div class="top-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                  <h3 id="upper-img-title" class="text-sm font-medium text-gray-700">トップス測定ガイド</h3>
                </div>
                <div class="p-2">
                  <img id="tops-img" src="{{ asset('images/measurements/shirt-common.svg') }}"
                    class="w-full h-auto" alt="トップス測定ガイド">
                </div>
              </div>
            @elseif($item->category->name == 'bottoms')
              <div class="bottom-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                  <h3 class="text-sm font-medium text-gray-700">ボトムス測定ガイド</h3>
                </div>
                <div class="p-2">
                  <img id="bottoms-img" src="{{ asset('images/measurements/slacks-common.svg') }}"
                    class="w-full h-auto" alt="ボトムス測定ガイド">
                </div>
              </div>
            @else
              <div class="top-item border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                  <h3 id="upper-img-title" class="text-sm font-medium text-gray-700">トップス測定ガイド</h3>
                </div>
                <div class="p-2">
                  <img id="tops-img" src="{{ asset('images/measurements/jacket-common.svg') }}"
                    class="w-full h-auto" alt="トップス測定ガイド">
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
            @endif
          </div>
          <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    部位</th>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    あなたに合う衣類サイズ
                  </th>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    衣類サイズ</th>
                  <th scope="col"
                    class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap min-w-[146px]">判定
                  </th>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    優先度</th>
                  <th scope="col" class="px-4 py-4 text-left text-sm font-medium text-gray-500 whitespace-nowrap">
                    ガイド</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @php
                  $categoryName = $item->category->name;
                  if ($categoryName === 'setup') {
                      $fields = [
                          'total_length',
                          'kitake_length',
                          'neck_circumference',
                          'shoulder_width',
                          'yuki_length',
                          'sleeve_length',
                          'chest_circumference',
                          'armpit_to_armpit_width',
                          'waist',
                          'hip',
                          'inseam',
                      ];
                  } elseif (in_array($categoryName, ['tops', 'outer'])) {
                      $fields = [
                          'total_length',
                          'kitake_length',
                          'neck_circumference',
                          'shoulder_width',
                          'yuki_length',
                          'sleeve_length',
                          'chest_circumference',
                          'armpit_to_armpit_width',
                      ];
                  } elseif ($categoryName === 'bottoms') {
                      $fields = ['waist', 'hip', 'inseam'];
                  }
                @endphp
                @foreach ($fields as $field)
                  <tr class="hover:bg-gray-50">
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
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                      <span id="{{ $field }}__size">
                        {{ $item->$field ? number_format($item->$field, 1) : '未登録' }}
                      </span>
                      <span class="ml-1">cm</span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                      <span id="{{ $field }}_result"
                        class="inline-flex px-2 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ $field == 'total_length' ? 'ー' : '未評価' }}
                      </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
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
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.edit' : 'clothing-item.edit', ['clothing_item' => $item->id]) }}'"
            class="inline-block text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            編集する
          </button>

          <button type="button"
            onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index') }}'"
            class="inline-block text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            衣類アイテム一覧へ
          </button>

          <form id="delete_{{ $item->id }}"
            action="{{ route('admin.clothing-item.destroy', ['clothing_item' => $item->id]) }}" method="post"
            class="block">
            @csrf
            @method('delete')
            <button type="button" onclick="deletePost(this)" data-id="{{ $item->id }}"
              class="w-full inline-block text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
              削除する
            </button>
          </form>

        </div>
      </div>
    </div>
  </section>
</x-app-layout>
<div id="item-detail" data-tolerance='@json($userTolerance)' data-suitable='@json($suitableSize)'
  data-item='@json($item)'></div>
<script>
  function deletePost(e) {
    'use strict';
    if (confirm('この衣類アイテムを削除します。よろしいですか？')) {
      document.getElementById('delete_' + e.dataset.id).submit();
    }
  }
</script>
