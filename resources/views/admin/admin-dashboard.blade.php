<!-- resources/views/admin/admin-dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- ... (keep existing stats cards unchanged) ... -->
            </div>

            <!-- Quick Access Panels -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- ... (keep recent events and registrations sections) ... -->
            </div>

            <!-- Management Section -->
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Management</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.users') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Manage Users</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">View, edit, and manage user accounts</p>
                    </div>
                </a>

                <a href="{{ route('admin.events') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">Manage Events</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Approve or reject pending events</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
