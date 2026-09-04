<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicPeriod extends Model
{
    use HasFactory;

    protected $table = 'periodos_academicos';

    protected $fillable = [
        'nombre',
        'slug',
        'fecha_ini',
        'fecha_fin',
        'is_active',
    ];

    protected $casts = [
        'fecha_ini' => 'date',
        'fecha_fin' => 'date',
        'is_active' => 'boolean',
    ];

    public function periodoAlumnos(): HasMany
    {
        return $this->hasMany(PeriodoAlumno::class, 'id_periodo');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(ActiveStudent::class, 'periodo_alumnos', 'id_periodo', 'id_alumno')
                    ->withPivot('id', 'status')
                    ->withTimestamps();
    }
}
