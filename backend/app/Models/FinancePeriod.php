<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancePeriod extends Model
{
    use HasFactory;

    protected $table = 'finance_periods';

    protected $fillable = [
        'name',
        'slug',
        'year',
        'month',
        'starts_at',
        'ends_at',
        'due_at',
        'status',
        'notes',
        'created_by_user_id',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'starts_at' => 'date',
        'ends_at' => 'date',
        'due_at' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function charges(): HasMany
    {
        return $this->hasMany(FinanceCharge::class, 'finance_period_id');
    }
}
