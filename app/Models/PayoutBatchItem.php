<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutBatchItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'payout_batch_id',
        'withdraw_request_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function batch()
    {
        return $this->belongsTo(PayoutBatch::class, 'payout_batch_id');
    }

    public function withdrawRequest()
    {
        return $this->belongsTo(WithdrawRequest::class, 'withdraw_request_id');
    }
}
