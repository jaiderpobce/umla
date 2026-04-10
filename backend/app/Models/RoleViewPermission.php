<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleViewPermission extends Model
{
    use HasFactory;

    protected $table = 'role_view_permission';

    protected $fillable = ['role_id', 'module_view_id', 'permission_id'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function moduleView(): BelongsTo
    {
        return $this->belongsTo(ModuleView::class, 'module_view_id');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
