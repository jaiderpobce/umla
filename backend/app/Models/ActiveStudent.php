<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActiveStudent extends Model
{
    use HasFactory;

    protected $table = 'alumnos_activos';

    protected $fillable = [
        'curp',
        'matricula',
        'nombre_completo',
        'email',
        'programa_id',
        'user_id',
        'status',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(AcademicProgram::class, 'programa_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function periodoAlumnos(): HasMany
    {
        return $this->hasMany(PeriodoAlumno::class, 'id_alumno');
    }

    public function periods(): BelongsToMany
    {
        return $this->belongsToMany(AcademicPeriod::class, 'periodo_alumnos', 'id_alumno', 'id_periodo')
                    ->withPivot('id', 'status')
                    ->withTimestamps();
    }
}
