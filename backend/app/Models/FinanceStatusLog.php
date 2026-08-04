<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinanceStatusLog extends Model
{
    use HasFactory;

    protected $table = 'finance_status_logs';

    protected $fillable = [
        'entity_type',
        'entity_id',
        'status_from',
        'status_to',
        'acted_by_user_id',
        'notes',
        'acted_at',
    ];

    protected $casts = [
        'acted_at' => 'datetime',
    ];

    public function actedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acted_by_user_id');
    }
}
