<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_number',
        'name',
        'description',
        'commission_percentage',
        'min_amount',
        'max_amount',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'commission_percentage' => 'decimal:2',
    ];

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'stage_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
