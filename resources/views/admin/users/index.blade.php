<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <!-- Header Section -->
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <div class="relative z-10 flex items-center justify-between">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">
                                Manage Users
                            </h1>
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                ← Back to Dashboard
                            </a>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-4 sm:p-6 md:p-8">
                        @if (session('success'))
                            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Search and Filters -->
                        <div class="mb-6 flex flex-col sm:flex-row justify-between gap-4">
                            <form method="GET" action="{{ route('admin.users') }}" class="flex-1">
                                <div class="flex gap-2">
                                    <input type="text" name="search" placeholder="Search users..."
                                        class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                        value="{{ request('search') }}">
                                    <button type="submit"
                                        class="px-4 py-2 bg-unimasblue hover:bg-blue-700 text-white rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                        Search
                                    </button>
                                </div>
                            </form>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users', ['role' => '']) }}"
                                    class="px-4 py-2 rounded-lg {{ empty(request('role')) ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                    All ({{ $totalCount }})
                                </a>
                                <a href="{{ route('admin.users', ['role' => 'user']) }}"
                                    class="px-4 py-2 rounded-lg {{ request('role') === 'user' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                    Users ({{ $regularUserCount }})
                                </a>
                                <a href="{{ route('admin.users', ['role' => 'organizer']) }}"
                                    class="px-4 py-2 rounded-lg {{ request('role') === 'organizer' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                    Organizers ({{ $organizerCount }})
                                </a>
                            </div>
                        </div>

                        @if ($users->isEmpty())
                            <!-- Empty State -->
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="text-gray-400 dark:text-gray-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">
                                    No users found
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    Try adjusting your search or filters
                                </p>
                            </div>
                        @else
                            <!-- Users Table -->
                            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                                    User</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase hidden md:table-cell">
                                                    Email</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                                    Role</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase hidden sm:table-cell">
                                                    Joined</th>
                                                <th
                                                    class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($users as $user)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                                    <!-- User Info -->
                                                    <td class="px-4 py-4">
                                                        <div class="flex items-center">
                                                            <div
                                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                                                @if ($user->profile_photo_path)
                                                                    <img src="{{ Storage::url($user->profile_photo_path) }}"
                                                                        alt="{{ $user->name }}"
                                                                        class="h-full w-full object-cover">
                                                                @else
                                                                    <svg class="h-full w-full text-gray-400"
                                                                        fill="currentColor" viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112 15c3.183 0 6.235 1.264 8.485 3.515A9.975 9.975 0 0024 20.993zM12 12a6 6 0 100-12 6 6 0 000 12z" />
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="font-medium text-gray-900 dark:text-white">
                                                                    {{ $user->name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <!-- Email -->
                                                    <td class="px-4 py-4 hidden md:table-cell">
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            {{ $user->email }}
                                                        </div>
                                                    </td>

                                                    <!-- Role -->
                                                    <td class="px-4 py-4">
                                                        <span
                                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            @if ($user->role === 'admin') bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                                                            @elseif($user->role === 'organizer') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                                            {{ ucfirst($user->role) }}
                                                        </span>
                                                    </td>

                                                    <!-- Joined Date -->
                                                    <td class="px-4 py-4 hidden sm:table-cell">
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $user->created_at->format('M d, Y') }}
                                                        </div>
                                                    </td>

                                                    <!-- Actions -->
                                                    <td class="px-4 py-4 text-right">
                                                        <div class="flex justify-end gap-2">
                                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                                class="px-3 py-1.5 bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-800 dark:text-blue-100 dark:hover:bg-blue-700 rounded-md text-sm font-medium transition-colors">
                                                                Edit
                                                            </a>
                                                            @if ($user->id !== auth()->id())
                                                                <form method="POST"
                                                                    action="{{ route('admin.users.destroy', $user) }}"
                                                                    onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="px-3 py-1.5 bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-800 dark:text-red-100 dark:hover:bg-red-700 rounded-md text-sm font-medium transition-colors">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            @if ($users->hasPages())
                                <div class="mt-4">
                                    {{ $users->appends(request()->query())->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </main>
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="font-bold text-xl mb-4 text-gray-800 dark:text-white">EventHub</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Bringing people together through memorable events and experiences.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Need Help?</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Have questions or need assistance? Our support team is here to help you.
                        </p>
                        <button
                            class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>
