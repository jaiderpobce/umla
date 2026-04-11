<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalificacionesImportHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_file_name',
        'csv_file_name',
        'status',
        'total_rows',
        'valid_rows',
        'invalid_rows',
        'imported_rows',
        'invalid_rows_preview',
        'processed_at',
    ];

    protected $casts = [
        'invalid_rows_preview' => 'array',
        'processed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}