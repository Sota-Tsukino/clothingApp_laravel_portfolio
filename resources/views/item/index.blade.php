<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      衣類アイテム一覧
    </h2>
    <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index') }}"
      method="get" class="bg-white p-4 mt-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
          <label for="category" class="block text-sm font-medium text-gray-700">カテゴリー</label>
          <select name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="0" @if (request('category') === '0') selected @endif>全て</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" @if (request('category') == $category->id) selected @endif>
                {{ __("category.$category->name") }}
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">ステータス</label>
          <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">全て</option>
            <option value="owned" @selected(request('status') === 'owned')>所持中</option>
            <option value="cleaning" @selected(request('status') === 'cleaning')>クリーニング中</option>
            <option value="discarded" @selected(request('status') === 'discarded')>破棄済</option>
          </select>
        </div>

        <div>
          <label for="sort" class="block text-sm font-medium text-gray-700">表示順</label>
          <select name="sort" id="sort" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="{{ \Constant::SORT_ORDER['latestRegisterItem'] }}" @selected(empty(request('sort')))>
              登録日が新しい(デフォルト)</option>
            <option value="{{ \Constant::SORT_ORDER['oldRegisteredItem'] }}" @selected(request('sort') === \Constant::SORT_ORDER['oldRegisteredItem'])>登録日が古い
            </option>
            <option value="{{ \Constant::SORT_ORDER['newItem'] }}" @selected(request('sort') === \Constant::SORT_ORDER['newItem'])>購入日が新しい</option>
            <option value="{{ \Constant::SORT_ORDER['oldItem'] }}" @selected(request('sort') === \Constant::SORT_ORDER['oldItem'])>購入日が古い</option>
          </select>
        </div>

        <div>
          <label for="pagination" class="block text-sm font-medium text-gray-700">表示件数</label>
          <select id="pagination" name="pagination" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="" @selected(empty(request('pagination')))>12件(デフォルト)</option>
            <option value="16" @selected(request('pagination') === '16')>16件</option>
            <option value="20" @selected(request('pagination') === '20')>20件</option>
          </select>
        </div>
      </div>

      <div class="mt-4">
        <button
          class="bg-indigo-600 text-white font-medium py-2 px-4 rounded hover:bg-indigo-700 transition-colors duration-200 inline-flex items-center">
          <img src="{{ asset('images/icons/search.svg') }}" class="w-4 h-4" alt="検索アイコン">
          <span class="inline-block ml-2">この条件で検索</span>
        </button>
      </div>
    </form>
  </x-slot>

  <section class="text-gray-600 body-font">
    <div class="max-w-5xl px-4 py-8 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      @if ($items->count() > 0)
        <div class="text-sm text-gray-500 font-semibold mb-4">
          総衣類アイテム数: {{ $items->total() ?? 0 }}件
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-4 mb-4">
          @foreach ($items as $item)
            <x-item-card :item="$item" />
          @endforeach
        </div>
      @elseif (request()->hasAny(['category', 'status', 'sort', 'pagination']))
        <p class="text-xl text-gray-700">検索条件に一致するアイテムは見つかりませんでした。</p>
      @else
        <p class="text-xl text-gray-700">衣類アイテムが登録されていません。</p>
      @endif
      {{ $items->links() }}
      <button
        onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.clothing-item.create' : 'clothing-item.create') }}'"
        class="inline-block px-4 py-2 bg-green-600 rounded-md font-semibold text-sm text-white hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 mt-4">新規登録</button>
    </div>
  </section>
</x-app-layout>
