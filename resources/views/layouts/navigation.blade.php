<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="transition hover:opacity-80">
                    <x-application-logo class="h-9 w-auto text-gray-800 dark:text-white" />
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-unimasblue dark:hover:text-unimasblue transition-all duration-200">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('user.events')" :active="request()->routeIs('user.events')" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-unimasblue dark:hover:text-unimasblue transition-all duration-200">
                    {{ __('Event') }}
                </x-nav-link>
                <x-nav-link :href="route('user.events.my-bookings')" :active="request()->routeIs('user.events.my-bookings')" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-unimasblue dark:hover:text-unimasblue transition-all duration-200">
                    {{ __('My Bookings') }}
                </x-nav-link>
            </div>

            <!-- User Dropdown -->
            <div class="hidden lg:flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-unimasblue dark:hover:text-unimasblue transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 w-4 h-4 transition-transform duration-300 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Toggle Button -->
            <div class="lg:hidden flex items-center">
                <button @click="open = !open" class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-unimasblue transition">
                    <svg x-show="!open" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu with animation -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-y-95" x-transition:enter-end="opacity-100 scale-y-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-y-100" x-transition:leave-end="opacity-0 scale-y-95"
         class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 origin-top overflow-hidden">
        <div class="space-y-1 px-4 py-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('user.events')" :active="request()->routeIs('user.events')">{{ __('Event') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('user.events.my-bookings')" :active="request()->routeIs('user.events.my-bookings')">{{ __('My Bookings') }}</x-responsive-nav-link>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4">
            <div class="text-sm text-gray-600 dark:text-gray-300 font-medium mb-2">{{ Auth::user()->name }}</div>
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
