<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      衣類アイテム一覧
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font">
    <div class="container px-5 py-8 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <div class="lg:w-full w-full mx-auto">
        <div class="flex flex-wrap -m-2">
          @if (count($items) > 0)
            @foreach ($items as $item)
              <div class="w-1/2 sm:w-1/3 md:w-1/4 p-2">
                <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.show' : 'clothing-item.show', ['clothing_item' => $item->id]) }}"
                  class="block bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition-shadow duration-200">

                  <!-- 画像 -->
                  <div class="w-full h-52 overflow-hidden">
                    <img src="{{ asset('storage/items/' . $item->image->file_name) }}" alt="衣類画像"
                      class="w-full h-full object-cover">
                  </div>

                  <!-- 情報 -->
                  <div class="p-3 text-sm text-gray-800 space-y-1">
                    <div class="text-xs text-gray-600">{{ $item->brand->name }} / {{ __("status.$item->status") }}</div>
                    <div class="text-xs text-gray-500">
                      {{ $item->category->name ? __("category.{$item->category->name}") : '' }}{{ isset($item->subcategory) ? ' / ' . __("subcategory.{$item->subcategory->name}") : '' }}
                    </div>
                    <div class="text-xs text-gray-400">{{ $item->created_at->format('Y/m/d') }}</div>
                  </div>
                </a>
              </div>
            @endforeach
          @else
          <p class="text-2xl font-semibold">衣類アイテムが登録されていません</p>
          @endif
        </div>
      </div>
    </div>
  </section>
</x-app-layout>
