<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Password') }}編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-4 md:px-8">
    <div class="max-w-xl px-8 sm:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.profile.update-password' : 'profile.update-password') }}"
        method="post">
        @csrf
        @method('put')
        <div class="mb-6 ">
          <div class="mb-4">
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">現在のパスワード</label>
            <input type="password" id="current_password" name="current_password" required
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
          </div>
          <div class="mb-4">
            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">新しいパスワード</label>
            <input type="password" id="new_password" name="new_password" required
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
          </div>
          <div class="mb-4">
            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">新しいパスワードの確認</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
          </div>
          <div class="pt-6">
            <div class="flex flex-col sm:flex-row gap-3 justify-around">
              <button
                class="inline-block px-4 py-2 bg-indigo-600 rounded-md font-semibold text-sm text-white hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">更新する</button>
              <button type="button"
                onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.profile.show' : 'profile.show') }}'"
                class="inline-block px-4 py-2 bg-red-600 rounded-md font-semibold text-sm text-white hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">キャンセル</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</x-app-layout>
