<x-app-layout>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ 
            show: false,
            refundId: null,
            action: null,
            closeModal() {
                this.show = false;
                this.refundId = null;
                this.action = null;
            }
        }" 
        @keydown.escape.window="closeModal()"
        class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        
        <!-- Main content -->
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-8"> <!-- Added mt-8 class -->
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden">
                <div class="relative bg-unimasblue dark:bg-unimasblue p-6">
                    <div class="absolute inset-0 opacity-10 bg-pattern-grid"></div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-center text-white">
                        Manage Refund Requests
                    </h1>
                </div>

                <div class="p-4 sm:p-6 md:p-8">
                    <!-- Report Button -->
                    <div class="flex justify-end mb-4">
                        <form action="{{ route('organizer.refunds.report') }}" method="GET" target="_blank">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-unimasblue text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Generate Report
                            </button>
                        </form>
                    </div>

                    <!-- Status Filter -->
                    <div class="mb-6">
                        <label for="statusFilter" class="block text-lg font-medium mb-2">Filter by Status:</label>
                        <select id="statusFilter" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    @if($refunds->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="text-gray-400 dark:text-gray-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 text-lg font-medium mb-2">
                                No refund requests yet
                            </p>
                            <p class="text-gray-500 dark:text-gray-400">
                                When users request refunds for your events, they will appear here.
                            </p>
                        </div>
                    @else
                        @foreach($refunds as $eventId => $eventRefunds)
                            @php
                                $event = $eventRefunds->first()->eventRegistration->event;
                            @endphp
                            <div class="mb-8">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-4">
                                    {{ $event->name }}
                                </h2>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ticket Details</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reason</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($eventRefunds as $refund)
                                                <tr data-status="{{ $refund->status }}">
                                                    <td class="px-4 py-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $refund->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $refund->user->email }}
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            {{ $refund->ticket->type }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            Section {{ $refund->ticket->section }} - Row {{ $refund->ticket->row }} - Seat {{ $refund->ticket->seat }}
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <div class="text-sm text-gray-900 dark:text-white">
                                                            {{ Str::limit($refund->refund_reason, 50) }}
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            RM{{ number_format($refund->refund_amount, 2) }}
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            @if($refund->status == 'approved')
                                                                bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                            @elseif($refund->status == 'rejected')
                                                                bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                            @else
                                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                            @endif">
                                                            {{ ucfirst($refund->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        @if($refund->status === 'pending')
                                                            <div class="flex space-x-2">
                                                                <button @click="show = true; refundId = {{ $refund->id }}; action = 'approved'" 
                                                                    class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-sm rounded-md hover:bg-green-200">
                                                                    Approve
                                                                </button>
                                                                <button @click="show = true; refundId = {{ $refund->id }}; action = 'rejected'" 
                                                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-sm rounded-md hover:bg-red-200">
                                                                    Reject
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal -->
        <template x-teleport="body">
            <div x-show="show" 
                x-cloak
                class="fixed inset-0 z-50 overflow-y-auto"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Backdrop -->
                    <div x-show="show" 
                        @click="closeModal()"
                        class="fixed inset-0 transition-opacity"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Modal content -->
                    <div x-show="show" 
                        @click.outside="closeModal()"
                        class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        
                        <form 
                            x-bind:action="`/organizer/refunds/${refundId}`" 
                            method="POST" 
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" x-bind:value="action">
                            
                            <!-- Modal content here -->
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" x-text="action === 'approved' ? 'Approve Refund' : 'Reject Refund'"></h3>
                                        <div class="mt-2">
                                            <textarea name="notes" rows="4" class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white" placeholder="Add notes (optional)"></textarea>
                                        </div>
                                        <div class="mt-4" x-show="action === 'approved'">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Refund Proof (Image or PDF) <span class="text-red-500">*</span></label>
                                            <input type="file" name="refund_proof" accept="image/*,application/pdf" 
                                                class="block w-full text-sm text-gray-900 dark:text-gray-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-unimasblue file:text-white hover:file:bg-blue-700"
                                                :required="action === 'approved'">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modal footer -->
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" 
                                    x-bind:class="{
                                        'bg-green-600 hover:bg-green-700 focus:ring-green-500': action === 'approved',
                                        'bg-red-600 hover:bg-red-700 focus:ring-red-500': action === 'rejected'
                                    }" 
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                    Confirm
                                </button>
                                <button type="button" 
                                    @click="closeModal()"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');
            const rows = document.querySelectorAll('tr[data-status]');

            statusFilter.addEventListener('change', function() {
                const selectedStatus = this.value;
                
                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>