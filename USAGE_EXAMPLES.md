# 📚 Contoh Penggunaan Model & Query Database

## 🔍 Querying Examples

### 1. Get All Affiliates with Their Commissions

```php
// app/Services/AffiliateService.php

namespace App\Services;

use App\Models\User;
use App\Models\Commission;

class AffiliateService
{
    /**
     * Get affiliate with total pending commissions
     */
    public function getAffiliateWithCommissions($affiliateId)
    {
        return User::with([
            'commissions' => function($query) {
                $query->where('status', 'pending');
            },
            'commissions.stage',
            'commissions.transaction',
            'withdrawRequests'
        ])->findOrFail($affiliateId);
    }

    /**
     * Get commission breakdown by stage for affiliate
     */
    public function getCommissionsByStage($affiliateId)
    {
        return Commission::with('stage')
            ->where('affiliate_id', $affiliateId)
            ->where('status', 'pending')
            ->get()
            ->groupBy('stage.stage_number');
    }

    /**
     * Get total pending commission amount
     */
    public function getTotalPendingCommission($affiliateId)
    {
        return Commission::where('affiliate_id', $affiliateId)
            ->where('status', 'pending')
            ->sum('amount');
    }

    /**
     * Get ready for withdrawal commissions
     */
    public function getReadyForWithdraw($affiliateId)
    {
        return Commission::where('affiliate_id', $affiliateId)
            ->readyForWithdraw()
            ->with('transaction', 'stage')
            ->get();
    }
}
```

### 2. Create Transaction with Commission

```php
// app/Services/TransactionService.php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Commission;
use App\Models\CommissionStage;
use DB;

class TransactionService
{
    /**
     * Create new transaction
     */
    public function createTransaction($data)
    {
        return DB::transaction(function() use ($data) {
            $transaction = Transaction::create($data);
            
            // Auto create commission stage 1 (Chat Intent)
            $stage1 = CommissionStage::where('stage_number', 1)->first();
            $amount = $transaction->total_amount * ($stage1->commission_percentage / 100);
            
            Commission::create([
                'transaction_id' => $transaction->id,
                'affiliate_id' => $transaction->affiliate_id,
                'stage_id' => $stage1->id,
                'amount' => $amount,
                'status' => 'pending',
            ]);
            
            return $transaction;
        });
    }

    /**
     * Mark DP as paid and create stage 2 commission
     */
    public function markDPPaid($transactionId, $dpAmount, $proofUrl)
    {
        return DB::transaction(function() use ($transactionId, $dpAmount, $proofUrl) {
            $transaction = Transaction::findOrFail($transactionId);
            
            $transaction->update([
                'status' => 'dp_paid',
                'dp_amount' => $dpAmount,
                'dp_paid_at' => now(),
                'dp_proof_url' => $proofUrl,
            ]);
            
            // Create stage 2 commission
            $stage2 = CommissionStage::where('stage_number', 2)->first();
            $amount = $transaction->total_amount * ($stage2->commission_percentage / 100);
            
            Commission::create([
                'transaction_id' => $transaction->id,
                'affiliate_id' => $transaction->affiliate_id,
                'stage_id' => $stage2->id,
                'amount' => $amount,
                'status' => 'pending',
            ]);
            
            return $transaction;
        });
    }

    /**
     * Mark product as shipped and create stage 3 commission
     */
    public function markShipped($transactionId, $shippingProofUrl)
    {
        return DB::transaction(function() use ($transactionId, $shippingProofUrl) {
            $transaction = Transaction::findOrFail($transactionId);
            
            $transaction->update([
                'status' => 'shipped',
                'shipped_at' => now(),
                'shipping_proof_url' => $shippingProofUrl,
            ]);
            
            // Create stage 3 commission
            $stage3 = CommissionStage::where('stage_number', 3)->first();
            $amount = $transaction->total_amount * ($stage3->commission_percentage / 100);
            
            Commission::create([
                'transaction_id' => $transaction->id,
                'affiliate_id' => $transaction->affiliate_id,
                'stage_id' => $stage3->id,
                'amount' => $amount,
                'status' => 'pending',
            ]);
            
            return $transaction;
        });
    }
}
```

### 3. Commission Approval by Sales

