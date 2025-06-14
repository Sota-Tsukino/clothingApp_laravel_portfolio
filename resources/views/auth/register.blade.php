<x-guest-layout>
  <!-- Validation Errors -->
  <x-auth-validation-errors class="mb-4" :errors="$errors" />
  <x-flash-message status="session('status')" />
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div>
      <x-input-label for="nickname" :value="__('NickName')" />
      <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')" required
        autofocus autocomplete="nickname" />
      <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
        autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" />

      <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
        autocomplete="new-password" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4 mb-4">
      <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

      <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
        required autocomplete="new-password" />

      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex mb-6 items-center">
      <label for="gender" class="leading-7 font-semibold text-sm text-gray-600 w-1/3">性別</label>
      <select name="gender" id="gender"
        class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
          {{ __('user.male') }}
        </option>
        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
          {{ __('user.female') }}
        </option>
        <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>
          {{ __('user.prefer_not_to_say') }}
        </option>
      </select>
    </div>
    <div class="flex mb-6 items-center">
      <label for="name" class="leading-7 font-semibold text-sm text-gray-600 w-1/3">都道府県</label>
      <select name="prefecture_id" id="prefecture_id"
        class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        <option value="">都道府県を選択してください</option>
        @foreach ($prefectures as $prefecture)
          <option value="{{ $prefecture->id }}" {{ old('prefecture_id') == $prefecture->id ? 'selected' : '' }}>
            {{ $prefecture->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="flex mb-6 items-center">
      <label for="name" class="leading-7 font-semibold text-sm text-gray-600 w-1/3">市区町村</label>
      <select name="city_id" id="city_id"
        class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        <option value="">市区町村を選択してください</option>
        @foreach ($prefectures as $prefecture)
          @foreach ($prefecture->city as $city)
            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
              {{ $city->name }}
            </option>
          @endforeach
        @endforeach
      </select>
    </div>

    <div class="flex items-center justify-end mt-4">
      <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        href="{{ route('login') }}">
        {{ __('Already registered?') }}
      </a>

      <x-primary-button class="ms-4">
        {{ __('Register') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
<div id="prefecture-city-list" data-prefectures='@json($prefectures)'></div>
