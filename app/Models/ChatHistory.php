<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'customer_id',
        'sales_id',
        'message',
        'sender_type',
        'is_order_intent',
        'read_at',
    ];

    protected $casts = [
        'is_order_intent' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function scopeOrderIntent($query)
    {
        return $query->where('is_order_intent', true);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
