<div class="w-1/2 sm:w-1/3 md:w-1/4 p-2">
  <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-200 cursor-pointer" onclick="selectItem({{ $item->id }}, '{{ asset('storage/items/' . $item->image->file_name) }}')">
    <div class="w-full h-52 overflow-hidden">
      <img src="{{ asset('storage/items/' . $item->image->file_name) }}" alt="衣類画像" class="w-full h-full object-cover">
    </div>
    <div class="p-3 text-sm text-gray-800 space-y-1">
      <div class="text-md sm:text-lg text-gray-600">{{ $item->brand->name }} / {{ __("status.$item->status") }}</div>
      <div class="text-sm sm:text-md text-gray-500">
        {{ $item->category->name ? __("category.{$item->category->name}") : '' }}{{ isset($item->subcategory) ? ' / ' . __("subcategory.{$item->subcategory->name}") : '' }}
      </div>
      <div class="text-md text-gray-600">
        購入日：{{ $item->purchased_date ? \Carbon\Carbon::parse($item->purchased_date)->format('Y/m/d') : '未登録' }}</div>
      <div class="text-md text-gray-600">登録日：{{ $item->created_at->format('Y/m/d') }}</div>
    </div>
  </div>
</div>
