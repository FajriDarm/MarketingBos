<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'customer_id',
        'affiliate_id',
        'product_id',
        'sales_id',
        'total_amount',
        'dp_amount',
        'dp_paid_at',
        'dp_proof_url',
        'status',
        'shipping_proof_url',
        'shipped_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'dp_paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function chatHistories()
    {
        return $this->hasMany(ChatHistory::class, 'transaction_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'transaction_id');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'dp_paid', 'shipped']);
    }
}
