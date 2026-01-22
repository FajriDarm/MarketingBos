<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bank_name',
        'bank_account',
        'bank_account_name',
        'role_id',
        'sales_id',
        'status',
        'commission_rate',
        'total_commission',
        'total_withdrawn',
        'last_withdraw_date',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_withdraw_date' => 'date',
            'commission_rate' => 'decimal:2',
            'total_commission' => 'decimal:2',
            'total_withdrawn' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function affiliates()
    {
        return $this->hasMany(User::class, 'sales_id');
    }

    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLink::class, 'affiliate_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'affiliate_id');
    }

    public function approvedCommissions()
    {
        return $this->hasMany(Commission::class, 'approved_by');
    }

    public function withdrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class, 'affiliate_id');
    }

    public function chatHistories()
    {
        return $this->hasMany(ChatHistory::class, 'sales_id');
    }

    public function createdTransactions()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    public function createdProducts()
    {
        return $this->hasMany(Product::class, 'created_by');
    }
}
