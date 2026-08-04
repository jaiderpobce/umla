<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinanceReceipt extends Model
{
    use HasFactory;

    protected $table = 'finance_receipts';

    protected $fillable = [
        'finance_payment_id',
        'finance_charge_id',
        'student_user_id',
        'approved_by_user_id',
        'folio',
        'period_label',
        'concept',
        'amount',
        'payment_date',
        'payment_method',
        'reference',
        'receipt_path',
        'sent_to_email',
        'generated_at',
        'sent_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'date',
        'generated_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(FinancePayment::class, 'finance_payment_id');
    }

    public function charge(): BelongsTo
    {
        return $this->belongsTo(FinanceCharge::class, 'finance_charge_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_user_id');
    }
}
