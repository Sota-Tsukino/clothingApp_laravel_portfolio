<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      ユーザー一覧
    </h2>
    <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.user.index' : 'user.index') }}" method="get"
      class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
          <label for="is_active" class="block text-sm font-medium text-gray-700">ステータス</label>
          <select name="is_active" id="is_active" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">全て</option>
            <option value="1" @selected(request('is_active') === '1')>有効</option>
            <option value="0" @selected(request('is_active') === '0')>無効</option>
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

  <section class="text-gray-600 body-font overflow-hidden px-4 sm:px-8">
    <div class="max-w-4xl px-4 py-4 sm:px-8 sm:py-8 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      @if ($users->count() > 0)
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 mb-6">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">登録日</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">ニックネーム</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">メール</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">性別</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">都道府県</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">市区町村</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">ステータス</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">操作</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($users as $user)
                <tr class="hover:bg-gray-50">
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">
                    {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('Y/m/d') : '未登録' }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ $user->nickname }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ $user->email }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ __("user.$user->gender") }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ $user->prefecture->name }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ $user->city->name }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">
                    <span
                      class="inline-flex text-sm font-semibold px-2 py-1 rounded-full {{ $user->is_active ? ' text-green-600 bg-green-50' : 'text-gray-600 bg-gray-50' }}">{{ $user->is_active ? '有効' : '無効' }}</span>
                  </td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">
                    <form id="toggle_{{ $user->id }}"
                      action="{{ route('admin.user.update', ['user' => $user->id]) }}" method="post" class="inline">
                      @csrf
                      @method('put')
                      @if ($user->is_active === 1)
                        <button type="button" onclick="toggleIsActive(this)" data-id="{{ $user->id }}"
                          class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">無効にする</button>
                      @else
                        <button type="button" onclick="toggleIsActive(this)" data-id="{{ $user->id }}"
                          class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">有効にする</button>
                      @endif
                      <input type="hidden" name="is_active" value="{{ $user->is_active }}">
                    </form>
                    <form id="delete_{{ $user->id }}"
                      action="{{ route('admin.user.destroy', ['user' => $user->id]) }}" method="post" class="inline">
                      @csrf
                      @method('delete')
                      <button type="button" onclick="deleteUser(this)" data-id="{{ $user->id }}"
                        class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">削除</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        @if (request()->hasAny(['is_active', 'sort', 'pagination']))
          <p class="text-xl text-gray-700">検索条件に一致するユーザーは見つかりませんでした。</p>
        @else
          <p class="text-xl text-gray-700">ユーザーが登録されていません。</p>
        @endif
      @endif

      {{ $users->links() }}
    </div>
  </section>


</x-app-layout>
<script>
  function deleteUser(e) {
    'use strict';
    if (confirm('本当に削除してもいいですか?')) {
      document.getElementById('delete_' + e.dataset.id).submit();
    }
  }

  function toggleIsActive(e) {
    'use strict';
    if (confirm('このユーザーのステータスを切り替えますか?')) {
      document.getElementById('toggle_' + e.dataset.id).submit();
    }
  }
</script>
