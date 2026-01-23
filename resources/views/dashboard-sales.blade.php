@extends('layouts.app')

@section('title', 'Sales Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 pb-12">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold">Sales Dashboard</h1>
            <p class="text-blue-100 mt-1">Monitoring performa penjualan dan konversi</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Sales</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">$28,450</p>
                        <p class="text-xs text-blue-600 mt-2">↑ 15% from last week</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Closed Deals</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">48</p>
                        <p class="text-xs text-green-600 mt-2">↑ 8 deals this week</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Revenue</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">$15,230</p>
                        <p class="text-xs text-purple-600 mt-2">Your commission</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Win Rate</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">68%</p>
                        <p class="text-xs text-orange-600 mt-2">↑ 5% improvement</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Sales Performance</h3>
            <div class="h-80 flex items-center justify-center text-gray-400">
                <p>Sales performance chart will be displayed here (Chart.js)</p>
            </div>
        </div>

        <!-- Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Sales Opportunities</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deal Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">Tech Startup Inc.</td>
                                <td class="px-6 py-4 text-sm text-gray-800">$15,000</td>
                                <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Closed</span></td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">Global Corp</td>
                                <td class="px-6 py-4 text-sm text-gray-800">$8,500</td>
                                <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Negotiation</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Top Products</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sales</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Earnings</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">Premium Package</td>
                                <td class="px-6 py-4 text-sm text-gray-800">24</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">$4,800</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">Basic Package</td>
                                <td class="px-6 py-4 text-sm text-gray-800">32</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">$3,200</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
