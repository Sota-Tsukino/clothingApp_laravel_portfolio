@props(['coordinate'])

@php
  $main = $coordinate->items->get(0);
  $sub1 = $coordinate->items->get(1);
  $sub2 = $coordinate->items->get(2);
@endphp

<div class="w-full h-full">
  <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.show' : 'coordinate.show', ['coordinate' => $coordinate->id]) }}"
    class="block h-full bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-200 border border-gray-100">

    <!-- 画像セクション -->
    <div class="bg-gray-50 p-3">
      <div class="flex justify-between">
        <!-- メイン -->
        <div class="w-1/3 px-1">
          <div class="text-center text-xs text-gray-500 mb-1">メイン</div>
          <div class="aspect-square bg-white rounded overflow-hidden flex items-center justify-center p-1">
            @if ($main)
              <img src="{{ asset('storage/items/' . $main->image->file_name) }}" alt="メイン衣類"
                class="max-h-full object-contain rounded">
            @else
              <div class="text-xs text-gray-400">未登録</div>
            @endif
          </div>
        </div>

        <!-- サブ1 -->
        <div class="w-1/3 px-1">
          <div class="text-center text-xs text-gray-500 mb-1">サブ1</div>
          <div class="aspect-square bg-white rounded overflow-hidden flex items-center justify-center p-1">
            @if ($sub1)
              <img src="{{ asset('storage/items/' . $sub1->image->file_name) }}" alt="サブ1衣類"
                class="max-h-full object-contain rounded">
            @else
              <div class="text-xs text-gray-400">未登録</div>
            @endif
          </div>
        </div>

        <!-- サブ2 -->
        <div class="w-1/3 px-1">
          <div class="text-center text-xs text-gray-500 mb-1">サブ2</div>
          <div class="aspect-square bg-white rounded overflow-hidden flex items-center justify-center p-1">
            @if ($sub2)
              <img src="{{ asset('storage/items/' . $sub2->image->file_name) }}" alt="サブ2衣類"
                class="max-h-full object-contain rounded">
            @else
              <div class="text-xs text-gray-400">未登録</div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- 情報セクション -->
    <div class="p-3 text-sm">
      <div class="mb-1 font-medium text-gray-800">{{ __("sceneTag.{$coordinate->sceneTag->name}") }}</div>
      <div class="flex justify-between text-xs text-gray-500">
        <div>{{ $coordinate->created_at->format('Y/m/d') }}</div>
        <div class="flex space-x-2">
          <span class="{{ $coordinate->is_public ? 'text-green-600' : 'text-gray-500' }}">
            {{ $coordinate->is_public ? '公開' : '非公開' }}
          </span>
          <span class="{{ $coordinate->is_favorite ? 'text-amber-500' : 'text-gray-500' }}">
            @if ($coordinate->is_favorite)
              <span class="inline-flex items-center">
                <img src="{{ asset('images/icons/my_favorite.svg') }}" class="w-3 h-3" alt="お気に入りアイコン">
                お気に入り
              </span>
            @else
              未登録
            @endif
          </span>
        </div>
      </div>
    </div>
  </a>
</div>
