<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" onsubmit="return validateForm()">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                    autocomplete="new-password" onkeyup="validatePassword()" />
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500"
                    onclick="togglePasswordVisibility('password', 'eyeIcon1', 'eyeOffIcon1')">
                    <!-- Eye Icon -->
                    <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Eye Off Icon -->
                    <svg id="eyeOffIcon1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.973 9.973 0 012.642-4.362M3 3l18 18M17.94 17.94A9.96 9.96 0 0019.542 12a9.973 9.973 0 00-2.642-4.362M9.88 9.88a3 3 0 104.243 4.243" />
                    </svg>
                </button>
            </div>

            <!-- Password Strength Indicator -->
            <div class="mt-2">
                <div class="flex items-center space-x-2">
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div id="passwordStrength" class="h-2 rounded-full transition-all duration-300"
                            style="width: 0%"></div>
                    </div>
                    <span id="passwordStrengthText" class="text-sm text-gray-500">Weak</span>
                </div>

                <!-- Password Requirements -->
                <div class="mt-2 text-sm text-gray-600">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                        <div id="reqLength" class="flex items-center">
                            <span id="reqLengthIcon" class="text-red-500 mr-1">✗</span>
                            <span>At least 8 characters</span>
                        </div>
                        <div id="reqUppercase" class="flex items-center">
                            <span id="reqUppercaseIcon" class="text-red-500 mr-1">✗</span>
                            <span>One uppercase letter</span>
                        </div>
                        <div id="reqLowercase" class="flex items-center">
                            <span id="reqLowercaseIcon" class="text-red-500 mr-1">✗</span>
                            <span>One lowercase letter</span>
                        </div>
                        <div id="reqNumber" class="flex items-center">
                            <span id="reqNumberIcon" class="text-red-500 mr-1">✗</span>
                            <span>One number</span>
                        </div>
                        <div id="reqSpecial" class="flex items-center">
                            <span id="reqSpecialIcon" class="text-red-500 mr-1">✗</span>
                            <span>One special character (@$!%*?&)</span>
                        </div>
                    </div>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password"
                    name="password_confirmation" required autocomplete="new-password" onkeyup="checkPasswordMatch()" />
                <button type="button" id="togglePasswordConfirmation"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500"
                    onclick="togglePasswordVisibility('password_confirmation', 'eyeIcon2', 'eyeOffIcon2')">
                    <!-- Eye Icon -->
                    <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Eye Off Icon -->
                    <svg id="eyeOffIcon2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.973 9.973 0 012.642-4.362M3 3l18 18M17.94 17.94A9.96 9.96 0 0019.542 12a9.973 9.973 0 00-2.642-4.362M9.88 9.88a3 3 0 104.243 4.243" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

            <!-- Password Match Indicator -->
            <div id="passwordMatchIndicator" class="mt-2 text-sm hidden">
                <span id="passwordMatchText" class="flex items-center">
                    <span id="passwordMatchIcon" class="mr-1"></span>
                    <span id="passwordMatchMessage"></span>
                </span>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function togglePasswordVisibility(inputId, eyeId, eyeOffId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeId);
            const eyeOffIcon = document.getElementById(eyeOffId);

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        function validatePassword() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('passwordStrengthText');

            // Password requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[@$!%*?&]/.test(password);

            // Update requirement indicators
            updateRequirement('reqLength', 'reqLengthIcon', hasLength);
            updateRequirement('reqUppercase', 'reqUppercaseIcon', hasUppercase);
            updateRequirement('reqLowercase', 'reqLowercaseIcon', hasLowercase);
            updateRequirement('reqNumber', 'reqNumberIcon', hasNumber);
            updateRequirement('reqSpecial', 'reqSpecialIcon', hasSpecial);

            // Calculate strength
            let strength = 0;
            if (hasLength) strength += 20;
            if (hasUppercase) strength += 20;
            if (hasLowercase) strength += 20;
            if (hasNumber) strength += 20;
            if (hasSpecial) strength += 20;

            // Update strength bar
            strengthBar.style.width = strength + '%';

            // Update strength text and color
            if (strength <= 20) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-red-500';
                strengthText.textContent = 'Very Weak';
                strengthText.className = 'text-sm text-red-500';
            } else if (strength <= 40) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-orange-500';
                strengthText.textContent = 'Weak';
                strengthText.className = 'text-sm text-orange-500';
            } else if (strength <= 60) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-yellow-500';
                strengthText.textContent = 'Fair';
                strengthText.className = 'text-sm text-yellow-500';
            } else if (strength <= 80) {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-blue-500';
                strengthText.textContent = 'Good';
                strengthText.className = 'text-sm text-blue-500';
            } else {
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-green-500';
                strengthText.textContent = 'Strong';
                strengthText.className = 'text-sm text-green-500';
            }

            // Also check password match when main password changes
            checkPasswordMatch();
        }

        function updateRequirement(reqId, iconId, isValid) {
            const icon = document.getElementById(iconId);
            if (isValid) {
                icon.textContent = '✓';
                icon.className = 'text-green-500 mr-1';
            } else {
                icon.textContent = '✗';
                icon.className = 'text-red-500 mr-1';
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const indicator = document.getElementById('passwordMatchIndicator');
            const icon = document.getElementById('passwordMatchIcon');
            const message = document.getElementById('passwordMatchMessage');

            if (passwordConfirmation === '') {
                indicator.classList.add('hidden');
                return;
            }

            indicator.classList.remove('hidden');

            if (password === passwordConfirmation) {
                icon.textContent = '✓';
                icon.className = 'text-green-500 mr-1';
                message.textContent = 'Passwords match';
                message.className = 'text-green-500';
            } else {
                icon.textContent = '✗';
                icon.className = 'text-red-500 mr-1';
                message.textContent = 'Passwords do not match';
                message.className = 'text-red-500';
            }
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Check password requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[@$!%*?&]/.test(password);

            // Check if passwords match
            const passwordsMatch = password === passwordConfirmation;

            if (!hasLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecial) {
                alert('Please ensure your password meets all requirements.');
                return false;
            }

            if (!passwordsMatch) {
                alert('Passwords do not match.');
                return false;
            }

            return true;
        }
    </script>
</x-guest-layout>
