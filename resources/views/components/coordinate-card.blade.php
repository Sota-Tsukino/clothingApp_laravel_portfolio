@props(['coordinate'])

@php
  $main = $coordinate->items->get(0);
  $sub1 = $coordinate->items->get(1);
  $sub2 = $coordinate->items->get(2);
@endphp

<div class="w-full h-full border rounded-lg shadow">
  <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.show' : 'coordinate.show', ['coordinate' => $coordinate->id]) }}"
    class="block bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-200 border border-gray-100">

    <!-- 画像セクション -->
    <div class="bg-gray-50 p-3">
      <div class="flex justify-between">
        <!-- メイン -->
        <div class="w-1/3 px-1">
          <div class="text-center text-xs text-gray-500 mb-1">メイン</div>
          <div class="aspect-square bg-white rounded overflow-hidden flex items-center justify-center p-1">
            @if ($main)
              <img src="{{ Storage::disk('s3')->temporaryUrl('items/' . $main->image->file_name, now()->addMinutes(10)) }}" alt="メイン衣類"
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
              <img src="{{ Storage::disk('s3')->temporaryUrl('items/' . $sub1->image->file_name, now()->addMinutes(10)) }}" alt="サブ1衣類"
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
              <img src="{{ Storage::disk('s3')->temporaryUrl('items/' . $sub2->image->file_name, now()->addMinutes(10)) }}" alt="サブ2衣類"
                class="max-h-full object-contain rounded">
            @else
              <div class="text-xs text-gray-400">未登録</div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </a>

  <!-- 情報セクション -->
  <div class="p-3 text-sm">
    <div class="flex justify-between items-center text-xs text-gray-500">
      <div>
        <p class="mb-1 font-medium text-gray-800">{{ __("sceneTag.{$coordinate->sceneTag->name}") }}</p>
        <p>{{ $coordinate->created_at->format('Y/m/d') }}</p>
      </div>
      <form method="post"
        action="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.toggle' : 'coordinate.toggle', ['coordinate' => $coordinate->id]) }}" class="inline-block">
        @csrf
        @method('put')
        <button type="submit" class="inline-block bg-transparent border-none p-0 w-8 h-8">
          @if ($coordinate->is_favorite)
            <img src="{{ asset('images/icons/favorite-yellow.svg') }}" class="w-full " alt="お気に入りアイコン">
          @else
            <img src="{{ asset('images/icons/favorite-gray.svg') }}" class="w-full " alt="お気に入りアイコン">
          @endif
        </button>
        <input type="hidden" name="is_favorite" value="{{ $coordinate->is_favorite }}">
      </form>
    </div>
  </div>
</div>
