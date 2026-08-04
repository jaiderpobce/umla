<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FinancePayment extends Model
{
    use HasFactory;

    protected $table = 'finance_payments';

    protected $fillable = [
        'finance_charge_id',
        'user_id',
        'reported_by_user_id',
        'registered_by_user_id',
        'approved_by_user_id',
        'amount',
        'payment_date',
        'reported_at',
        'reviewed_at',
        'status',
        'payment_method',
        'reference',
        'bank_name',
        'voucher_path',
        'voucher_original_name',
        'review_notes',
    ];

    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'date',
        'reported_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function charge(): BelongsTo
    {
        return $this->belongsTo(FinanceCharge::class, 'finance_charge_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    public function receipt(): HasOne
    {
        return $this->hasOne(FinanceReceipt::class, 'finance_payment_id');
    }
}
