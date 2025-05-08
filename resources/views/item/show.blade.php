<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      衣類アイテム詳細
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <div class="w-full mb-6 ">
        <div class="flex flex-col mb-6">
          <span class="mb-2 text-gray-700">衣類アイテム画像</span>
          <div class="w-1/2">
            <img class="w-full" id="item-img" src="{{ asset('storage/items/' . $item->image->file_name) }}"
              alt="衣類画像" class="mt-4 max-w-xs rounded shadow">
          </div>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">カテゴリー</span>
          <span class="ml-auto text-gray-900">{{ $item->category->name }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">サブカテゴリー</span>
          <span class="ml-auto text-gray-900">{{ $item->subCategory->name ?? '未登録' }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">ブランド</span>
          <span class="ml-auto text-gray-900">{{ $item->brand->name }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">色</span>
          @foreach ($item->colors as $color)
            <div class="color flex items-center ml-4">
              <span class="inline-block border border-gray w-6 h-6 aspect-auto rounded-md"
                style="background-color: {{ $color->hex_code }}"></span>
              <span class="ml-2 text-gray-900">{{ $color->name ?? '未登録' }}</span>
            </div>
          @endforeach
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">ステータス</span>
          <span class="ml-auto text-gray-900">{{ $item->status }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">衣類の公開</span>
          <span class="ml-auto text-gray-900">{{ $item->is_public ? '公開する' : '非公開にする' }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">コーデ提案に</span>
          <span class="ml-auto text-gray-900">{{ $item->is_coordinate_suggest == '1' ? '使用する' : '使用しない' }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">タグ</span>
          @foreach ($item->tags as $tag)
            <span
              class="ml-4 text-gray-900 inline-block border-solid border-gray-500 border p-1 rounded-md">{{ $tag->name ?? '未登録' }}</span>
          @endforeach
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">季節</span>
          @foreach ($item->seasons as $season)
            <span
              class="ml-4 text-gray-900 inline-block border-solid border-gray-500 border p-1 rounded-md">{{ $season->name ?? '未登録' }}</span>
          @endforeach
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">主素材</span>
          <span class="ml-auto text-gray-900">{{ $item->mainMaterial->name ?? '未登録' }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">副素材</span>
          <span class="ml-auto text-gray-900">{{ $item->subMaterial->name ?? '未登録' }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">家庭洗濯</span>
          <span class="ml-auto text-gray-900">{{ $item->washability_option ?? '未登録' }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span for="purchased_at" class="leading-7 text-sm text-gray-600 w-1/3">購入日</span>
          <span class="ml-auto text-gray-900">{{ $item->purchased_date ?? '未登録' }}</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">金額</span>
          <span class="ml-auto text-gray-900">{{ number_format($item->price) ?? '未登録' }}</span>
          <span class="inline-block ml-2">円</span>
        </div>
        <div class="flex mb-6 items-center">
          <span class="leading-7 text-sm text-gray-600 w-1/3">購入場所</span>
          <span class="ml-auto text-gray-900">{{ $item->purchased_at ?? '未登録' }}</span>
        </div>
        <div class="mb-6">
          <span class="leading-7 text-sm text-gray-600 w-1/3 block">メモ</span>
          <p name="memo" id="memo" class="ml-auto text-gray-900">{{ $item->memo ?? '未登録' }}</p>
        </div>
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
              <tr>
                <td class="text-center px-2 py-2">{{ __("measurement.$field") }}</td>
                <td class="text-center px-2 py-2">
                  {{ number_format($suitableSize[$field], 1) ?? '未登録' }}<span class="ml-1">cm</span>
                </td>
                <td class="text-center px-2 py-2">
                  <span class="text-black">{{ $item->$field }}</span>
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
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.edit' : 'clothing-item.edit', ['clothing_item' => $item->id]) }}'"
          class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">編集する</button>
        <button type="button"
          onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index') }}'"
          class=" text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">衣類アイテム一覧へ</button>
      </div>
    </div>
    </div>
  </section>
</x-app-layout>
