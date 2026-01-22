<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_code',
        'month',
        'year',
        'total_amount',
        'total_affiliates',
        'status',
        'finance_id',
        'processed_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function finance()
    {
        return $this->belongsTo(User::class, 'finance_id');
    }

    public function items()
    {
        return $this->hasMany(PayoutBatchItem::class, 'payout_batch_id');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
