<x-app-layout class="flex flex-col min-h-screen">
    <main class="container mx-auto px-4 py-8 max-w-2xl flex-grow">
        <div class="animate-fade-in-up">
            <h1 class="text-4xl font-bold mb-6 text-gray-800 border-b pb-3 border-gray-200">
                Edit Announcement
            </h1>

            <form action="{{ route('announcements.update', $announcement) }}" method="POST"
                class="bg-white shadow-2xl rounded-xl p-8 space-y-6 border border-gray-100 transition-all duration-300 hover:shadow-lg">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Title
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                        value="{{ $announcement->title }}" placeholder="Enter announcement title" required>
                </div>

                <div class="space-y-2">
                    <label for="content" class="block text-sm font-medium text-gray-700">
                        Content
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" name="content"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                        rows="6" placeholder="Write your announcement content here"
                        required>{{ $announcement->content }}</textarea>
                </div>

                <div class="space-y-2">
                    <label for="announcement_date" class="block text-sm font-medium text-gray-700">
                        Announcement Date
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="announcement_date" name="announcement_date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                        value="{{ $announcement->announcement_date }}" required>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('announcements.index') }}"
                        class="px-6 py-3 text-gray-600 hover:bg-gray-100 rounded-lg transition duration-300">
                        Cancel
                    </a>
                    <button type="submit"
                        class="group relative px-8 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300 transform hover:-translate-y-1">
                        <span
                            class="absolute inset-0 bg-blue-700 opacity-0 group-hover:opacity-20 transition-opacity rounded-lg"></span>
                        Update Announcement
                    </button>
                </div>
            </form>
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
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Resources</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="#"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">FAQ</a>
                        <a href="#"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Help
                            Center</a>
                        <a href="#"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">User
                            Guide</a>
                        <a href="#"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Terms</a>
                        <a href="#"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Privacy</a>
                        <a href="#"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Contact</a>
                    </div>
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

            <div
                class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center text-sm text-gray-500 dark:text-gray-400">
                <p>© 2025 EventHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</x-app-layout>