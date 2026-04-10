<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(AppModule::class, 'role_module', 'role_id', 'module_id')->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_view_permission')
            ->withPivot('module_view_id')
            ->withTimestamps();
    }

    public function viewPermissions(): HasMany
    {
        return $this->hasMany(RoleViewPermission::class, 'role_id');
    }
}
