<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-8 sm:px-12 lg:px-20">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.home' : 'home') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex">
                <x-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.profile.show' : 'profile.show')">
                    <div class="w-8 mx-auto">
                        <img src="{{ asset('images/icons/Profile.svg') }}" alt="プロフィールアイコン" class="w-full">
                    </div>
                    <p class="menu__text text-[12px]">プロフィール</p>
                </x-nav-link>
                <x-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')">
                    <div class="w-8 mx-auto">
                        <img src="{{ asset('images/icons/BodyMeasurement.svg') }}" alt="体格情報アイコン" class="w-full">
                    </div>
                    <p class="menu__text text-[12px]">体格情報</p>
                </x-nav-link>
                <x-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index')">
                    <div class="w-8 mx-auto">
                        <img src="{{ asset('images/icons/ClothingItems.svg') }}" alt="衣類一覧アイコン" class="w-full">
                    </div>
                    <p class="menu__text text-[12px]">衣類一覧</p>
                </x-nav-link>
                <x-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.sizechecker.index' : 'sizechecker.index')">
                    <div class="w-8 mx-auto">
                        <img src="{{ asset('images/icons/SizeChecker.svg') }}" alt="サイズチェッカーアイコン" class="w-full">
                    </div>
                    <p class="menu__text text-[12px]">サイズチェッカー</p>
                </x-nav-link>
                <x-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.coordinate.index' : 'coordinate.index')">
                    <div class="w-8 mx-auto">
                        <img src="{{ asset('images/icons/Coordinate.svg') }}" alt="コーデ一覧アイコン" class="w-full">
                    </div>
                    <p class="menu__text text-[12px]">コーデ一覧</p>
                </x-nav-link>
                @if (Auth::user()->role === 'admin')
                    <x-nav-link
                        :href="route('admin.user.index')">
                    <div class="w-8 mx-auto">
                        <img src="{{ asset('images/icons/admin.svg') }}" alt="ユーザー一覧アイコン" class="w-full">
                    </div>
                    <p class="menu__text text-[12px]">ユーザー一覧</p>
                    </x-nav-link>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                    @csrf
                    <button type="submit" class="">
                        <div class="w-8 mx-auto">
                            <img src="{{ asset('images/icons/logout.svg') }}" alt="ログアウトアイコン" class="w-full">
                        </div>
                        <p class="menu__text text-[12px]">{{ __('Log Out') }}</p>
                    </button>
                </form>

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-8 sm:px-12">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->nickname }}さん</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-8 sm:px-12">
                <x-responsive-nav-link :href="route(Auth::user()->role === 'admin' ? 'admin.profile.show' : 'profile.show')">
                    <div class="flex item-center">
                        <div class="w-8">
                            <img src="{{ asset('images/icons/Profile.svg') }}" alt="プロフィールアイコン" class="w-full">
                        </div>
                        <p class="leading-8 ml-2">{{ __('Profile') }}</p>
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')">
                    <div class="flex item-center">
                        <div class="w-8">
                            <img src="{{ asset('images/icons/BodyMeasurement.svg') }}" alt="体格情報アイコン" class="w-full">
                        </div>
                        <p class="leading-8 ml-2">体格情報一覧</p>
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.sizechecker.index' : 'sizechecker.index')">
                    <div class="flex item-center">
                        <div class="w-8">
                            <img src="{{ asset('images/icons/SizeChecker.svg') }}" alt="サイズチェッカーアイコン" class="w-full">
                        </div>
                        <p class="leading-8 ml-2">サイズチェッカー</p>
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index')">
                    <div class="flex item-center">
                        <div class="w-8">
                            <img src="{{ asset('images/icons/ClothingItems.svg') }}" alt="衣類一覧アイコン" class="w-full">
                        </div>
                        <p class="leading-8 ml-2">衣類一覧</p>
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route(Auth::user()->role === 'admin' ? 'admin.coordinate.index' : 'coordinate.index')">
                    <div class="flex item-center">
                        <div class="w-8">
                            <img src="{{ asset('images/icons/Coordinate.svg') }}" alt="コーデ一覧アイコン" class="w-full">
                        </div>
                        <p class="leading-8 ml-2">コーデ一覧</p>
                    </div>
                </x-responsive-nav-link>
                @if (Auth::user()->role === 'admin')
                    <x-responsive-nav-link
                        :href="route('admin.user.index')">
                        <div class="flex item-center">
                            <div class="w-8">
                                <img src="{{ asset('images/icons/admin.svg') }}" alt="ユーザー一覧アイコン" class="w-full">
                            </div>
                            <p class="leading-8 ml-2">ユーザー一覧</p>
                        </div>
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <div class="flex item-center">
                            <div class="w-8">
                                <img src="{{ asset('images/icons/logout.svg') }}" alt="ログアウトアイコン" class="w-full">
                            </div>
                            <p class="leading-8 ml-2">{{ __('Log Out') }}</p>
                        </div>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