```php
// app/Services/CommissionService.php

namespace App\Services;

use App\Models\Commission;
use App\Models\CommissionLog;
use DB;

class CommissionService
{
    /**
     * Approve commissions by sales
     */
    public function approveCommissions($commissionIds, $salesId)
    {
        return DB::transaction(function() use ($commissionIds, $salesId) {
            $commissions = Commission::whereIn('id', $commissionIds)->get();
            
            foreach ($commissions as $commission) {
                // Update commission status
                $oldStatus = $commission->status;
                
                $commission->update([
                    'status' => 'approved',
                    'approved_by' => $salesId,
                    'approved_at' => now(),
                ]);
                
                // Log the change
                CommissionLog::create([
                    'commission_id' => $commission->id,
                    'old_status' => $oldStatus,
                    'new_status' => 'approved',
                    'changed_by' => $salesId,
                ]);
            }
            
            return count($commissions);
        });
    }

    /**
     * Reject commission
     */
    public function rejectCommission($commissionId, $salesId, $reason)
    {
        return DB::transaction(function() use ($commissionId, $salesId, $reason) {
            $commission = Commission::findOrFail($commissionId);
            $oldStatus = $commission->status;
            
            $commission->update([
                'status' => 'rejected',
                'rejected_by' => $salesId,
                'rejected_at' => now(),
                'rejection_reason' => $reason,
            ]);
            
            CommissionLog::create([
                'commission_id' => $commission->id,
                'old_status' => $oldStatus,
                'new_status' => 'rejected',
                'changed_by' => $salesId,
                'notes' => $reason,
            ]);
            
            return $commission;
        });
    }

    /**
     * Get pending commissions for approval
     */
    public function getPendingForApproval()
    {
        return Commission::with([
            'transaction.customer',
            'affiliate',
            'stage'
        ])->pending()
          ->orderBy('created_at', 'asc')
          ->paginate(20);
    }
}
```

### 4. Withdrawal Processing by Finance

```php
// app/Services/WithdrawService.php

namespace App\Services;

use App\Models\User;
use App\Models\Commission;
use App\Models\WithdrawRequest;
use App\Models\WithdrawItem;
use App\Models\PayoutBatch;
use App\Models\PayoutBatchItem;
use DB;

class WithdrawService
{
    /**
     * Create withdraw request from approved commissions
     */
    public function createWithdrawRequest($affiliateId, $commissionIds = null)
    {
        return DB::transaction(function() use ($affiliateId, $commissionIds) {
            $query = Commission::where('affiliate_id', $affiliateId)
                ->readyForWithdraw();
            
            if ($commissionIds) {
                $query->whereIn('id', $commissionIds);
            }
            
            $commissions = $query->get();
            
            if ($commissions->isEmpty()) {
                throw new \Exception('No commissions ready for withdrawal');
            }
            
            $totalAmount = $commissions->sum('amount');
            
            // Create withdraw request
            $withdrawRequest = WithdrawRequest::create([
                'code' => 'WD-' . date('YmdHis') . rand(1000, 9999),
                'affiliate_id' => $affiliateId,
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);
            
            // Create withdraw items
            foreach ($commissions as $commission) {
                WithdrawItem::create([
                    'withdraw_request_id' => $withdrawRequest->id,
                    'commission_id' => $commission->id,
                    'amount' => $commission->amount,
                ]);
            }
            
            return $withdrawRequest;
        });
    }

    /**
     * Create monthly payout batch
     */
    public function createPayoutBatch($month, $year, $financeId)
    {
        return DB::transaction(function() use ($month, $year, $financeId) {
            $withdrawRequests = WithdrawRequest::where('status', 'processing')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->get();
            
            if ($withdrawRequests->isEmpty()) {
                throw new \Exception('No withdraw requests to process');
            }
            
            $totalAmount = $withdrawRequests->sum('amount');
            
            $batch = PayoutBatch::create([
                'batch_code' => 'BATCH-' . $month . '-' . $year . '-' . date('Hms'),
                'month' => $month,
                'year' => $year,
                'total_amount' => $totalAmount,
                'total_affiliates' => $withdrawRequests->count(),
                'status' => 'processing',
                'finance_id' => $financeId,
                'processed_at' => now(),
            ]);
            
            // Add items to batch
            foreach ($withdrawRequests as $wr) {
                PayoutBatchItem::create([
                    'payout_batch_id' => $batch->id,
                    'withdraw_request_id' => $wr->id,
                    'amount' => $wr->amount,
                ]);
            }
            
            return $batch;
        });
    }

    /**
     * Complete payout
     */
    public function completePayout($batchId, $financeId)
    {
        return DB::transaction(function() use ($batchId, $financeId) {
            $batch = PayoutBatch::findOrFail($batchId);
            
            $batch->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
            
            // Update all withdraw requests to completed
            $withdrawIds = PayoutBatchItem::where('payout_batch_id', $batchId)
                ->pluck('withdraw_request_id');
            
            WithdrawRequest::whereIn('id', $withdrawIds)
                ->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            
            // Update commissions to paid
            $commissionIds = WithdrawItem::whereIn('withdraw_request_id', $withdrawIds)
                ->pluck('commission_id');
            
            Commission::whereIn('id', $commissionIds)
                ->update([
                    'status' => 'paid',
                    'payout_date' => now()->toDateString(),
                ]);
            
            return $batch;
        });
    }
}
```

### 5. Dashboard Queries

