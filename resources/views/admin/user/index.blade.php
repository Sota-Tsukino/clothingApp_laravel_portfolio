<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      ユーザー一覧
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-4 sm:px-8">
    <div class="max-w-4xl px-4 py-4 sm:px-8 sm:py-8 mx-auto bg-white rounded-lg my-24 shadow-lg">
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <x-flash-message status="session('status')" />
      <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">ニックネーム</th>
              <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">メール</th>
              <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">都道府県</th>
              <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">市区町村</th>
              <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">ステータス</th>
              <th class="px-3 py-3 text-left  text-sm font-medium text-gray-500 whitespace-nowrap">操作</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($users as $user)
              <tr class="hover:bg-gray-50">
                <td class="px-3 py-3 text-sm whitespace-nowrap ">{{ $user->name }}</td>
                <td class="px-3 py-3 text-sm whitespace-nowrap ">{{ $user->email }}</td>
                <td class="px-3 py-3 text-sm whitespace-nowrap ">{{ $user->prefecture->name }}</td>
                <td class="px-3 py-3 text-sm whitespace-nowrap ">{{ $user->city->name }}</td>
                <td class="px-3 py-3 text-sm whitespace-nowrap ">{{ $user->is_active ? '有効' : '無効' }}</td>
                <td class="px-3 py-3 text-sm whitespace-nowrap ">
                <form action="{{ route('admin.user.update', ['user' => $user->id ])}}" method="post" class="inline">
                    @csrf
                    @method('put')
                    @if ($user->is_active === 1)
                        <button
                            class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">無効にする</button>
                    @else
                        <button
                            class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">有効にする</button>
                    @endif
                    <input type="hidden" name="is_active" value="{{ $user->is_active }}">
                </form>
                <form action="{{ route('admin.user.destroy', ['user' => $user->id ])}}" method="post" class="inline">
                    @csrf
                    @method('delete')
                    <button
                        class="text-center inline-block items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">削除</button>
                </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>


</x-app-layout>
