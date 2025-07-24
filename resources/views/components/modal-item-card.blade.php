  <div
    class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-200 cursor-pointer"
    onclick="selectItem({{ $item->id }}, '{{ Storage::disk('s3')->temporaryUrl('items/' . $item->image->file_name, now()->addMinutes(10)) }}')">
    <div class="w-full h-52 overflow-hidden">
      <img src="{{ Storage::disk('s3')->temporaryUrl('items/' . $item->image->file_name, now()->addMinutes(10)) }}" alt="衣類画像" class="w-full h-full object-cover">
    </div>
    <div class="p-3 text-sm text-gray-800 space-y-1">
      <div class="flex justify-between items-center">
        <!-- ブランド名 -->
        <div class="text-sm lg:text-base text-gray-600 truncate whitespace-nowrap"
          title="{{ __("brand.{$item->brand->name}") }}">{{ __("brand.{$item->brand->name}") }}</div>
        <!-- ステータスアイコン -->
        <div class="w-8 h-8 flex-shrink-0">
          @if ($item->status === 'owned')
            <img src="{{ asset('images/icons/owned.svg') }}" class="w-full " alt="所有中アイコン">
          @elseif($item->status === 'cleaning')
            <img src="{{ asset('images/icons/cleaning.svg') }}" class="w-full " alt="クリーニング中アイコン">
          @else
            <img src="{{ asset('images/icons/discarded.svg') }}" class="w-full " alt="破棄済みアイコン">
          @endif
        </div>
      </div>
      <div class="text-sm lg:text-base text-gray-600">
        {{ $item->category->name ? __("category.{$item->category->name}") : '' }}
      </div>
      <div class="text-sm sm:text-md text-gray-500 truncate whitespace-nowrap"
        title="{{ __("subcategory.{$item->subcategory->name}") }}">
        {{ isset($item->subcategory) ? __("subcategory.{$item->subcategory->name}") : '' }}
      </div>
      <div class="text-md text-gray-600">
        購入日：{{ $item->purchased_date ? \Carbon\Carbon::parse($item->purchased_date)->format('Y/m/d') : '未登録' }}</div>
      <div class="text-md text-gray-600">登録日：{{ $item->created_at->format('Y/m/d') }}</div>
    </div>
  </div>
