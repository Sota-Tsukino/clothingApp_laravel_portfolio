<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Profile') }}編集
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.profile.update' : 'profile.update') }}"
        method="post">
        @csrf
        @method('put') <!-- formタグがPOSTでも、laravelがput methodとして認識できるようになる-->
        <div class="w-full mb-6 ">
          <div class="flex mb-6 items-center">
            <label for="nickname" class="leading-7 text-sm text-gray-600 w-1/3">ニックネーム</label>
            <input type="text" id="nickname" name="nickname" value="{{ $user->nickname }}" required
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
          </div>
          <div class="flex mb-6 items-center">
            <label for="email" class="leading-7 text-sm text-gray-600 w-1/3">メール</label>
            <input type="text" id="email" name="email" value="{{ $user->email }}" required
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
          </div>
          <div class="flex mb-6 items-center">
            <label for="gender" class="leading-7 text-sm text-gray-600 w-1/3">性別</label>
            <select name="gender" id="gender"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
          <div class="flex mb-6 items-center">
            <label for="prefecture_id" class="leading-7 text-sm text-gray-600 w-1/3">都道府県</label>
            <select name="prefecture_id" id="prefecture_id"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              <option value="" {{ $user->prefecture_id === null ? 'selected' : '' }}>都道府県を選択してください</option>
              @foreach ($prefectures as $prefecture)
                <option value="{{ $prefecture->id }}" {{ $user->prefecture_id == $prefecture->id ? 'selected' : '' }}>
                  {{ $prefecture->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="city_id" class="leading-7 text-sm text-gray-600 w-1/3">市区町村</label>
            <select name="city_id" id="city_id"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
          <div class="flex justify-between mx-auto">
            <button
              class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">更新</button>
            <button type="button"
              onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.profile.show' : 'profile.show') }}'"
              class=" text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">キャンセル</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</x-app-layout>
<div id="prefecture-city-list" data-prefectures='@json($prefectures)' data-user='@json($user)'>
</div>
