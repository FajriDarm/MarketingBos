<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'withdraw_request_id',
        'commission_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function withdrawRequest()
    {
        return $this->belongsTo(WithdrawRequest::class, 'withdraw_request_id');
    }

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id');
    }
}
