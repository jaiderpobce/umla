<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicProgram extends Model
{
    use HasFactory;

    protected $table = 'programas_academicos';

    protected $fillable = [
        'codigo',
        'nombre',
        'nivel',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(ActiveStudent::class, 'programa_id');
    }
}
