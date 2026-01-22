<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission_id',
        'old_status',
        'new_status',
        'changed_by',
        'notes',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
