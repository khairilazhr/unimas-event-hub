<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        {{-- Main Content --}}
        <main class="flex-grow py-8 md:py-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-3xl overflow-hidden transition-all duration-300 transform hover:shadow-xl">
                    
                    <div class="relative overflow-hidden">
                        {{-- Event Image with Overlay --}}
                        @if($event->poster)
                            <div class="w-full h-72 md:h-96 relative">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                                <img src="data:image/jpeg;base64,{{ base64_encode($event->poster) }}" alt="Event Poster"
                                    class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                            </div>
                        @endif

                        {{-- Event Title Overlay --}}
                        <div class="absolute bottom-0 left-0 right-0 z-20 p-6 md:p-8">
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 opacity-0 animate-fadeUp">
                                {{ $event->name }}
                            </h1>
                            <div class="flex items-center space-x-4 text-white/90 text-sm opacity-0 animate-fadeUp" style="animation-delay: 0.2s">
                                <div>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</div>
                                <div class="w-1 h-1 rounded-full bg-white/70"></div>
                                <div>{{ $event->location }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-10">
                        {{-- Event Details --}}
                        <div class="mb-8 max-w-3xl">
                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-4 leading-relaxed opacity-0 animate-fadeUp" style="animation-delay: 0.3s">
                                {{ $event->description }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 opacity-0 animate-fadeUp" style="animation-delay: 0.4s">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#0057A7]" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $event->organizer_name }}</span>
                            </div>
                        </div>

                        {{-- Registration Section --}}
                        <div class="max-w-3xl mx-auto">
                            <h2 class="text-xl font-semibold text-[#0057A7] dark:text-[#4f97d1] mb-6 text-center opacity-0 animate-fadeUp" style="animation-delay: 0.5s">
                                Registration Form
                            </h2>

                            <!-- Display validation errors -->
                            @if ($errors->any())
                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-lg p-4 mb-6 opacity-0 animate-fadeUp" style="animation-delay: 0.6s">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Registration Form -->
                            <form action="{{ route('user.events.process-registration', $event->id) }}" method="POST" class="space-y-5">
                                @csrf

                                <!-- Name Field -->
                                <div class="opacity-0 animate-fadeUp" style="animation-delay: 0.6s">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Full Name
                                    </label>
                                    <div class="relative group">
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required
                                            class="w-full px-4 py-3 border-0 border-b-2 border-gray-200 dark:border-gray-700 focus:border-[#0057A7] dark:focus:border-[#4f97d1] bg-transparent focus:outline-none focus:ring-0 transition-all dark:text-white">
                                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0057A7] group-focus-within:w-full transition-all duration-300"></div>
                                    </div>
                                </div>

                                <!-- Email Field -->
                                <div class="opacity-0 animate-fadeUp" style="animation-delay: 0.7s">
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Email Address
                                    </label>
                                    <div class="relative group">
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required
                                            class="w-full px-4 py-3 border-0 border-b-2 border-gray-200 dark:border-gray-700 focus:border-[#0057A7] dark:focus:border-[#4f97d1] bg-transparent focus:outline-none focus:ring-0 transition-all dark:text-white">
                                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0057A7] group-focus-within:w-full transition-all duration-300"></div>
                                    </div>
                                </div>

                                <!-- Buy for someone else button -->
                                <div class="opacity-0 animate-fadeUp" style="animation-delay: 0.75s">
                                    <button type="button" id="buyForSomeoneElse"
                                        class="text-sm text-[#0057A7] hover:text-[#003d75] dark:text-[#4f97d1] dark:hover:text-[#7bb3e0] font-medium transition-colors duration-300 relative overflow-hidden group">
                                        <span>Buy for someone else</span>
                                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0057A7] dark:bg-[#4f97d1] group-hover:w-full transition-all duration-300"></span>
                                    </button>
                                </div>

                                <!-- Phone Number Field -->
                                <div class="opacity-0 animate-fadeUp" style="animation-delay: 0.8s">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Phone Number
                                    </label>
                                    <div class="relative group">
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                            class="w-full px-4 py-3 border-0 border-b-2 border-gray-200 dark:border-gray-700 focus:border-[#0057A7] dark:focus:border-[#4f97d1] bg-transparent focus:outline-none focus:ring-0 transition-all dark:text-white">
                                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0057A7] group-focus-within:w-full transition-all duration-300"></div>
                                    </div>
                                </div>

                                <!-- Ticket Type Field -->
                                <div class="opacity-0 animate-fadeUp" style="animation-delay: 0.9s">
                                    <label for="ticket_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Ticket Type
                                    </label>
                                    <div class="relative group">
                                        <select name="ticket_type" id="ticket_type" required
                                            class="w-full px-4 py-3 border-0 border-b-2 border-gray-200 dark:border-gray-700 focus:border-[#0057A7] dark:focus:border-[#4f97d1] bg-transparent focus:outline-none focus:ring-0 transition-all appearance-none dark:text-white">
                                            <option value="">-- Select Ticket Type --</option>
                                            @php
                                                $ticketTypes = $tickets->pluck('type')->unique();
                                            @endphp
                                            @foreach($ticketTypes as $type)
                                                <option value="{{ $type }}" {{ old('ticket_type') == $type ? 'selected' : '' }}>
                                                    {{ $type }} (RM{{ number_format($tickets->where('type', $type)->first()->price, 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0057A7] group-focus-within:w-full transition-all duration-300"></div>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 opacity-0 animate-fadeUp" style="animation-delay: 1s">
                                    <div>
                                        <label for="section" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Section
                                        </label>
                                        <div class="relative group">
                                            <select name="section" id="section" required
                                                class="w-full px-4 py-3 border-0 border-b-2 border-gray-200 dark:border-gray-700 focus:border-[#0057A7] dark:focus:border-[#4f97d1] bg-transparent focus:outline-none focus:ring-0 transition-all appearance-none dark:text-white disabled:opacity-50"
                                                disabled>
                                                <option value="">-- Select Section --</option>
                                            </select>
                                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0057A7] group-focus-within:w-full transition-all duration-300"></div>
                                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="row" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Row
                                        </label>
                                        <div class="relative group">
                                            <select name="row" id="row" required
                                                class="w-full px-4 py-3 border-0 border-b-2 border-gray-200 dark:border-gray-700 focus:border-[#0057A7] dark:focus:border-[#4f97d1] bg-transparent focus:outline-none focus:ring-0 transition-all appearance-none dark:text-white disabled:opacity-50"
                                                disabled>
                                                <option value="">-- Select Row --</option>
                                            </select>
                                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0057A7] group-focus-within:w-full transition-all duration-300"></div>
                                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="seat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Seat
                                        </label>
                                        <div class="relative group">
                                            <select name="seat" id="seat" required
                                                class="w-full px-4 py-3 border-0 border-b-2 border-gray-200 dark:border-gray-700 focus:border-[#0057A7] dark:focus:border-[#4f97d1] bg-transparent focus:outline-none focus:ring-0 transition-all appearance-none dark:text-white disabled:opacity-50"
                                                disabled>
                                                <option value="">-- Select Seat --</option>
                                            </select>
                                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#0057A7] group-focus-within:w-full transition-all duration-300"></div>
                                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden field to store the final selected ticket ID -->
                                <input type="hidden" name="ticket_id" id="ticket_id" value="{{ old('ticket_id') }}">

                                <!-- Submit Button -->
                                <div class="pt-8 opacity-0 animate-fadeUp" style="animation-delay: 1.1s">
                                    <button type="submit"
                                        class="w-full px-6 py-3 text-base font-medium text-white bg-[#0057A7] hover:bg-[#003d75] dark:bg-[#0057A7] dark:hover:bg-[#003d75] rounded-lg transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg">
                                        Complete Registration
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        {{-- Sticky Footer - Preserved as requested --}}
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });

        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
</x-app-layout>