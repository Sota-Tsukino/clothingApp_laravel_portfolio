<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
      削除済みユーザー一覧
    </h2>
    <form action="{{ route('admin.softDeleted-user.index') }}" method="get" class="space-y-4">
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
      @if ($softDeletedUsers->count() > 0)
        <div class="text-sm text-gray-500 font-semibold mb-4">
          総ユーザー数: {{ $softDeletedUsers->total() ?? 0 }}件
        </div>
        <!-- PC・タブレット向けテーブル表示 (md以上のサイズで表示) -->
        <div class="hidden md:block overflow-x-auto bg-white rounded-lg border border-gray-200 mb-6">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">削除日</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">ニックネーム</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">メール</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">性別</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">都道府県</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">市区町村</th>
                <th class="px-3 py-2 text-left  text-sm font-semibold text-gray-500 whitespace-nowrap">操作</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($softDeletedUsers as $user)
                <tr class="hover:bg-gray-50">
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">
                    {{ $user->deleted_at ? \Carbon\Carbon::parse($user->deleted_at)->format('Y/m/d') : '未登録' }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ $user->nickname }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ $user->email }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ __("user.$user->gender") }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ $user->prefecture->name }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">{{ $user->city->name }}</td>
                  <td class="px-3 py-2 text-sm whitespace-nowrap ">
                    <form id="toggle_{{ $user->id }}"
                      action="{{ route('admin.softDeleted-user.restore', ['user' => $user->id]) }}" method="post"
                      class="inline">
                      @csrf
                      @method('put')
                      <button type="button" onclick="restoreUser(this)" data-id="{{ $user->id }}"
                        class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">復元する</button>
                    </form>
                    <form id="delete_{{ $user->id }}"
                      action="{{ route('admin.softDeleted-user.destroy', ['user' => $user->id]) }}" method="post"
                      class="inline">
                      @csrf
                      @method('delete')
                      <button type="button" onclick="deleteUser(this)" data-id="{{ $user->id }}"
                        class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">完全削除する</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- スマホ向けカード表示 (md未満のサイズで表示) -->
        <div class="md:hidden space-y-4 mb-6">
          @foreach ($softDeletedUsers as $user)
            <div class="border rounded-lg p-4 shadow-sm hover:shadow transition">
              <div class="mb-3 pb-2 border-b">
                <div class="font-medium">削除日: <span
                    class="font-normal">{{ \Carbon\Carbon::parse($user->deleted_at)->format('Y/m/d') }}</span>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-2 mb-4">
                <div class="text-sm">
                  <span class="font-medium">ニックネーム: </span>
                  <span>{{ $user->nickname ?? '未登録' }}</span>
                </div>
                <div class="text-sm">
                  <span class="font-medium">メール: </span>
                  <span>{{ $user->email ?? '未登録' }}</span>
                </div>
                <div class="text-sm">
                  <span class="font-medium">性別: </span>
                  <span>{{ __("user.$user->gender") }}</span>
                </div>
                <div class="text-sm">
                  <span class="font-medium">都道府県: </span>
                  <span>{{ $user->prefecture->name ?? '未登録' }}</span>
                </div>
                <div class="text-sm">
                  <span class="font-medium">市区町村: </span>
                  <span>{{ $user->city->name ?? '未登録' }}</span>
                </div>
              </div>
              <div class="flex space-x-2">
                <form id="restore_{{ $user->id }}"
                  action="{{ route('admin.softDeleted-user.restore', ['user' => $user->id]) }}" method="post"
                  class="inline-block w-1/2">
                  @csrf
                  @method('put')
                  <button type="button" onclick="restoreUser(this)" data-id="{{ $user->id }}"
                    class="w-full text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">復元する</button>
                </form>
                <form id="delete_{{ $user->id }}"
                  action="{{ route('admin.softDeleted-user.destroy', ['user' => $user->id]) }}" method="post"
                  class="inline-block w-1/2">
                  @csrf
                  @method('delete')
                  <button type="button" onclick="deleteUser(this)" data-id="{{ $user->id }}"
                    class="w-full text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">完全削除する</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @else
        @if (request()->hasAny(['is_active', 'sort', 'pagination']))
          <p class="text-xl text-gray-700">検索条件に一致するユーザーは見つかりませんでした。</p>
        @else
          <p class="text-xl text-gray-700">削除済みユーザーはありません。</p>
        @endif
      @endif

      {{ $softDeletedUsers->links() }}
      <div class="mt-8 flex justify-center md:justify-start">
        <button onclick="location.href='{{ route('admin.user.index') }}'"
          class="inline-block px-4 py-2 bg-green-600 rounded-md font-semibold text-sm text-white hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">ユーザー一覧へ</button>
      </div>
    </div>
  </section>


</x-app-layout>
<script>
  function restoreUser(e) {
    'use strict';
    if (confirm('このユーザーを復元します。よろしいですか？')) {
      document.getElementById('restore_' + e.dataset.id).submit();
    }
  }

  function deleteUser(e) {
    'use strict';
    if (confirm('このユーザーを完全削除します。よろしいですか？')) {
      document.getElementById('delete_' + e.dataset.id).submit();
    }
  }
</script>
