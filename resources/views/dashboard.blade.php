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
    <!-- Include Dynamic Sidebar -->
    @include('components.sidebar')

    <!-- Main Content with responsive padding -->
    <main class="min-h-screen lg:ml-64 p-4 md:p-6 lg:p-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-2">Selamat datang di Affillink Dashboard</p>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Earnings</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">$5,472.50</p>
                            <p class="text-green-600 text-xs mt-2">↑ 12% from last month</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Clicks</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">12,980</p>
                            <p class="text-green-600 text-xs mt-2">↑ 8% from last month</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Conversion Rate</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">3.8%</p>
                            <p class="text-green-600 text-xs mt-2">↑ 0.5% from last month</p>
                        </div>
                        <div class="bg-cyan-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Sales</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">495</p>
                            <p class="text-green-600 text-xs mt-2">↑ 5% from last month</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Chart 1 -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Performance Overview</h3>
                    <div class="h-64 bg-gray-100 rounded flex items-center justify-center text-gray-500">
                        [Chart Area - Integrate Chart.js or ApexCharts]
                    </div>
                </div>

                <!-- Chart 2 -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Commission Breakdown</h3>
                    <div class="h-64 bg-gray-100 rounded flex items-center justify-center text-gray-500">
                        [Donut Chart Area]
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activities</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4 text-gray-600 font-medium">Type</th>
                                <th class="text-left py-3 px-4 text-gray-600 font-medium">Amount</th>
                                <th class="text-left py-3 px-4 text-gray-600 font-medium">Status</th>
                                <th class="text-left py-3 px-4 text-gray-600 font-medium">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">Commission</td>
                                <td class="py-3 px-4 font-medium">$250.00</td>
                                <td class="py-3 px-4">
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Paid</span>
                                </td>
                                <td class="py-3 px-4 text-gray-600">Jan 20, 2026</td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">Sale</td>
                                <td class="py-3 px-4 font-medium">$150.00</td>
                                <td class="py-3 px-4">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">Completed</span>
                                </td>
                                <td class="py-3 px-4 text-gray-600">Jan 19, 2026</td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">Payout</td>
                                <td class="py-3 px-4 font-medium">$500.00</td>
                                <td class="py-3 px-4">
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                                </td>
                                <td class="py-3 px-4 text-gray-600">Jan 18, 2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Verify user is logged in
        window.addEventListener('load', () => {
            const token = localStorage.getItem('token');
            const user = localStorage.getItem('user');
            
            if (!token || !user) {
                window.location.href = '/login';
            }
        });

        // Logout function
        async function logout() {
            if (!confirm('Yakin ingin logout?')) return;
            const token = localStorage.getItem('token');
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${token}` }
                });
            } catch (error) {
                console.error('Error:', error);
            }
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }
    </script>
</body>
</html>
