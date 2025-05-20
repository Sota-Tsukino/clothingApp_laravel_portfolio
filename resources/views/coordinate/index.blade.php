<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      コーデ一覧
    </h2>
    <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.coordinate.index' : 'coordinate.index') }}"
      method="get" class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
          <label for="is_favorite" class="block text-sm font-medium text-gray-700">お気に入り</label>
          <select name="is_favorite" id="is_favorite" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="" @if (request('is_favorite') === null) selected @endif>全て</option>
            <option value="0" @if (request('is_favorite') === '0') selected @endif>
              非お気に入り
            </option>
            <option value="1" @if (request('is_favorite') === '1') selected @endif>
              お気に入り
            </option>

          </select>
        </div>
        <div>
          <label for="sort" class="block text-sm font-medium text-gray-700">表示順</label>
          <select name="sort" id="sort" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="{{ \Constant::SORT_ORDER['latestRegisterItem'] }}" @selected(empty(request('sort')))>
              登録日が新しい(デフォルト)</option>
            <option value="{{ \Constant::SORT_ORDER['oldRegisteredItem'] }}" @selected(request('sort') === \Constant::SORT_ORDER['oldRegisteredItem'])>登録日が古い
            </option>
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

      <div>
        <button class="mt-4 bg-indigo-600 text-white font-semibold py-2 px-6 rounded hover:bg-indigo-700 transition">
          この条件で検索
        </button>
      </div>
    </form>
  </x-slot>

  <section class="text-gray-600 body-font">
    <div class="container px-5 py-8 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <div class="lg:w-full w-full mx-auto mb-6">
        <div class="flex flex-wrap -m-2">
          @if ($coordinates->count() > 0)
            @foreach ($coordinates as $coordinate)
              <x-coordinate-card :coordinate="$coordinate" />
            @endforeach
          @else
            <p class="text-xl text-gray-700">コーデが登録されていません。</p>
          @endif
        </div>
      </div>
      {{ $coordinates->links() }}
    </div>
  </section>
</x-app-layout>
