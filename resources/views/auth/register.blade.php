<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Affillink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #1E3A5F 0%, #4CAF50 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            animation: fadeInUp 1s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            border-color: #4CAF50;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            animation: bounceIn 0.8s 0.2s both;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            60% {
                opacity: 1;
                transform: scale(1.05);
            }
            80% {
                transform: scale(0.97);
            }
            100% {
                transform: scale(1);
            }
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.04) rotate(-1deg);
            box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0) scale(0.98);
        }

        .eye-icon {
            cursor: pointer;
            color: #999;
        }

        .eye-icon:hover {
            color: #4CAF50;
        }

        .password-strength {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
        }

        .strength-weak {
            background: #ef4444;
            width: 33%;
        }

        .strength-fair {
            background: #f59e0b;
            width: 66%;
        }

        .strength-strong {
            background: #10b981;
            width: 100%;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 py-12">
    <div class="w-full max-w-md">
        <!-- Card -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 md:p-10">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/logoAffilllink2.png') }}" alt="Affillink Logo" class="w-52 h-auto object-contain">
                </div>
                <p class="text-gray-600 text-sm">Join Our Affiliate Network</p>
                <p class="text-gray-500 text-xs">Create your account and start earning</p>
            </div>

            <!-- Form -->
            <form id="registerForm" class="space-y-4">
                @csrf

                <!-- Full Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" id="name" name="name" placeholder="Full Name" 
                            class="input-focus w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg transition focus:outline-none"
                            required>
                    </div>
                    <span class="error-name text-red-500 text-sm mt-1 hidden"></span>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" placeholder="your@email.com" 
                            class="input-focus w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg transition focus:outline-none"
                            required>
                    </div>
                    <span class="error-email text-red-500 text-sm mt-1 hidden"></span>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="••••••••" 
                            class="input-focus w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-lg transition focus:outline-none"
                            required>
                        <button type="button" class="eye-icon absolute inset-y-0 right-0 pr-4 flex items-center" onclick="togglePassword('password')">
                            <svg class="toggle-eye-icon-1 w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.5 1h-8C6.12 1 5 2.12 5 3.5v17C5 21.88 6.12 23 7.5 23h8c1.38 0 2.5-1.12 2.5-2.5v-17C18 2.12 16.88 1 15.5 1zm-4 21c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm4-4H7V4h12v14z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    <span class="error-password text-red-500 text-sm mt-1 hidden"></span>
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" 
                            class="input-focus w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-lg transition focus:outline-none"
                            required>
                        <button type="button" class="eye-icon absolute inset-y-0 right-0 pr-4 flex items-center" onclick="togglePassword('password_confirmation')">
                            <svg class="toggle-eye-icon-2 w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.5 1h-8C6.12 1 5 2.12 5 3.5v17C5 21.88 6.12 23 7.5 23h8c1.38 0 2.5-1.12 2.5-2.5v-17C18 2.12 16.88 1 15.5 1zm-4 21c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm4-4H7V4h12v14z"/>
                            </svg>
                        </button>
                    </div>
                    <span class="error-password_confirmation text-red-500 text-sm mt-1 hidden"></span>
                </div>

                <!-- Terms & Conditions -->
                <label class="flex items-start cursor-pointer mt-4">
                    <input type="checkbox" name="agree_terms" class="w-4 h-4 rounded border-gray-300 accent-green-500 mt-1" required>
                    <span class="ml-2 text-xs text-gray-600">
                        I agree to the 
                        <a href="#" class="text-green-600 hover:text-green-700 font-semibold">Terms & Conditions</a> 
                        and 
                        <a href="#" class="text-green-600 hover:text-green-700 font-semibold">Privacy Policy</a>
                    </span>
                </label>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary w-full py-3 rounded-lg text-white font-semibold text-lg mt-6 transition">
                    Create Account
                </button>
            </form>

            <!-- Sign In Link -->
            <p class="text-center text-gray-600 text-sm mt-6">
                Already have an account? 
                <a href="{{ route('auth.login') }}" class="text-green-600 hover:text-green-700 font-semibold transition">
                    Sign In
                </a>
            </p>
        </div>

        <!-- Footer -->
        <p class="text-center text-gray-300 text-xs mt-8">
            © 2026 Affillink. All rights reserved.
        </p>
    </div>

    <script>
        const togglePassword = (fieldId) => {
            const passwordInput = document.getElementById(fieldId);
            const eyeIconClass = fieldId === 'password' ? '.toggle-eye-icon-1' : '.toggle-eye-icon-2';
            const toggleEyeIcon = document.querySelector(eyeIconClass);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleEyeIcon.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
            } else {
                passwordInput.type = 'password';
                toggleEyeIcon.innerHTML = '<path d="M15.5 1h-8C6.12 1 5 2.12 5 3.5v17C5 21.88 6.12 23 7.5 23h8c1.38 0 2.5-1.12 2.5-2.5v-17C18 2.12 16.88 1 15.5 1zm-4 21c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm4-4H7V4h12v14z"/>';
            }
        };

        // Password strength indicator
        document.getElementById('password').addEventListener('input', (e) => {
            const password = e.target.value;
            const strengthBar = document.getElementById('strengthBar');
            let strength = 0;

            // Check password strength
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[\W_]+/)) strength += 1;

            // Update strength bar
            strengthBar.className = 'password-strength-bar transition-all';
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength <= 3) {
                strengthBar.classList.add('strength-fair');
            } else {
                strengthBar.classList.add('strength-strong');
            }

            // Clear error
            document.querySelector('.error-password').classList.add('hidden');
        });

        // Handle form submission
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            // Clear all previous errors
            document.querySelectorAll('[class*="error-"]').forEach(el => {
                el.classList.add('hidden');
            });
            
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value,
            };

            // Validate password match
            if (formData.password !== formData.password_confirmation) {
                document.querySelector('.error-password_confirmation').textContent = 'Passwords do not match';
                document.querySelector('.error-password_confirmation').classList.remove('hidden');
                return;
            }

            try {
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    // Show success message
                    alert('Registration successful! Please login with your credentials.');
                    
                    // Redirect to login page
                    window.location.href = '/login';
                } else {
                    // Show errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.querySelector(`.error-${field}`);
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                                errorElement.classList.remove('hidden');
                            }
                        });
                    }
                    if (data.message) {
                        alert(data.message);
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });

        // Clear error messages when user starts typing
        document.getElementById('name').addEventListener('input', () => {
            document.querySelector('.error-name').classList.add('hidden');
        });

        document.getElementById('email').addEventListener('input', () => {
            document.querySelector('.error-email').classList.add('hidden');
        });

        document.getElementById('password_confirmation').addEventListener('input', () => {
            document.querySelector('.error-password_confirmation').classList.add('hidden');
        });
    </script>
</body>
</html>