```php
// app/Services/DashboardService.php

namespace App\Services;

use App\Models\User;
use App\Models\Commission;
use App\Models\Transaction;
use App\Models\WithdrawRequest;
use DB;

class DashboardService
{
    /**
     * Affiliate Dashboard Data
     */
    public function getAffiliateDashboard($affiliateId)
    {
        $user = User::findOrFail($affiliateId);
        
        return [
            'user' => $user,
            'total_commission' => $user->total_commission,
            'total_withdrawn' => $user->total_withdrawn,
            'available_to_withdraw' => Commission::where('affiliate_id', $affiliateId)
                ->readyForWithdraw()
                ->sum('amount'),
            'pending_approval' => Commission::where('affiliate_id', $affiliateId)
                ->pending()
                ->count(),
            'commissions_by_stage' => Commission::where('affiliate_id', $affiliateId)
                ->pending()
                ->with('stage')
                ->get()
                ->groupBy('stage.stage_number')
                ->map(function($group) {
                    return [
                        'count' => $group->count(),
                        'amount' => $group->sum('amount'),
                    ];
                }),
            'recent_transactions' => Transaction::where('affiliate_id', $affiliateId)
                ->with('product', 'customer')
                ->latest()
                ->limit(10)
                ->get(),
            'recent_withdrawals' => WithdrawRequest::where('affiliate_id', $affiliateId)
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }

    /**
     * Sales Dashboard - Pending Approvals
     */
    public function getSalesDashboard($salesId)
    {
        return [
            'pending_commissions' => Commission::pending()
                ->with('transaction.customer', 'affiliate', 'stage')
                ->count(),
            'total_amount_pending' => Commission::pending()
                ->sum('amount'),
            'by_stage' => Commission::pending()
                ->with('stage')
                ->get()
                ->groupBy('stage.stage_number')
                ->map(function($group) {
                    return [
                        'stage_name' => $group->first()->stage->name,
                        'count' => $group->count(),
                        'amount' => $group->sum('amount'),
                    ];
                }),
            'recent_activities' => Commission::with('affiliate', 'transaction')
                ->latest()
                ->limit(20)
                ->get(),
        ];
    }

    /**
     * Finance Dashboard - Payment Processing
     */
    public function getFinanceDashboard()
    {
        return [
            'pending_withdrawals' => WithdrawRequest::where('status', 'pending')
                ->with('affiliate')
                ->count(),
            'total_pending_amount' => WithdrawRequest::where('status', 'pending')
                ->sum('amount'),
            'processing_count' => WithdrawRequest::where('status', 'processing')
                ->count(),
            'total_processing_amount' => WithdrawRequest::where('status', 'processing')
                ->sum('amount'),
            'this_month_payouts' => DB::table('payout_batches')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
        ];
    }
}
```

---

## 🔌 API Endpoint Examples

```php
// routes/api.php

Route::middleware('auth:sanctum')->group(function () {
    // Affiliate endpoints
    Route::get('/affiliate/dashboard', [AffiliateController::class, 'dashboard']);
    Route::get('/affiliate/commissions', [AffiliateController::class, 'commissions']);
    Route::get('/affiliate/withdrawals', [AffiliateController::class, 'withdrawals']);
    Route::post('/affiliate/withdraw-request', [AffiliateController::class, 'createWithdraw']);
    Route::get('/affiliate/affiliate-links', [AffiliateController::class, 'affiliateLinks']);
    
    // Sales endpoints
    Route::get('/sales/dashboard', [SalesController::class, 'dashboard']);
    Route::get('/sales/pending-commissions', [SalesController::class, 'pendingCommissions']);
    Route::post('/sales/approve-commissions', [SalesController::class, 'approveCommissions']);
    Route::post('/sales/reject-commission', [SalesController::class, 'rejectCommission']);
    Route::post('/sales/transactions/{transaction}/mark-dp-paid', [SalesController::class, 'markDPPaid']);
    Route::post('/sales/transactions/{transaction}/mark-shipped', [SalesController::class, 'markShipped']);
    
    // Finance endpoints
    Route::get('/finance/dashboard', [FinanceController::class, 'dashboard']);
    Route::get('/finance/withdrawals', [FinanceController::class, 'withdrawals']);
    Route::post('/finance/create-batch', [FinanceController::class, 'createBatch']);
    Route::post('/finance/complete-payout', [FinanceController::class, 'completePayout']);
    
    // Admin endpoints
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('commission-stages', CommissionStageController::class);
});
```

---

## 📝 Testing Examples

```php
// tests/Feature/CommissionTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Commission;
use App\Services\CommissionService;

class CommissionTest extends TestCase
{
    public function test_affiliate_can_see_pending_commissions()
    {
        $affiliate = User::factory()->create([
            'role_id' => Role::where('name', 'affiliate')->first()->id
        ]);
        
        $pending = Commission::factory(5)->create([
            'affiliate_id' => $affiliate->id,
            'status' => 'pending',
        ]);
        
        $this->actingAs($affiliate)
            ->getJson('/api/affiliate/commissions?status=pending')
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_sales_can_approve_commissions()
    {
        $sales = User::factory()->create([
            'role_id' => Role::where('name', 'sales')->first()->id
        ]);
        
        $commission = Commission::factory()->create(['status' => 'pending']);
        
        $this->actingAs($sales)
            ->postJson('/api/sales/approve-commissions', [
                'commission_ids' => [$commission->id]
            ])
            ->assertOk();
        
        $this->assertDatabaseHas('commissions', [
            'id' => $commission->id,
            'status' => 'approved',
        ]);
    }
}
```

---

*These are working examples ready to be integrated into your Laravel application.*
