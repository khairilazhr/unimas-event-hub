<x-app-layout>
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900">
        <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <!-- Page Header -->
                <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden mb-8">
                    <div class="bg-unimasblue p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">Manage Attendance</h1>
                            <div class="flex gap-2">
                                <a href="{{ route('organizer.attendances.history') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white text-unimasblue font-semibold rounded-lg shadow hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 17l4 4 4-4m0-5V3m-8 4h8" />
                                    </svg>
                                    Attendance History
                                </a>
                                <a href="{{ route('organizer.dashboard') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white text-unimasblue font-semibold rounded-lg shadow hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Dashboard
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Scanner Section -->
                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- QR Scanner -->
                            <div
                                class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">QR Code Scanner
                                </h2>

                                <div
                                    class="aspect-square bg-black rounded-lg overflow-hidden mb-4 w-full max-w-[400px] mx-auto">
                                    <div id="qr-video" class="w-full h-full"></div>
                                </div>

                                <div class="flex justify-center space-x-4">
                                    <button id="startButton"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        Start Scanner
                                    </button>
                                    <button id="stopButton"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                        disabled>
                                        Stop Scanner
                                    </button>
                                </div>
                            </div>

                            <!-- Scan Result -->
                            <div
                                class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Scan Result</h2>

                                <div id="scanResult" class="hidden">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 mb-4">
                                        <div class="space-y-3">
                                            <div>
                                                <label class="text-sm text-gray-500">Attendee Name</label>
                                                <p id="attendeeName" class="font-medium text-gray-900 dark:text-white">
                                                </p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-500">Event</label>
                                                <p id="eventName" class="font-medium text-gray-900 dark:text-white"></p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-4">
                                                <div>
                                                    <label class="text-sm text-gray-500">Section</label>
                                                    <p id="section" class="font-medium text-gray-900 dark:text-white">
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-sm text-gray-500">Row</label>
                                                    <p id="row" class="font-medium text-gray-900 dark:text-white">
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="text-sm text-gray-500">Seat</label>
                                                    <p id="seat" class="font-medium text-gray-900 dark:text-white">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="statusBadge" class="mb-4"></div>

                                    <button id="markAttendanceBtn"
                                        class="w-full px-4 py-2 bg-unimasblue text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Mark Attendance
                                    </button>
                                </div>

                                <div id="noScanResult" class="text-center py-8">
                                    <p class="text-gray-500 dark:text-gray-400">No QR code scanned yet</p>
                                </div>
                            </div>
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

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let html5QrcodeScanner = null;
            let currentRegistrationId = null;

            const startButton = document.getElementById('startButton');
            const stopButton = document.getElementById('stopButton');
            const scanResult = document.getElementById('scanResult');
            const noScanResult = document.getElementById('noScanResult');
            const markAttendanceBtn = document.getElementById('markAttendanceBtn');

            async function startCamera() {
                try {
                    const devices = await Html5Qrcode.getCameras();
                    if (devices && devices.length) {
                        const html5QrCode = new Html5Qrcode("qr-video");
                        await html5QrCode.start({
                                facingMode: "environment"
                            }, {
                                fps: 10,
                                qrbox: {
                                    width: 250,
                                    height: 250
                                },
                                aspectRatio: 1.0
                            },
                            (decodedText) => {
                                handleQrCode(decodedText);
                                html5QrCode.pause();
                            },
                            (errorMessage) => {
                                // Handle errors silently
                            }
                        );

                        html5QrcodeScanner = html5QrCode;
                        startButton.disabled = true;
                        stopButton.disabled = false;
                    } else {
                        alert('No cameras found on your device');
                    }
                } catch (err) {
                    console.error('Error starting camera:', err);
                    alert('Error accessing camera. Please ensure camera permissions are granted.');
                }
            }

            function handleQrCode(decodedText) {
                try {
                    // Decode the base64 string to get the JSON
                    const decodedData = JSON.parse(atob(decodedText));

                    if (!decodedData.type || !decodedData.registration_id) {
                        throw new Error('Invalid QR code format');
                    }

                    currentRegistrationId = decodedData.registration_id;

                    // Fetch registration details using registration ID
                    fetch(`/verify-ticket/${currentRegistrationId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.valid) {
                                // Update the UI with the registration information
                                document.getElementById('attendeeName').textContent = data.registration.name;
                                document.getElementById('eventName').textContent = data.registration.event.name;
                                document.getElementById('section').textContent = data.registration.ticket
                                    .section;
                                document.getElementById('row').textContent = data.registration.ticket.row;
                                document.getElementById('seat').textContent = data.registration.ticket.seat;

                                // Add status badge
                                const statusBadge = document.getElementById('statusBadge');
                                statusBadge.innerHTML = `
                                    <span class="px-2 py-1 text-sm font-medium rounded-full ${
                                        data.registration.status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                                    }">
                                        ${data.registration.status.charAt(0).toUpperCase() + data.registration.status.slice(1)}
                                    </span>
                                `;

                                // Show the scan result
                                scanResult.classList.remove('hidden');
                                noScanResult.classList.add('hidden');
                            } else {
                                throw new Error('Invalid or expired ticket');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching details:', error);
                            alert('Error verifying ticket. Please try scanning again.');
                        });
                } catch (error) {
                    console.error('Error parsing QR code:', error);
                    alert('Invalid QR code. Please try scanning again.');
                }
            }

            // Start Scanner Button
            startButton.addEventListener('click', startCamera);

            // Stop Scanner Button
            stopButton.addEventListener('click', function() {
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then(() => {
                        startButton.disabled = false;
                        stopButton.disabled = true;
                        scanResult.classList.add('hidden');
                        noScanResult.classList.remove('hidden');
                    }).catch((err) => {
                        console.error('Error stopping camera:', err);
                    });
                }
            });

            // Mark Attendance Button
            markAttendanceBtn.addEventListener('click', function() {
                if (currentRegistrationId) {
                    fetch(`/mark-attendance/${currentRegistrationId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                registration_id: currentRegistrationId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Attendance marked successfully!');
                                scanResult.classList.add('hidden');
                                noScanResult.classList.remove('hidden');
                                if (html5QrcodeScanner) {
                                    html5QrcodeScanner.resume();
                                }
                            } else {
                                throw new Error(data.message || 'Failed to mark attendance');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert(error.message || 'Failed to mark attendance');
                        });
                }
            });
        });
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</x-app-layout>
