<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Affillink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold text-gray-800">Affillink</h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition">Dashboard</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition">Affiliates</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition">Reports</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:block">
                        <p id="userNameDisplay" class="text-gray-700 font-medium"></p>
                        <p class="text-gray-500 text-sm" id="userEmailDisplay"></p>
                    </div>
                    <button onclick="logout()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome to Affillink Dashboard</h2>
            <p class="text-gray-600">Manage your affiliate account and track your earnings</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Commission -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-medium">Total Commission</h3>
                    <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.16 2.75a.75.75 0 00-.75.75v8.5h-3a.75.75 0 000 1.5h3v3a.75.75 0 001.5 0v-3h3a.75.75 0 000-1.5h-3V3.5a.75.75 0 00-.75-.75zM15 3.75a.75.75 0 011.5 0v12.5a.75.75 0 01-1.5 0V3.75z"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900" id="totalCommission">Rp 0</p>
                <p class="text-gray-500 text-sm mt-2">Lifetime earnings</p>
            </div>

            <!-- Total Withdrawn -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-medium">Total Withdrawn</h3>
                    <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.5 1.5H5.75A2.75 2.75 0 003 4.25v11a2.75 2.75 0 002.75 2.75h8.5a2.75 2.75 0 002.75-2.75v-8.5m.75-5.75h-2.5m0 0l.75-.75m-.75.75l-.75.75"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900" id="totalWithdrawn">Rp 0</p>
                <p class="text-gray-500 text-sm mt-2">Amount withdrawn</p>
            </div>

            <!-- Active Links -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-medium">Active Links</h3>
                    <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM9.172 9.172a2 2 0 012.828 0l.793.793 2.828-2.828-.793-.793a4 4 0 00-5.656 0l-.828.828-2.828-2.828.828-.828a6 6 0 018.485 0l.828.828 2.828-2.828-.828-.828a8 8 0 00-11.314 0l-.828.828L1.172 2.172a2 2 0 112.828 2.828l2.828 2.828.172-.172a4 4 0 015.656 0l2.828 2.828.172.172-2.828 2.828z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900" id="activeLinks">0</p>
                <p class="text-gray-500 text-sm mt-2">Active affiliate links</p>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Account Information</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 text-gray-600 font-medium">Field</th>
                            <th class="text-left py-3 px-4 text-gray-600 font-medium">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-gray-700">Name</td>
                            <td class="py-3 px-4 text-gray-900 font-medium" id="displayName">-</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-gray-700">Email</td>
                            <td class="py-3 px-4 text-gray-900 font-medium" id="displayEmail">-</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-gray-700">Role</td>
                            <td class="py-3 px-4 text-gray-900 font-medium" id="displayRole">-</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-gray-700">Commission Rate</td>
                            <td class="py-3 px-4 text-gray-900 font-medium" id="displayCommissionRate">-</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 text-gray-700">Account Status</td>
                            <td class="py-3 px-4"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Active</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Load user data from localStorage
        function loadUserData() {
            const user = JSON.parse(localStorage.getItem('user'));
            const token = localStorage.getItem('token');

            if (!user || !token) {
                window.location.href = '/login';
                return;
            }

            // Display user information
            document.getElementById('userNameDisplay').textContent = user.name;
            document.getElementById('userEmailDisplay').textContent = user.email;
            document.getElementById('displayName').textContent = user.name;
            document.getElementById('displayEmail').textContent = user.email;
            document.getElementById('displayRole').textContent = user.role || 'Affiliate';
            document.getElementById('displayCommissionRate').textContent = (user.commission_rate || 0) + '%';

            // Fetch additional user data from API
            fetchUserData();
        }

        // Fetch user data from API
        async function fetchUserData() {
            const token = localStorage.getItem('token');

            try {
                const response = await fetch('/api/me', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    const user = data.user;
                    document.getElementById('totalCommission').textContent = 'Rp ' + (user.total_commission || 0).toLocaleString('id-ID');
                    document.getElementById('totalWithdrawn').textContent = 'Rp ' + (user.total_withdrawn || 0).toLocaleString('id-ID');
                } else {
                    console.error('Failed to fetch user data');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Logout function
        async function logout() {
            if (!confirm('Are you sure you want to logout?')) return;

            const token = localStorage.getItem('token');

            try {
                const response = await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.ok) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    window.location.href = '/login';
                }
            } catch (error) {
                console.error('Error:', error);
                // Still logout on error
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.href = '/login';
            }
        }

        // Load user data on page load
        loadUserData();
    </script>
</body>
</html>
