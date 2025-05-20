@props(['coordinate'])

<div class="w-1/2 sm:w-1/3 md:w-1/4 p-2">
  <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.show' : 'coordinate.show', ['coordinate' => $coordinate->id]) }}"
    class="block bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-200">

    <!-- 画像 -->
    <div class="w-full flex justify-between overflow-hidden">
      <div class="main w-1/3 text-center">
        <span class="block mb-2 text-gray-700">メイン</span>
        <div class="w-2/3 mx-auto h-20">
          @if (isset($coordinate->items[0]))
            <img src="{{ asset('storage/items/' . $coordinate->items[0]->image->file_name) }}" alt="衣類画像"
              class="mt-4 max-w-xs rounded shadow w-full">
          @endif
        </div>
      </div>
      <div class="sub1 w-1/3 text-center">
        <span class="block mb-2 text-gray-700">サブ1</span>
        <div class="w-2/3 mx-auto h-20">
          @if (isset($coordinate->items[1]))
            <img src="{{ asset('storage/items/' . $coordinate->items[1]->image->file_name) }}" alt="衣類画像"
              class="mt-4 max-w-xs rounded shadow w-full">
          @endif
        </div>
      </div>
      <div class="sub2 w-1/3 text-center">
        <span class="block mb-2 text-gray-700">サブ2</span>
        <div class="w-2/3 mx-auto h-20">
          @if (isset($coordinate->items[2]))
            <img src="{{ asset('storage/items/' . $coordinate->items[2]->image->file_name) }}" alt="衣類画像"
              class="mt-4 max-w-xs rounded shadow w-full">
          @else
            <p>未登録</p>
          @endif
        </div>
      </div>
    </div>

    <!-- 情報 -->
    <div class="p-3 text-sm text-gray-800 space-y-1">
      <div class="text-md sm:text-lg text-gray-600">シーンタグ：{{ __("sceneTag.{$coordinate->sceneTag->name}") }}</div>
      <div class="text-sm sm:text-md text-gray-500">コーデを：{{ $coordinate->is_public ? '公開する' : '非公開' }}</div>
      <div class="text-sm sm:text-md text-gray-500">お気に入り：{{ $coordinate->is_favorite ? '登録済み' : '未登録' }}</div>
      <div class="text-md text-gray-600">登録日：{{ $coordinate->created_at->format('Y/m/d') }}</div>
    </div>
  </a>
</div>
