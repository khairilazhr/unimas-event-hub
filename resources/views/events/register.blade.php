<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        {{-- Main Content --}}
        <main class="flex-grow py-8 md:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-3xl overflow-hidden transition-all duration-300 transform hover:shadow-xl">

            {{-- Poster --}}
            @if($event->poster)
                <div class="w-full h-72 md:h-96 relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                                <img src="{{ Storage::url($event->poster) }}" alt="Poster" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                </div>
            @endif

            {{-- Event Title, Date, Location --}}
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2 md:mb-0">
                        {{ $event->name }}
                    </h1>
                    <button id="getTicketButton"
                        class="px-8 py-3 text-base font-medium text-white bg-[#0057A7] hover:bg-[#003d75] dark:bg-[#0057A7] dark:hover:bg-[#003d75] rounded-lg transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg">
                        Get Ticket
                    </button>
                </div>

                <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-6 text-gray-600 dark:text-gray-300 text-sm mb-6">
                    {{-- Date with icon and formatted nicely --}}
                    <div class="flex items-center space-x-2 animate-fadeIn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                        <time datetime="{{ $event->date }}">
                            {{ \Carbon\Carbon::parse($event->date)->format('l, jS F Y') }}
                        </time>
                    </div>

                    {{-- Separator --}}
                    <div class="hidden md:block w-px h-6 bg-gray-400 dark:bg-gray-500"></div>

                    {{-- Location with icon --}}
                    <div class="flex items-center space-x-2 animate-fadeIn delay-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            {{-- Event Description & Organizer --}}
            <div class="p-6 md:p-10 pt-0">
                <div class="mb-8 max-w-3xl">
                    <div class="text-sm text-gray-700 dark:text-gray-300 mb-6 leading-relaxed prose prose-indigo dark:prose-invert">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#0057A7]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $event->organizer_name }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>



        {{-- Sticky Footer - Preserved as requested --}}
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
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Resources</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">FAQ</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Help Center</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">User Guide</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Terms</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Privacy</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-unimasblue dark:hover:text-unimasblue transition">Contact</a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Need Help?</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Have questions or need assistance? Our support team is here to help you.
                        </p>
                        <button class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            Contact Support
                        </button>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 text-center text-sm text-gray-500 dark:text-gray-400">
                    <p>© 2025 EventHub. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    {{-- Registration Modal --}}
    <div id="registrationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-900/75 backdrop-blur-sm transition-all duration-300"></div>
    </div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all duration-300 opacity-0 translate-y-4 scale-98 max-w-2xl w-full mx-auto relative" id="modalContent">
            <button id="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none z-10 transition-transform duration-200 hover:rotate-90">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="px-6 pt-6 pb-8">
                <h2 class="text-xl font-medium text-gray-800 dark:text-gray-200 mb-6">
                    Registration
                </h2>

                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/10 border-l-4 border-red-400 dark:border-red-600 text-red-700 dark:text-red-400 p-4 mb-6">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.events.process-registration', $event->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                            Full Name
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 bg-white dark:bg-gray-800 transition-all dark:text-white text-sm">
                    </div>

                    <div>
                        <label for="email" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                            Email Address
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 bg-white dark:bg-gray-800 transition-all dark:text-white text-sm">
                    </div>

                    <div>
                        <button type="button" id="buyForSomeoneElse"
                            class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors">
                            Buy for someone else
                        </button>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                            Phone Number
                        </label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 bg-white dark:bg-gray-800 transition-all dark:text-white text-sm">
                    </div>

                    <div>
                        <label for="ticket_type" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                            Ticket Type
                        </label>
                        <div class="relative">
                            <select name="ticket_type" id="ticket_type" required
                                class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 bg-white dark:bg-gray-800 transition-all appearance-none dark:text-white text-sm">
                                <option value="">Select ticket type</option>
                                @php
                                    $ticketTypes = $tickets->pluck('type')->unique();
                                @endphp
                                @foreach($ticketTypes as $type)
                                    <option value="{{ $type }}" {{ old('ticket_type') == $type ? 'selected' : '' }}>
                                        {{ $type }} (RM{{ number_format($tickets->where('type', $type)->first()->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label for="section" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                                Section
                            </label>
                            <div class="relative">
                                <select name="section" id="section" required
                                    class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 bg-white dark:bg-gray-800 transition-all appearance-none dark:text-white text-sm disabled:opacity-50 disabled:bg-gray-100 dark:disabled:bg-gray-700"
                                    disabled>
                                    <option value="">Select section</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="row" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                                Row
                            </label>
                            <div class="relative">
                                <select name="row" id="row" required
                                    class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 bg-white dark:bg-gray-800 transition-all appearance-none dark:text-white text-sm disabled:opacity-50 disabled:bg-gray-100 dark:disabled:bg-gray-700"
                                    disabled>
                                    <option value="">Select row</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="seat" class="block text-sm text-gray-600 dark:text-gray-400 mb-1">
                                Seat
                            </label>
                            <div class="relative">
                                <select name="seat" id="seat" required
                                    class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 bg-white dark:bg-gray-800 transition-all appearance-none dark:text-white text-sm disabled:opacity-50 disabled:bg-gray-100 dark:disabled:bg-gray-700"
                                    disabled>
                                    <option value="">Select seat</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="ticket_id" id="ticket_id" value="{{ old('ticket_id') }}">

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Complete Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeUp {
            animation: fadeUp 0.7s ease-out forwards;
        }

        /* Disable scroll when modal is open */
        body.modal-open {
            overflow: hidden;
        }

        /* Modal animation */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes modalFadeOut {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateY(10px) scale(0.95);
            }
        }

        .modal-show {
            animation: modalFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .modal-hide {
            animation: modalFadeOut 0.3s ease-in-out forwards;
        }

        @keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.6s ease forwards;
}
.animate-fadeIn.delay-150 {
  animation-delay: 0.15s;
}
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Form functionality (existing code)
            const typeSelect = document.getElementById('ticket_type');
            const sectionSelect = document.getElementById('section');
            const rowSelect = document.getElementById('row');
            const seatSelect = document.getElementById('seat');
            const ticketIdField = document.getElementById('ticket_id');

            // Create a structured data object of all tickets
            const ticketData = @json($tickets);

            // When ticket type changes
            typeSelect.addEventListener('change', function () {
                const selectedType = this.value;

                // Reset and disable subsequent fields
                resetSelect(sectionSelect);
                resetSelect(rowSelect);
                resetSelect(seatSelect);

                if (!selectedType) return;

                // Get all sections for this ticket type
                const sections = [...new Set(
                    ticketData
                        .filter(ticket => ticket.type === selectedType)
                        .map(ticket => ticket.section)
                )];

                // Populate sections dropdown
                sections.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section;
                    option.textContent = section;
                    sectionSelect.appendChild(option);
                });

                sectionSelect.disabled = false;
            });

            // When section changes
            sectionSelect.addEventListener('change', function () {
                const selectedType = typeSelect.value;
                const selectedSection = this.value;

                // Reset and disable subsequent fields
                resetSelect(rowSelect);
                resetSelect(seatSelect);

                if (!selectedSection) return;

                // Get all rows for this ticket type and section
                const rows = [...new Set(
                    ticketData
                        .filter(ticket => ticket.type === selectedType && ticket.section === selectedSection)
                        .map(ticket => ticket.row)
                )];

                // Populate rows dropdown
                rows.forEach(row => {
                    const option = document.createElement('option');
                    option.value = row;
                    option.textContent = row;
                    rowSelect.appendChild(option);
                });

                rowSelect.disabled = false;
            });

            // When row changes
            rowSelect.addEventListener('change', function () {
                const selectedType = typeSelect.value;
                const selectedSection = sectionSelect.value;
                const selectedRow = this.value;

                // Reset seat select
                resetSelect(seatSelect);

                if (!selectedRow) return;

                // Get all seats for this ticket type, section and row
                const availableTickets = ticketData.filter(ticket =>
                    ticket.type === selectedType &&
                    ticket.section === selectedSection &&
                    ticket.row === selectedRow
                );

                // Populate seats dropdown
                availableTickets.forEach(ticket => {
                    const option = document.createElement('option');
                    option.value = ticket.id; // Use ticket ID as the value
                    option.textContent = ticket.seat;
                    option.dataset.ticketId = ticket.id;
                    seatSelect.appendChild(option);
                });

                seatSelect.disabled = false;
            });

            // When seat changes
            seatSelect.addEventListener('change', function () {
                if (this.value) {
                    // Set the ticket_id field value to the selected ticket's ID
                    ticketIdField.value = this.value;
                } else {
                    ticketIdField.value = '';
                }
            });

            // Helper function to reset a select
            function resetSelect(selectElement) {
                selectElement.innerHTML = '<option value="">-- Select an option --</option>';
                selectElement.disabled = true;
            }

            // Initialize selections if coming back from validation error
            if (typeSelect.value) {
                typeSelect.dispatchEvent(new Event('change'));

                // If section was previously selected
                setTimeout(() => {
                    const oldSection = "{{ old('section') }}";
                    if (oldSection) {
                        sectionSelect.value = oldSection;
                        sectionSelect.dispatchEvent(new Event('change'));

                        // If row was previously selected
                        setTimeout(() => {
                            const oldRow = "{{ old('row') }}";
                            if (oldRow) {
                                rowSelect.value = oldRow;
                                rowSelect.dispatchEvent(new Event('change'));

                                // If seat was previously selected
                                setTimeout(() => {
                                    const oldTicketId = "{{ old('ticket_id') }}";
                                    if (oldTicketId) {
                                        seatSelect.value = oldTicketId;
                                    }
                                }, 100);
                            }
                        }, 100);
                    }
                }, 100);
            }

            // Buy for someone else functionality (existing code)
            const buyForSomeoneElseBtn = document.getElementById('buyForSomeoneElse');
            const nameField = document.getElementById('name');
            const emailField = document.getElementById('email');

            // Store original values
            const originalName = nameField.value;
            const originalEmail = emailField.value;

            let isForSomeoneElse = false;

            buyForSomeoneElseBtn.addEventListener('click', function () {
                if (!isForSomeoneElse) {
                    // Clear the fields with animation
                    nameField.classList.add('transition-all', 'duration-300');
                    emailField.classList.add('transition-all', 'duration-300');

                    nameField.style.opacity = '0';
                    emailField.style.opacity = '0';

                    setTimeout(() => {
                        nameField.value = '';
                        emailField.value = '';
                        nameField.style.opacity = '1';
                        emailField.style.opacity = '1';
                        buyForSomeoneElseBtn.textContent = 'Use my information';
                        nameField.focus();
                    }, 300);
                } else {
                    // Restore original values with animation
                    nameField.style.opacity = '0';
                    emailField.style.opacity = '0';

                    setTimeout(() => {
                        nameField.value = originalName;
                        emailField.value = originalEmail;
                        nameField.style.opacity = '1';
                        emailField.style.opacity = '1';
                        buyForSomeoneElseBtn.textContent = 'Buy for someone else';
                    }, 300);
                }

                isForSomeoneElse = !isForSomeoneElse;
            });

            // Enhanced modal functionality
            const modal = document.getElementById('registrationModal');
            const modalContent = document.getElementById('modalContent');
            const getTicketButton = document.getElementById('getTicketButton');
            const closeModal = document.getElementById('closeModal');

            // Function to show modal with smooth animation
            function showModal() {
                modal.classList.remove('hidden');
                document.body.classList.add('modal-open');

                // Start the animation after a tiny delay to ensure the display change has taken effect
                setTimeout(() => {
                    modalContent.classList.add('modal-show');
                    modalContent.classList.remove('opacity-0', 'translate-y-10', 'scale-95');
                }, 10);
            }

            // Function to hide modal with smooth animation
            function hideModal() {
                modalContent.classList.remove('modal-show');
                modalContent.classList.add('modal-hide');

                // Wait for animation to complete before hiding the modal
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('modal-open');
                    modalContent.classList.remove('modal-hide');
                    modalContent.classList.add('opacity-0', 'translate-y-10', 'scale-95');
                }, 300);
            }

            // Show modal when Get Ticket button is clicked
            getTicketButton.addEventListener('click', showModal);

            // Hide modal when close button is clicked
            closeModal.addEventListener('click', hideModal);

            // Hide modal when clicking outside the modal content
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    hideModal();
                }
            });

            // Hide modal when ESC key is pressed
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    hideModal();
                }
            });

            // If there are validation errors, show the modal automatically
            @if ($errors->any())
                document.addEventListener('DOMContentLoaded', function() {
                    showModal();
                });
            @endif
        });
    </script>
</x-app-layout>
