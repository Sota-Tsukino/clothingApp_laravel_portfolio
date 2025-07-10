@props(['item', 'showStatus' => true])

<div class="border bg-gray-100 rounded-lg">
  <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.show' : 'clothing-item.show', ['clothing_item' => $item->id]) }}"
    class="block rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-200">

    <!-- 画像 -->
    <div class="w-full h-52 overflow-hidden">
      <img src="{{ asset('storage/items/' . $item->image->file_name) }}" alt="衣類画像" class="w-full h-full object-cover">
    </div>
  </a>

  <!-- 情報 -->
  <div class="p-3 text-sm text-gray-800 space-y-1">
    <div class="flex justify-between items-center">
      <div class="text-sm lg:text-base text-gray-600 truncate whitespace-nowrap"
        title="{{ __("brand.{$item->brand->name}") }}">{{ __("brand.{$item->brand->name}") }}</div>
      @if ($showStatus)
        @if ($item->status !== 'discarded')
          <form method="post"
            action="{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.switchStatus' : 'clothing-item.switchStatus', ['clothing_item' => $item->id]) }}"
            class="inline-block">
            @csrf
            @method('put')
            <button type="submit" class="inline-block bg-transparent border-none p-0 w-8 h-8">
              @if ($item->status === 'owned')
                <img src="{{ asset('images/icons/owned.svg') }}" class="w-full " alt="所持中アイコン">
              @elseif ($item->status === 'cleaning')
                <img src="{{ asset('images/icons/cleaning.svg') }}" class="w-full " alt="クリーニング中アイコン">
              @endif
            </button>
            <input type="hidden" name="status" value="{{ $item->status }}">
          </form>
        @else
          <div class="w-8 h-8">
            <img src="{{ asset('images/icons/discarded.svg') }}" class="w-full " alt="破棄済みアイコン">
          </div>
        @endif
      @endif
    </div>
    <div class="text-sm lg:text-base text-gray-600">
      {{ $item->category->name ? __("category.{$item->category->name}") : '' }}
    </div>
    <div class="text-sm lg:text-base text-gray-500 truncate whitespace-nowrap"
      title="{{ __("subcategory.{$item->subcategory->name}") }}">
      {{ isset($item->subcategory) ? __("subcategory.{$item->subcategory->name}") : '' }}
    </div>
    <div class="text-sm text-gray-600">
      購入日：{{ $item->purchased_date ? \Carbon\Carbon::parse($item->purchased_date)->format('Y/m/d') : '未登録' }}</div>
    <div class="text-sm text-gray-600">登録日：{{ $item->created_at->format('Y/m/d') }}</div>
  </div>
</div>
