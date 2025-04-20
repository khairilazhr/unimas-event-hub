{{-- resources/views/organizer/events/edit-event.blade.php --}}
<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow py-6 sm:py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                            Edit Event
                        </h1>
                    </div>

                    <div class="p-4 sm:p-6 md:p-8">
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400">
                                <ul class="list-disc pl-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('organizer.update.event', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PATCH')

<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                                <!-- Event Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                </div>

                                <!-- Event Date -->
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event Date</label>
                                    <input type="datetime-local" name="date" id="date" value="{{ old('date', date('Y-m-d\TH:i', strtotime($event->date))) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                </div>

                                <!-- Location -->
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                </div>

                                <!-- Organizer Name -->
                                <div>
                                    <label for="organizer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Organizer Name</label>
                                    <input type="text" name="organizer_name" id="organizer_name" value="{{ old('organizer_name', $event->organizer_name) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                </div>
                            </div>

                            <!-- Description -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">{{ old('description', $event->description) }}</textarea>
                            </div>

                            <!-- Event Poster -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                                <label for="poster" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Event Poster (Leave empty to keep current poster)
                                </label>

                                @if($event->poster)
                                <div class="mt-2 mb-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current poster:</p>
                                    <img src="{{ asset('storage/' . $event->poster) }}" alt="Event poster" class="w-40 h-auto rounded-md shadow-sm">
                                </div>
                                @endif

                                <input type="file" name="poster" id="poster"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum file size: 2MB. Recommended size: 1200x630px</p>
                            </div>

                            <!-- Ticket Management Section -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow-sm">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Ticket Management</h2>

                                <!-- Tickets already created -->
                                @if($ticketSections = $event->tickets->groupBy('section'))
                                <div class="mb-6">
                                    <h3 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-2">Current Ticket Sections</h3>

                                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Section</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rows</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Seats</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Available</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
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
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $section }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $firstTicket->type }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ number_format($firstTicket->price, 2) }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $rows }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $seatsPerRow }} per row</td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $availableCount }} / {{ $tickets->count() }}</td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                            @if($availableCount == $tickets->count())
                                                                <button type="button"
                                                                    onclick="updateTicketSection('{{ $section }}', '{{ $firstTicket->type }}', {{ $firstTicket->price }}, '{{ $firstTicket->description }}', {{ $rows }}, {{ $seatsPerRow }})"
                                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-2">
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
                                </div>
                                @endif

                                <!-- Add New Ticket Section -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-2">Add New Ticket Section</h3>

                                    <div id="ticket-sections">
                                        <div class="ticket-section bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg mb-4">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section Name</label>
                                                    <input type="text" name="new_tickets[0][section]" placeholder="e.g. VIP, General Admission"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ticket Type</label>
                                                    <input type="text" name="new_tickets[0][type]" placeholder="e.g. Regular, Student"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price (RM)</label>
                                                    <input type="number" name="new_tickets[0][price]" step="0.01" min="0" placeholder="0.00"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Rows</label>
                                                    <input type="number" name="new_tickets[0][rows]" min="1" placeholder="1"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seats per Row</label>
                                                    <input type="number" name="new_tickets[0][seats_per_row]" min="1" placeholder="10"
                                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description (Optional)</label>
                                                <textarea name="new_tickets[0][description]" rows="2" placeholder="Describe the benefits or details of this ticket type"
                                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="add-ticket-section"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-unimasblue">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add Another Ticket Section
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('organizer.events') }}"
                                    class="inline-flex items-center px-4 py-2 mr-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-unimasblue">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-unimasblue hover:bg-unimasblue/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-unimasblue">
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
            let sectionCount = 1;

            addSectionBtn.addEventListener('click', function() {
                const newSection = document.createElement('div');
                newSection.className = 'ticket-section bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg mb-4';
                newSection.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Ticket Section ${sectionCount + 1}</h4>
                        <button type="button" class="remove-section text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section Name</label>
                            <input type="text" name="new_tickets[${sectionCount}][section]" placeholder="e.g. VIP, General Admission"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ticket Type</label>
                            <input type="text" name="new_tickets[${sectionCount}][type]" placeholder="e.g. Regular, Student"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price (RM)</label>
                            <input type="number" name="new_tickets[${sectionCount}][price]" step="0.01" min="0" placeholder="0.00"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Rows</label>
                            <input type="number" name="new_tickets[${sectionCount}][rows]" min="1" placeholder="1"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seats per Row</label>
                            <input type="number" name="new_tickets[${sectionCount}][seats_per_row]" min="1" placeholder="10"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description (Optional)</label>
                        <textarea name="new_tickets[${sectionCount}][description]" rows="2" placeholder="Describe the benefits or details of this ticket type"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-unimasblue focus:ring focus:ring-unimasblue focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"></textarea>
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

                // Scroll to the form
                ticketSection.scrollIntoView({ behavior: 'smooth' });
            };
        });
    </script>
</x-app-layout>
