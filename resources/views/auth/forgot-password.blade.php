<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Affillink</title>
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
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="glass-effect rounded-2xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-8">
                <div class="flex justify-center mb-1">
                    <img src="{{ asset('images/logoAffilllink2.png') }}" alt="Affillink Logo" class="w-52 h-auto object-contain">
                </div>
                <p class="text-gray-600 text-sm">Forgot your password?</p>
                <p class="text-gray-500 text-xs">Enter your email to reset your password</p>
            </div>
            <form id="forgotForm" class="space-y-5">
                @csrf
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
                        <input type="email" id="email" name="email" placeholder="your@email.com" class="input-focus w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg transition focus:outline-none" required>
                    </div>
                    <span class="error-email text-red-500 text-sm mt-1 hidden"></span>
                </div>
                <button type="submit" class="btn-primary w-full py-3 rounded-lg text-white font-semibold text-lg mt-6 transition">
                    Send Reset Link
                </button>
            </form>
            <p class="text-center text-gray-600 text-sm mt-6">
                Remember your password?
                <a href="{{ route('auth.login') }}" class="text-green-600 hover:text-green-700 font-semibold transition">
                    Log In
                </a>
            </p>
        </div>
        <p class="text-center text-gray-300 text-xs mt-8">
            © 2026 Affillink. All rights reserved.
        </p>
    </div>
    <script>
        document.getElementById('forgotForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            document.querySelector('.error-email').classList.add('hidden');
            const email = document.getElementById('email').value;
            try {
                const response = await fetch('/api/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({ email })
                });
                const data = await response.json();
                if (response.ok) {
                    alert('Reset link sent! Please check your email.');
                    window.location.href = '/login';
                } else {
                    if (data.errors && data.errors.email) {
                        document.querySelector('.error-email').textContent = data.errors.email[0];
                        document.querySelector('.error-email').classList.remove('hidden');
                    } else if (data.message) {
                        alert(data.message);
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
        document.getElementById('email').addEventListener('input', () => {
            document.querySelector('.error-email').classList.add('hidden');
        });
    </script>
</body>
</html>
