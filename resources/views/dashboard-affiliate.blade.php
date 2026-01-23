@extends('layouts.app')

@section('title', 'Affiliate Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 pb-12">
    <!-- Header -->
    <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 text-white p-6 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold">Affiliate Dashboard</h1>
            <p class="text-cyan-100 mt-1">Monitoring pendapatan, klik, dan komisi Anda</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Earnings</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">$12,450</p>
                        <p class="text-xs text-green-600 mt-2">↑ 22% from last month</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Clicks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">8,320</p>
                        <p class="text-xs text-blue-600 mt-2">↑ 18% from last week</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-teal-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Conversion Rate</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">3.8%</p>
                        <p class="text-xs text-teal-600 mt-2">↑ 0.5% improvement</p>
                    </div>
                    <div class="bg-teal-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Sales</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">315</p>
                        <p class="text-xs text-orange-600 mt-2">↑ 42 sales this week</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Performance Overview</h3>
                <div class="h-64 flex items-center justify-center text-gray-400">
                    <p>Performance chart will be displayed here</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Commission Breakdown</h3>
                <div class="h-64 flex items-center justify-center text-gray-400">
                    <p>Donut chart will be displayed here</p>
                </div>
            </div>
        </div>

        <!-- Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Top Campaigns</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clicks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Earnings</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">Summer Sale 2024</td>
                                <td class="px-6 py-4 text-sm text-gray-800">3,240</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">$5,800</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">Flash Deal</td>
                                <td class="px-6 py-4 text-sm text-gray-800">2,890</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">$4,200</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Status Summary</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Approved Commission</span>
                        <span class="text-green-600 font-bold">$8,450</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Pending Commission</span>
                        <span class="text-yellow-600 font-bold">$2,800</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-cyan-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Ready for Withdraw</span>
                        <span class="text-cyan-600 font-bold">$1,200</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
