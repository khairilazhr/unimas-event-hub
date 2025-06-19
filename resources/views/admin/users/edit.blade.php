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
                                Edit User
                            </h1>
                            <a href="{{ route('admin.users') }}"
                                class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                ← Back to Users
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

                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- User Information Card -->
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm mb-6">
                            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">User Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Current Name</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-white">{{ $user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Current Email</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-white">{{ $user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Current Role</dt>
                                    <dd class="mt-1">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if ($user->role === 'admin') bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                                            @elseif($user->role === 'organizer') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Joined</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-white">
                                        {{ $user->created_at->format('F j, Y \a\t g:i A') }}</dd>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm">
                            <h2 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Edit User Details</h2>

                            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <!-- Name Field -->
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Name
                                    </label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent dark:bg-gray-800 dark:text-white"
                                        required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent dark:bg-gray-800 dark:text-white"
                                        required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Role Field -->
                                <div>
                                    <label for="role"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Role
                                    </label>
                                    <select id="role" name="role"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent dark:bg-gray-800 dark:text-white"
                                        required>
                                        <option value="user"
                                            {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="organizer"
                                            {{ old('role', $user->role) === 'organizer' ? 'selected' : '' }}>Organizer
                                        </option>
                                        <option value="admin"
                                            {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Warning for changing own role -->
                                @if ($user->id === auth()->id())
                                    <div
                                        class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                                    Warning
                                                </h3>
                                                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                                    <p>You are editing your own account. Be careful when changing your
                                                        role as it may affect your access to certain features.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex justify-end space-x-4 pt-6">
                                    <a href="{{ route('admin.users') }}"
                                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="px-4 py-2 bg-unimasblue hover:bg-blue-700 text-white rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                                        Update User
                                    </button>
                                </div>
                            </form>
                        </div>
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
