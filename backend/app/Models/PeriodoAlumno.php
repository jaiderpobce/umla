<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodoAlumno extends Model
{
    use HasFactory;

    protected $table = 'periodo_alumnos';

    protected $fillable = [
        'id_alumno',
        'id_periodo',
        'status',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(ActiveStudent::class, 'id_alumno');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class, 'id_periodo');
    }
}
