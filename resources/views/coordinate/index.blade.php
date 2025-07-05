<x-app-layout>
  <x-slot name="header">
    <div class="space-y-4">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        コーデ一覧
      </h2>

      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.index' : 'coordinate.index') }}"
        method="get" class="bg-white p-4 mt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <!-- お気に入り -->
          <div>
            <label for="is_favorite" class="block text-sm font-medium text-gray-700 mb-1">お気に入り</label>
            <select name="is_favorite" id="is_favorite"
              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
              <option value="" @if (request('is_favorite') === null) selected @endif>全て</option>
              <option value="0" @if (request('is_favorite') === '0') selected @endif>非お気に入り</option>
              <option value="1" @if (request('is_favorite') === '1') selected @endif>お気に入り</option>
            </select>
          </div>

          <!-- 表示順 -->
          <div>
            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">表示順</label>
            <select name="sort" id="sort"
              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
              <option value="{{ \Constant::SORT_ORDER['latestRegisterItem'] }}" @selected(empty(request('sort')))>
                登録日が新しい(デフォルト)
              </option>
              <option value="{{ \Constant::SORT_ORDER['oldRegisteredItem'] }}" @selected(request('sort') === \Constant::SORT_ORDER['oldRegisteredItem'])>
                登録日が古い
              </option>
            </select>
          </div>

          <!-- 表示件数 -->
          <div>
            <label for="pagination" class="block text-sm font-medium text-gray-700 mb-1">表示件数</label>
            <select id="pagination" name="pagination"
              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
    </div>
  </x-slot>

  <section class="text-gray-600 body-font">
    <div
      class="container px-4 sm:px-5 py-6 sm:py-8 mx-auto bg-white rounded-lg my-6 sm:my-12 md:my-16 lg:my-24 shadow-lg">
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      @if ($coordinates->count() > 0)
        <div class="text-sm text-gray-500 font-semibold mb-4">
          総コーデ数: {{ $coordinates->total() ?? 0 }}件
        </div>
        <div class="w-full mx-auto mb-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
            @foreach ($coordinates as $coordinate)
              <x-coordinate-card :coordinate="$coordinate" />
            @endforeach
          </div>
        </div>
      @else
        <p class="w-full text-xl text-gray-700 py-16 text-center">コーデが登録されていません。</p>
      @endif

      <div class="mt-8">
        {{ $coordinates->links() }}
      </div>
      <button
        onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.create' : 'coordinate.create') }}'"
        class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">新規登録</button>
    </div>
  </section>
</x-app-layout>
