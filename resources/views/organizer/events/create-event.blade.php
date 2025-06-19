<x-app-layout>
    <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900">
        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl overflow-hidden">
                    <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                        <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                        <h1 class="text-3xl font-extrabold text-center text-white tracking-wide">
                            Register New Event
                        </h1>
                    </div>

                    <div class="p-8 space-y-8">
                        <form action="{{ route('organizer.store.event') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-10">
                            @csrf

                            <section>
                                <h2
                                    class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Event Details
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label for="name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event
                                            Name</label>
                                        <input type="text" id="name" name="name" required
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="description"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                        <textarea id="description" name="description" rows="4" required
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent resize-none"></textarea>
                                    </div>

                                    <div>
                                        <label for="date"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event
                                            Date & Time</label>
                                        <input type="datetime-local" id="date" name="date" required
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                    </div>

                                    <div>
                                        <label for="location"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                                        <input type="text" id="location" name="location" required
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="organizer_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Organizer</label>
                                        <input type="text" id="organizer_name" name="organizer_name" required
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                    </div>

                                    <div>
                                        <label for="poster"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event
                                            Poster</label>
                                        <input type="file" id="poster" name="poster" accept="image/*"
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                    </div>

                                    <div>
                                        <label for="supporting_doc"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Supporting
                                            Document</label>
                                        <input type="file" id="supporting_doc" name="supporting_docs"
                                            accept="image/*"
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                    </div>
                                </div>
                            </section>

                            <section>
                                <h2
                                    class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Payment Information
                                </h2>

                                <div>
                                    <label for="qr_code"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">QR
                                        Code</label>
                                    <input type="file" id="qr_code" name="qr_code" accept="image/*"
                                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                </div>
                                <div class="mt-4">
                                    <label for="payment_details"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment
                                        Details</label>
                                    <textarea id="payment_details" name="payment_details" rows="3"
                                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent resize-none"></textarea>
                                </div>

                            </section>

                            <!-- Refund Information Section -->
                            <section>
                                <h2
                                    class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Refund Information
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="refund_type"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Refund
                                            Type</label>
                                        <select id="refund_type" name="refund_type" required
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent">
                                            <option value="" disabled selected hidden>Please select a refund type
                                            </option>
                                            <option value="full">Full Refund</option>
                                            <option value="partial">Partial Refund</option>
                                            <option value="no_refund">No Refund</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="refund_policy"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Refund
                                            Policy</label>
                                        <textarea id="refund_policy" name="refund_policy" rows="3"
                                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent resize-none"></textarea>
                                    </div>
                                </div>
                            </section>

                            <!-- Ticket Information Section -->
                            <section>
                                <h2
                                    class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                                    Ticket Information
                                </h2>

                                <div id="ticket-sections" class="space-y-6">
                                    <div class="ticket-section bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Section
                                                    Name</label>
                                                <input type="text" name="tickets[0][section]" required
                                                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ticket
                                                    Type</label>
                                                <input type="text" name="tickets[0][type]" required
                                                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price</label>
                                                <input type="number" name="tickets[0][price]" required
                                                    step="0.01" min="0"
                                                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Seating</label>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <input type="number" name="tickets[0][rows]" required
                                                        min="1" placeholder="Rows"
                                                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                                    <input type="number" name="tickets[0][seats_per_row]" required
                                                        min="1" placeholder="Seats/Row"
                                                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent" />
                                                </div>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                                <textarea name="tickets[0][description]" rows="3"
                                                    class="w-full rounded-md border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-unimasblue focus:border-transparent resize-none"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-between items-center">
                                    <button type="button" id="add-section-btn"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-unimasblue">
                                        + Add Section
                                    </button>

                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-unimasblue hover:bg-unimasblue-dark text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-unimasblue">
                                        Register Event
                                    </button>
                                </div>
                            </section>
                        </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addSectionBtn = document.getElementById('add-section-btn');
        const ticketSections = document.getElementById('ticket-sections');
        let sectionCount = 1;

        addSectionBtn.addEventListener('click', function() {
            const newSection = document.createElement('div');
            newSection.className = 'ticket-section bg-gray-50 dark:bg-gray-700 p-3 rounded-lg';
            newSection.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="md:col-span-2 flex justify-between items-center">
                        <h3 class="text-sm font-medium">Section ${sectionCount + 1}</h3>
                        <button type="button" class="remove-section text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Section Name:</label>
                        <input type="text" name="tickets[${sectionCount}][section]" required
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Ticket Type:</label>
                        <input type="text" name="tickets[${sectionCount}][type]" required
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Price:</label>
                        <input type="number" name="tickets[${sectionCount}][price]" required step="0.01" min="0"
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Seating:</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="tickets[${sectionCount}][rows]" required min="1" placeholder="Rows"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                            <input type="number" name="tickets[${sectionCount}][seats_per_row]" required min="1" placeholder="Seats/Row"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Description:</label>
                        <textarea name="tickets[${sectionCount}][description]" rows="2"
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200"></textarea>
                    </div>
                </div>
            `;

            ticketSections.appendChild(newSection);
            sectionCount++;

            // Add remove functionality
            newSection.querySelector('.remove-section').addEventListener('click', function() {
                this.closest('.ticket-section').remove();
            });
        });
    });

    const refundTypeSelect = document.getElementById('refund_type');
    const refundPolicyDiv = refundTypeSelect.closest('.grid').querySelector('textarea#refund_policy').parentElement;
    const refundPolicyTextarea = document.getElementById('refund_policy');

    function toggleRefundPolicyVisibility() {
        if (refundTypeSelect.value === '' || refundTypeSelect.value === 'no_refund') {
            refundPolicyDiv.style.display = 'none';
            refundPolicyTextarea.value = ''; // Clear when hidden (optional)
        } else {
            refundPolicyDiv.style.display = 'block';
        }
    }

    // Initialize visibility on page load
    toggleRefundPolicyVisibility();

    // Listen for changes on refund type select
    refundTypeSelect.addEventListener('change', toggleRefundPolicyVisibility);
</script>
