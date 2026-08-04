<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinanceCharge extends Model
{
    use HasFactory;

    protected $table = 'finance_charges';

    protected $fillable = [
        'user_id',
        'finance_period_id',
        'charge_code',
        'concept',
        'description',
        'currency',
        'amount_total',
        'amount_paid',
        'balance_due',
        'status',
        'billed_at',
        'due_at',
        'created_by_user_id',
        'updated_by_user_id',
    ];

    protected $casts = [
        'amount_total' => 'float',
        'amount_paid' => 'float',
        'balance_due' => 'float',
        'billed_at' => 'date',
        'due_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(FinancePeriod::class, 'finance_period_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(FinancePayment::class, 'finance_charge_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
