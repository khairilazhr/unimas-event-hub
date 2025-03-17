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

                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 text-center">
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
                                <div class="relative">
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name ?? '') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                                    Address</label>
                                <div class="relative">
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email ?? '') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <!-- Buy for someone else button -->
                            <div class="mt-2">
                                <button type="button" id="buyForSomeoneElse"
                                    class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                    Buy for someone else
                                </button>
                            </div>

                            <!-- Add this JavaScript to handle the button click -->
                            <script>
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
                                            // Clear the fields
                                            nameField.value = '';
                                            emailField.value = '';
                                            buyForSomeoneElseBtn.textContent = 'Use my information';
                                        } else {
                                            // Restore original values
                                            nameField.value = originalName;
                                            emailField.value = originalEmail;
                                            buyForSomeoneElseBtn.textContent = 'Buy for someone else';
                                        }

                                        isForSomeoneElse = !isForSomeoneElse;
                                        nameField.focus();
                                    });
                                });
                            </script>

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
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Ticket Type
                                </label>
                                <select name="ticket_type" id="ticket_type" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white">
                                    <option value="">-- Select Ticket Type --</option>
                                    @php
                                        $ticketTypes = $tickets->pluck('type')->unique();
                                    @endphp
                                    @foreach($ticketTypes as $type)
                                        <option value="{{ $type }}" {{ old('ticket_type') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                            (RM{{ number_format($tickets->where('type', $type)->first()->price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <label for="section"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Section
                                    </label>
                                    <select name="section" id="section" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white"
                                        disabled>
                                        <option value="">-- Select Section --</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="row"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Row
                                    </label>
                                    <select name="row" id="row" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white"
                                        disabled>
                                        <option value="">-- Select Row --</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="seat"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Seat
                                    </label>
                                    <select name="seat" id="seat" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:bg-gray-700 dark:text-white"
                                        disabled>
                                        <option value="">-- Select Seat --</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Hidden field to store the final selected ticket ID -->
                            <input type="hidden" name="ticket_id" id="ticket_id" value="{{ old('ticket_id') }}">

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
                // Clear the fields
                nameField.value = '';
                emailField.value = '';
                buyForSomeoneElseBtn.textContent = 'Use my information';
            } else {
                // Restore original values
                nameField.value = originalName;
                emailField.value = originalEmail;
                buyForSomeoneElseBtn.textContent = 'Buy for someone else';
            }

            isForSomeoneElse = !isForSomeoneElse;
            nameField.focus();
        });
    });
</script>