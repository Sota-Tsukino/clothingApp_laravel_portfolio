<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      ユーザー一覧
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font">
    <div class="container px-5 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <x-flash-message status="session('status')" />
      <div class="lg:w-2/3 w-full mx-auto overflow-auto">
        <table class="table-auto w-full text-left whitespace-no-wrap">
          <thead>
            <tr>
              <th class="title-font font-medium text-gray-900 text-sm bg-gray-100">
                氏名</th>
              <th class="title-font font-medium text-gray-900 text-sm bg-gray-100">メール</th>
              <th class="title-font font-medium text-gray-900 text-sm bg-gray-100">都道府県</th>
              <th class="title-font font-medium text-gray-900 text-sm bg-gray-100">市区町村</th>
              <th class="title-font font-medium text-gray-900 text-sm bg-gray-100">ステータス</th>
              <th class="title-font font-medium text-gray-900 text-sm bg-gray-100">操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td class="text-center px-4 py-3">{{ $user->name }}</td>
                <td class="text-center px-4 py-3">{{ $user->email }}</td>
                <td class="text-center px-4 py-3">{{ $user->prefecture->name }}</td>
                <td class="text-center px-4 py-3">{{ $user->city->name }}</td>
                <td class="text-center px-4 py-3">{{ $user->is_active ? '有効' : '無効' }}</td>
                <td class="text-center px-4 py-3">
                <form action="{{ route('admin.user.update', ['user' => $user->id ])}}" method="post" class="inline">
                    @csrf
                    @method('put')
                    @if ($user->is_active === 1)
                        <button
                            class="text-white bg-gray-500 border-0 py-2 px-3 focus:outline-none hover:bg-red-300 rounded">無効にする</button>
                    @else
                        <button
                            class="text-white bg-green-500 border-0 py-2 px-3 focus:outline-none hover:bg-red-300 rounded">有効にする</button>
                    @endif
                    <input type="hidden" name="is_active" value="{{ $user->is_active }}">
                </form>
                <form action="{{ route('admin.user.destroy', ['user' => $user->id ])}}" method="post" class="inline">
                    @csrf
                    @method('delete')
                    <button
                        class="text-white bg-red-500 border-0 py-2 px-3 focus:outline-none hover:bg-red-300 rounded">削除</button>
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
