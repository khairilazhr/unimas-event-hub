<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Main Content --}}
        <main class="flex-grow py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-2xl p-8 sm:p-10">
                    <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-10">
                        Event Registration
                    </h1>

                    <div class="mb-8">
                        <div
                            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow mb-6">
                            {{-- Event Image - Full Width on All Screens --}}
                            @if($event->poster)
                                <div class="w-full">
                                    <img src="data:image/jpeg;base64,{{ base64_encode($event->poster) }}" alt="Event Poster"
                                        class="w-full h-64 object-cover">
                                </div>
                            @endif

                            {{-- Event Details - Below Image --}}
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">
                                    {{ $event->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                    {{ $event->description }}
                                </p>
                                <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2">
                                    <li>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Organizer:</span>
                                        {{ $event->organizer_name }}
                                    </li>
                                    <li>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Date:</span>
                                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                                    </li>
                                    <li>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Location:</span>
                                        {{ $event->location }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                        Registration Form
                    </h2>

                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div
                            class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-lg p-4 mb-6">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Registration Form -->
                    <div class="max-w-3xl mx-auto">
                        <form action="{{ route('user.events.process-registration', $event->id) }}" method="POST"
                            class="space-y-6">
                            @csrf

                            <!-- Name Field -->
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full
                                    Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                                    Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                            </div>

                            <!-- Phone Number Field -->
                            <div>
                                <label for="phone"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                                    Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                            </div>

                            <!-- Ticket Type Field -->
                            <div>
                                <label for="ticket_type"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ticket
                                    Type</label>
                                <select name="ticket_type" id="ticket_type" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                                    <option value="">-- Select Ticket Type --</option>
                                    <option value="standard" {{ old('ticket_type') == 'standard' ? 'selected' : '' }}>
                                        Standard (RM50)</option>
                                    <option value="premium" {{ old('ticket_type') == 'premium' ? 'selected' : '' }}>
                                        Premium (RM100)</option>
                                    <option value="vip" {{ old('ticket_type') == 'vip' ? 'selected' : '' }}>VIP (RM200)
                                    </option>
                                </select>
                            </div>

                            <!-- Seating Placement -->
                            <div>
                                <label for="seating"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Seating
                                    Placement</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Left Column - Seat Section -->
                                    <div>
                                        <label for="seat_section"
                                            class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Section</label>
                                        <select name="seat_section" id="seat_section" required
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                                            <option value="">-- Select Section --</option>
                                            <option value="A" {{ old('seat_section') == 'A' ? 'selected' : '' }}>Section A
                                            </option>
                                            <option value="B" {{ old('seat_section') == 'B' ? 'selected' : '' }}>Section B
                                            </option>
                                            <option value="C" {{ old('seat_section') == 'C' ? 'selected' : '' }}>Section C
                                            </option>
                                            <option value="D" {{ old('seat_section') == 'D' ? 'selected' : '' }}>Section D
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Right Column - Seat Row & Number -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="seat_row"
                                                class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Row</label>
                                            <select name="seat_row" id="seat_row" required
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                                                <option value="">-- Row --</option>
                                                @foreach(range(1, 10) as $row)
                                                    <option value="{{ $row }}" {{ old('seat_row') == $row ? 'selected' : '' }}>{{ $row }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="seat_number"
                                                class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Seat
                                                #</label>
                                            <select name="seat_number" id="seat_number" required
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                                                <option value="">-- Seat --</option>
                                                @foreach(range(1, 20) as $seat)
                                                    <option value="{{ $seat }}" {{ old('seat_number') == $seat ? 'selected' : '' }}>{{ $seat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Requirements or Notes -->
                            <div>
                                <label for="notes"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Special
                                    Requirements or Notes</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full px-6 py-3 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition duration-200">
                                    Complete Registration
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        {{-- Sticky Footer --}}
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-inner">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Resources</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">FAQ</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Help Center</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">User Guide</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Terms</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Privacy</a>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Contact</a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Need Help?</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Have questions or need assistance? We're here to help.
                        </p>
                        <button
                            class="inline-block px-4 py-2 text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                            Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>