<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Profile') }}
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font overflow-hidden px-7">
    <div class="container max-w-2xl px-8 md:px-16 py-16 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <form action="{{ route(Auth::user()->role === 'admin' ? 'admin.profile.update' : 'profile.update') }}" method="post">
        @csrf
        @method('put') <!-- formタグがPOSTでも、laravelがput methodとして認識できるようになる-->
        <div class="w-full mb-6 ">
          <div class="flex mb-6 items-center">
            <label for="name" class="leading-7 text-sm text-gray-600 w-1/3">ニックネーム</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" required
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
          </div>
          <div class="flex mb-6 items-center">
            <label for="email" class="leading-7 text-sm text-gray-600 w-1/3">メール</label>
            <input type="text" id="email" name="email" value="{{ $user->email }}" required
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
          </div>
          <div class="flex mb-6 items-center">
            <label for="name" class="leading-7 text-sm text-gray-600 w-1/3">都道府県</label>
            <select name="prefecture_id" id="prefecture_id"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              @foreach ($prefectures as $prefecture)
                <option value="{{ $prefecture->id }}" {{ $user->prefecture_id == $prefecture->id ? 'selected' : '' }}>
                  {{ $prefecture->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex mb-6 items-center">
            <label for="name" class="leading-7 text-sm text-gray-600 w-1/3">市区町村</label>
            <select name="city_id" id="city_id"
              class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              @foreach ($cities as $city)
                <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>
                  {{ $city->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="flex justify-between mx-auto">
            <button
              class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">更新</button>
            <button type="button" onclick="location.href='{{ route(Auth::user()->role === 'admin' ? 'admin.profile.show' : 'profile.show') }}'"
              class=" text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:opacity-80 rounded">キャンセル</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</x-app-layout>
