<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModuleView extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'name', 'slug', 'route', 'component', 'description', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(AppModule::class, 'module_id');
    }

    public function rolePermissions(): HasMany
    {
        return $this->hasMany(RoleViewPermission::class, 'module_view_id');
    }
}
