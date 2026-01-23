<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Commission;
use App\Models\User;
use App\Models\PayoutBatch;
use App\Models\PayoutBatchItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        try {
            // Get KPI Data
            $totalRevenue = Transaction::where('status', 'completed')->sum('total_amount') ?? 0;
            $totalClicks = Transaction::where('status', 'completed')->count() ?? 0;
            $totalEarnings = Commission::where('status', 'approved')->sum('amount') ?? 0;
            $netRevenue = $totalRevenue - $totalEarnings;

            // Revenue vs Expenses - Last 7 months
            $revenueExpenses = [];
            for ($i = 6; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $startDate = $month->copy()->startOfMonth();
                $endDate = $month->copy()->endOfMonth();

                $revenue = Transaction::where('status', 'completed')
                    ->whereBetween('completed_at', [$startDate, $endDate])
                    ->sum('total_amount') ?? 0;

                $expenses = Commission::where('status', 'approved')
                    ->whereBetween('approved_at', [$startDate, $endDate])
                    ->sum('amount') ?? 0;

                $revenueExpenses[] = [
                    'month' => $month->format('M'),
                    'revenue' => round($revenue, 2),
                    'expenses' => round($expenses, 2),
                ];
            }

            // Affiliate Sales - Last 7 weeks
            $affiliateSales = [];
            for ($i = 6; $i >= 0; $i--) {
                $week = Carbon::now()->subWeeks($i);
                $startDate = $week->copy()->startOfWeek();
                $endDate = $week->copy()->endOfWeek();

                $sales = Commission::where('status', 'approved')
                    ->whereBetween('approved_at', [$startDate, $endDate])
                    ->sum('amount') ?? 0;

                $affiliateSales[] = [
                    'week' => 'W' . $week->weekOfYear,
                    'sales' => round($sales, 2),
                ];
            }

            // Recent Payouts - From Database or Mock Data
            $recentPayouts = PayoutBatchItem::with('batch', 'withdrawRequest.affiliate')
                ->latest()
                ->limit(4)
                ->get()
                ->map(function ($item) {
                    return [
                        'name' => $item->withdrawRequest?->affiliate?->name ?? 'Unknown Affiliate',
                        'amount' => $item->amount ?? 0,
                        'status' => ucfirst($item->batch?->status ?? 'pending'),
                        'date' => $item->updated_at?->format('Y-m-d') ?? date('Y-m-d'),
                    ];
                })
                ->toArray();

            // If no payout data, use mock data
            if (empty($recentPayouts)) {
                $recentPayouts = [
                    ['name' => 'System', 'amount' => 5000, 'status' => 'Paid', 'date' => date('Y-m-d')],
                    ['name' => 'Monthly Batch', 'amount' => 3500, 'status' => 'Processing', 'date' => date('Y-m-d', strtotime('-1 day'))],
                    ['name' => 'Weekly Payout', 'amount' => 2200, 'status' => 'Paid', 'date' => date('Y-m-d', strtotime('-2 days'))],
                    ['name' => 'Affiliate Fund', 'amount' => 1800, 'status' => 'Pending', 'date' => date('Y-m-d', strtotime('-3 days'))],
                ];
            }

            // Recent Users
            $recentUsers = User::with('role:id,name')
                ->whereHas('role', function($query) {
                    $query->where('name', '!=', 'super-admin');
                })
                ->latest()
                ->limit(4)
                ->get()
                ->map(function ($user) {
                    $earnings = Commission::where('affiliate_id', $user->id)
                        ->where('status', 'approved')
                        ->sum('amount') ?? 0;

                    return [
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role?->name ?? 'N/A',
                        'earnings' => round($earnings, 2),
                    ];
                })
                ->toArray();

            $kpiData = [
                'totalRevenue' => round($totalRevenue, 2),
                'totalClicks' => $totalClicks,
                'totalEarnings' => round($totalEarnings, 2),
                'netRevenue' => round($netRevenue, 2),
            ];

            $chartsData = [
                'revenueExpenses' => $revenueExpenses,
                'affiliateSales' => $affiliateSales,
            ];

            return view('dashboard-superadmin', [
                'kpiData' => $kpiData,
                'chartsData' => $chartsData,
                'recentPayouts' => $recentPayouts,
                'recentUsers' => $recentUsers,
            ]);
        } catch (\Exception $e) {
            // Return with default data if error
            return view('dashboard-superadmin', [
                'kpiData' => [
                    'totalRevenue' => 0,
                    'totalClicks' => 0,
                    'totalEarnings' => 0,
                    'netRevenue' => 0,
                ],
                'chartsData' => [
                    'revenueExpenses' => [],
                    'affiliateSales' => [],
                ],
                'recentPayouts' => [],
                'recentUsers' => [],
            ]);
        }
    }
}
