<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-3">
            <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                    <!-- Keep the Edit Event header -->
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-3">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-xl font-bold text-center text-white">
                            Edit Event
                        </h1>
                    </div>

                    <div class="p-3 sm:p-4">
                        @if ($errors->any())
                            <div class="mb-2 p-2 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 text-sm">
                                <ul class="list-disc pl-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('organizer.update.event', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            @method('PATCH')

                            <!-- Basic Info Section - Grid Layout -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <!-- Event Name -->
                                    <div>
                                        <label for="name" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Event Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                    </div>

                                    <!-- Event Date -->
                                    <div>
                                        <label for="date" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Event Date</label>
                                        <input type="datetime-local" name="date" id="date" value="{{ old('date', date('Y-m-d\TH:i', strtotime($event->date))) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                    </div>

                                    <!-- Location -->
                                    <div>
                                        <label for="location" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Location</label>
                                        <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                    </div>

                                    <!-- Organizer Name -->
                                    <div>
                                        <label for="organizer_name" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Organizer Name</label>
                                        <input type="text" name="organizer_name" id="organizer_name" value="{{ old('organizer_name', $event->organizer_name) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                    </div>
                                </div>
                            </div>

                            <!-- Second Row with Description and Event Poster - side by side -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <!-- Description -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                    <label for="description" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm">{{ old('description', $event->description) }}</textarea>
                                </div>

                                <!-- Event Poster -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                    <label for="poster" class="block text-xs font-medium text-gray-700 dark:text-gray-300">
                                        Event Poster
                                    </label>

                                    <div class="flex items-center mt-1">
                                        @if($event->poster)
                                            <div class="flex-shrink-0 mr-2">
                                                <img src="{{ asset('storage/' . $event->poster) }}" alt="Event poster" class="w-20 h-auto rounded-md shadow-sm">
                                            </div>
                                        @endif
                                        <div class="flex-grow">
                                            <input type="file" name="poster" id="poster"
                                                class="block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Max size: 2MB. Recommended: 1200x630px</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ticket Management Section - Tabbed Interface -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 shadow-sm">
                                <div class="flex justify-between items-center mb-2">
                                    <h2 class="text-sm font-medium text-gray-900 dark:text-white">Ticket Management</h2>

                                    <!-- Tab Navigation -->
                                    <div class="flex border-b border-gray-200 dark:border-gray-600">
                                        <button type="button" id="tab-current" class="tab-btn px-3 py-1 text-xs border-b-2 border-unimasblue text-unimasblue">Current Tickets</button>
                                        <button type="button" id="tab-new" class="tab-btn px-3 py-1 text-xs text-gray-500 dark:text-gray-400">Add New</button>
                                    </div>
                                </div>

                                <!-- Current Ticket Sections Tab - Initially Visible -->
                                <div id="current-tickets" class="tab-content">
                                    @if($ticketSections = $event->tickets->groupBy('section'))
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs">
                                                <thead class="bg-gray-50 dark:bg-gray-700">
                                                    <tr>
                                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Section</th>
                                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Type</th>
                                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Price</th>
                                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Rows</th>
                                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Seats</th>
                                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Available</th>
                                                        <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach($ticketSections as $section => $tickets)
                                                        @php
                                                            $firstTicket = $tickets->first();
                                                            $rows = $tickets->pluck('row')->unique()->count();
                                                            $seatsPerRow = $tickets->where('row', $tickets->min('row'))->count();
                                                            $availableCount = $tickets->where('status', 'available')->count();
                                                        @endphp
                                                        <tr>
                                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-white">{{ $section }}</td>
                                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-white">{{ $firstTicket->type }}</td>
                                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-white">{{ number_format($firstTicket->price, 2) }}</td>
                                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-white">{{ $rows }}</td>
                                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-white">{{ $seatsPerRow }}</td>
                                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-white">{{ $availableCount }}/{{ $tickets->count() }}</td>
                                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900 dark:text-white">
                                                                @if($availableCount == $tickets->count())
                                                                    <button type="button"
                                                                        onclick="updateTicketSection('{{ $section }}', '{{ $firstTicket->type }}', {{ $firstTicket->price }}, '{{ $firstTicket->description }}', {{ $rows }}, {{ $seatsPerRow }})"
                                                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-1">
                                                                        Edit
                                                                    </button>
                                                                    <button type="button"
                                                                        onclick="if(confirm('Are you sure? This will delete all tickets in this section.')) document.getElementById('delete-section-{{ str_replace(' ', '-', $section) }}').submit()"
                                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                                        Delete
                                                                    </button>
                                                                    <form id="delete-section-{{ str_replace(' ', '-', $section) }}"
                                                                        action="{{ route('organizer.delete.section', $event->id) }}"
                                                                        method="POST" class="hidden">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="hidden" name="section" value="{{ $section }}">
                                                                    </form>
                                                                @else
                                                                    <span class="text-gray-500 dark:text-gray-400">Some tickets sold</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No ticket sections yet.</p>
                                    @endif
                                </div>

                                <!-- Add New Ticket Section Tab - Initially Hidden -->
                                <div id="new-tickets" class="tab-content hidden">
                                    <div id="ticket-sections">
                                        <div class="ticket-section bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg mb-3">
                                            <div class="grid grid-cols-2 gap-3 mb-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Section Name</label>
                                                    <input type="text" name="new_tickets[0][section]" placeholder="e.g. VIP"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Ticket Type</label>
                                                    <input type="text" name="new_tickets[0][type]" placeholder="e.g. Student"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-3 gap-3 mb-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Price (RM)</label>
                                                    <input type="number" name="new_tickets[0][price]" step="0.01" min="0" placeholder="0.00"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Rows</label>
                                                    <input type="number" name="new_tickets[0][rows]" min="1" placeholder="1"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Seats/Row</label>
                                                    <input type="number" name="new_tickets[0][seats_per_row]" min="1" placeholder="10"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Description</label>
                                                <textarea name="new_tickets[0][description]" rows="1" placeholder="Optional details"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="add-ticket-section"
                                        class="inline-flex items-center px-2 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-unimasblue">
                                        <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add Another Section
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-3 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('organizer.events') }}"
                                    class="inline-flex items-center px-3 py-1 mr-3 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-unimasblue">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-unimasblue hover:bg-unimasblue/90 focus:outline-none focus:ring-1 focus:ring-unimasblue">
                                    Update Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // JavaScript for adding ticket sections dynamically
        document.addEventListener('DOMContentLoaded', function() {
            const ticketSections = document.getElementById('ticket-sections');
            const addSectionBtn = document.getElementById('add-ticket-section');
            const tabCurrent = document.getElementById('tab-current');
            const tabNew = document.getElementById('tab-new');
            const currentTicketsContent = document.getElementById('current-tickets');
            const newTicketsContent = document.getElementById('new-tickets');
            let sectionCount = 1;

            // Tab switching functionality
            tabCurrent.addEventListener('click', function() {
                currentTicketsContent.classList.remove('hidden');
                newTicketsContent.classList.add('hidden');
                tabCurrent.classList.add('border-b-2', 'border-unimasblue', 'text-unimasblue');
                tabCurrent.classList.remove('text-gray-500', 'dark:text-gray-400');
                tabNew.classList.remove('border-b-2', 'border-unimasblue', 'text-unimasblue');
                tabNew.classList.add('text-gray-500', 'dark:text-gray-400');
            });

            tabNew.addEventListener('click', function() {
                currentTicketsContent.classList.add('hidden');
                newTicketsContent.classList.remove('hidden');
                tabNew.classList.add('border-b-2', 'border-unimasblue', 'text-unimasblue');
                tabNew.classList.remove('text-gray-500', 'dark:text-gray-400');
                tabCurrent.classList.remove('border-b-2', 'border-unimasblue', 'text-unimasblue');
                tabCurrent.classList.add('text-gray-500', 'dark:text-gray-400');
            });

            addSectionBtn.addEventListener('click', function() {
                const newSection = document.createElement('div');
                newSection.className = 'ticket-section bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg mb-3';
                newSection.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-xs font-medium text-gray-700 dark:text-gray-300">Ticket Section ${sectionCount + 1}</h4>
                        <button type="button" class="remove-section text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Section Name</label>
                            <input type="text" name="new_tickets[${sectionCount}][section]" placeholder="e.g. VIP"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Ticket Type</label>
                            <input type="text" name="new_tickets[${sectionCount}][type]" placeholder="e.g. Student"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Price (RM)</label>
                            <input type="number" name="new_tickets[${sectionCount}][price]" step="0.01" min="0" placeholder="0.00"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Rows</label>
                            <input type="number" name="new_tickets[${sectionCount}][rows]" min="1" placeholder="1"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Seats/Row</label>
                            <input type="number" name="new_tickets[${sectionCount}][seats_per_row]" min="1" placeholder="10"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm py-1">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="new_tickets[${sectionCount}][description]" rows="1" placeholder="Optional details"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white text-sm"></textarea>
                    </div>
                `;

                ticketSections.appendChild(newSection);
                sectionCount++;

                // Add event listener to remove button
                const removeBtn = newSection.querySelector('.remove-section');
                removeBtn.addEventListener('click', function() {
                    newSection.remove();
                });
            });

            // Function to populate the edit form with ticket section data
            window.updateTicketSection = function(section, type, price, description, rows, seatsPerRow) {
                // Switch to the "Add New" tab
                tabNew.click();

                // Fill the first ticket section form with the data
                const ticketSection = document.querySelector('.ticket-section');

                ticketSection.querySelector('input[name="new_tickets[0][section]"]').value = section;
                ticketSection.querySelector('input[name="new_tickets[0][type]"]').value = type;
                ticketSection.querySelector('input[name="new_tickets[0][price]"]').value = price;
                ticketSection.querySelector('textarea[name="new_tickets[0][description]"]').value = description || '';
                ticketSection.querySelector('input[name="new_tickets[0][rows]"]').value = rows;
                ticketSection.querySelector('input[name="new_tickets[0][seats_per_row]"]').value = seatsPerRow;

                // Add a hidden field to mark this as an update
                const hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = 'new_tickets[0][update_section]';
                hiddenField.value = section;
                ticketSection.appendChild(hiddenField);
            };
        });
    </script>
</x-app-layout>
