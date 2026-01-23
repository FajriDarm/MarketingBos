@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 pb-12">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold">Dashboard Super Admin</h1>
                    <p class="text-blue-100 mt-1">Monitoring sistem affiliate & revenue</p>
                </div>
                <div class="text-right bg-blue-500 bg-opacity-30 px-4 py-3 rounded-lg">
                    <p class="text-blue-100 text-sm">Selamat datang,</p>
                    <p class="text-white font-bold" id="adminName">Admin</p>
                    <p class="text-blue-100 text-xs mt-1" id="currentDate"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <!-- KPI Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Revenue Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-emerald-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2" id="totalRevenue">${{ number_format($kpiData['totalRevenue'], 0) }}</p>
                        <p class="text-emerald-600 text-sm mt-2">↑ 12.5% dari bulan lalu</p>
                    </div>
                    <div class="bg-emerald-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Clicks Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Total Clicks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2" id="totalClicks">{{ number_format($kpiData['totalClicks']) }}</p>
                        <p class="text-blue-600 text-sm mt-2">↑ 8.3% dari minggu lalu</p>
                    </div>
                    <div class="bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Earnings Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Total Earnings</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2" id="totalEarnings">${{ number_format($kpiData['totalEarnings'], 0) }}</p>
                        <p class="text-purple-600 text-sm mt-2">↑ 5.2% dari bulan lalu</p>
                    </div>
                    <div class="bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Net Revenue Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-pink-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Net Revenue</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2" id="netRevenue">${{ number_format($kpiData['netRevenue'], 0) }}</p>
                        <p class="text-pink-600 text-sm mt-2">Setelah biaya</p>
                    </div>
                    <div class="bg-pink-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Payouts Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Recent Payouts</h3>
                    <p class="text-gray-500 text-sm mt-1">Pembayaran terbaru</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Affiliate</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody id="recentPayoutsTbody" class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700">Loading...</td>
                                <td class="px-6 py-4 text-sm text-gray-700">-</td>
                                <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs">Loading</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Users Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Recent Users</h3>
                    <p class="text-gray-500 text-sm mt-1">User terbaru terdaftar</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Earnings</th>
                            </tr>
                        </thead>
                        <tbody id="recentUsersTbody" class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700">Loading...</td>
                                <td class="px-6 py-4 text-sm text-gray-600">-</td>
                                <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs">-</span></td>
                                <td class="px-6 py-4 text-sm text-gray-700">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    // Set current date
    document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    // Get user info from localStorage
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    document.getElementById('adminName').textContent = user.name || 'Admin';

    // Get data from server
    const recentPayouts = @json($recentPayouts);
    const recentUsers = @json($recentUsers);

    // Update KPI Cards (simple, no animation)
    document.getElementById('totalRevenue').textContent = `${{ number_format($kpiData['totalRevenue'], 0) }}`;
    document.getElementById('totalClicks').textContent = `{{ number_format($kpiData['totalClicks']) }}`;
    document.getElementById('totalEarnings').textContent = `${{ number_format($kpiData['totalEarnings'], 0) }}`;
    document.getElementById('netRevenue').textContent = `${{ number_format($kpiData['netRevenue'], 0) }}`;

    // Populate Recent Payouts Table
    const payoutsHtml = recentPayouts.map(payout => `
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-sm font-medium text-gray-800">${payout.name}</td>
            <td class="px-6 py-4 text-sm text-gray-800">$${payout.amount.toLocaleString('en-US', { minimumFractionDigits: 2 })}</td>
            <td class="px-6 py-4 text-sm">
                <span class="px-2 py-1 ${
                    payout.status === 'Paid' ? 'bg-emerald-100 text-emerald-800' :
                    payout.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                    'bg-blue-100 text-blue-800'
                } rounded text-xs font-medium">${payout.status}</span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-600">${payout.date}</td>
        </tr>
    `).join('');
    document.getElementById('recentPayoutsTbody').innerHTML = payoutsHtml || '<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No payouts yet</td></tr>';

    // Populate Recent Users Table
    const usersHtml = recentUsers.map(userItem => `
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-sm font-medium text-gray-800">${userItem.name}</td>
            <td class="px-6 py-4 text-sm text-gray-600">${userItem.email}</td>
            <td class="px-6 py-4 text-sm">
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium capitalize">${userItem.role}</span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-800 font-medium">$${userItem.earnings.toLocaleString('en-US', { minimumFractionDigits: 2 })}</td>
        </tr>
    `).join('');
    document.getElementById('recentUsersTbody').innerHTML = usersHtml || '<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No users yet</td></tr>';
</script>
@endsection
