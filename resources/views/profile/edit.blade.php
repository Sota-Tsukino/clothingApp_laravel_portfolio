<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Profile') }}編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-4 md:px-8">
    <div class="max-w-xl px-8 sm:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.profile.update' : 'profile.update') }}"
        method="post">
        @csrf
        @method('put') <!-- formタグがPOSTでも、laravelがput methodとして認識できるようになる-->
        <div class="mb-6 ">
          <div class="mb-4">
            <label for="nickname" class="block text-sm font-medium text-gray-700 mb-1">ニックネーム</label>
            <input type="text" id="nickname" name="nickname" value="{{ $user->nickname }}" required
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">メール</label>
            <input type="text" id="email" name="email" value="{{ $user->email }}" required
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
          </div>
          <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">性別</label>
            <select name="gender" id="gender"
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
              <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>
                {{ __('user.male') }}
              </option>
              <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>
                {{ __('user.female') }}
              </option>
              <option value="prefer_not_to_say" {{ $user->gender == 'prefer_not_to_say' ? 'selected' : '' }}>
                {{ __('user.prefer_not_to_say') }}
              </option>
            </select>
          </div>
          <div>
            <div class="mb-4">
              <label for="prefecture_id" class="block text-sm font-medium text-gray-700 mb-1">都道府県</label>
              <select name="prefecture_id" id="prefecture_id"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                <option value="" {{ $user->prefecture_id === null ? 'selected' : '' }}>都道府県を選択してください</option>
                @foreach ($prefectures as $prefecture)
                  <option value="{{ $prefecture->id }}"
                    {{ $user->prefecture_id == $prefecture->id ? 'selected' : '' }}>
                    {{ $prefecture->name }}
                  </option>
                @endforeach
              </select>
              <p class="mt-1 text-xs text-gray-500">※一都三県から選択可能</p>
            </div>
          </div>
          <div class="mb-4">
            <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">市区町村</label>
            <select name="city_id" id="city_id"
              class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
              <option value="" {{ $user->city_id === null ? 'selected' : '' }}>市区町村を選択してください</option>
              @foreach ($prefectures as $prefecture)
                @foreach ($prefecture->city as $city)
                  <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                  </option>
                @endforeach
              @endforeach
            </select>
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
<div id="prefecture-city-list" data-prefectures='@json($prefectures)' data-user='@json($user)'>
</div>
