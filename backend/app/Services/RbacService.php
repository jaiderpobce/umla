<?php

namespace App\Services;

use App\Models\AppModule;
use App\Models\ModuleView;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RbacService
{
    public function navigationFor(User $user): array
    {
        $roleIds = $user->roles()->pluck('roles.id');

        $modules = AppModule::query()
            ->where('is_active', true)
            ->whereIn('id', function ($query) use ($roleIds) {
                $query->select('module_id')->from('role_module')->whereIn('role_id', $roleIds);
            })
            ->with(['views' => function ($query) use ($roleIds) {
                $query->where('is_active', true)
                    ->whereIn('id', function ($subQuery) use ($roleIds) {
                        $subQuery->select('module_view_id')
                            ->from('role_view_permission')
                            ->whereIn('role_id', $roleIds);
                    });
            }])
            ->orderBy('sort_order')
            ->get();

        return $modules->map(function (AppModule $module) use ($roleIds) {
            return [
                'id' => $module->id,
                'name' => $module->name,
                'slug' => $module->slug,
                'icon' => $module->icon,
                'description' => $module->description,
                'views' => $module->views->map(function (ModuleView $view) use ($roleIds) {
                    return [
                        'id' => $view->id,
                        'name' => $view->name,
                        'slug' => $view->slug,
                        'route' => $view->route,
                        'component' => $view->component,
                        'description' => $view->description,
                        'permissions' => $this->permissionsForViewRoleIds($view->id, $roleIds),
                    ];
                })->values(),
            ];
        })->values()->all();
    }

    public function moduleViewFor(User $user, string $moduleSlug, string $viewSlug): ?array
    {
        $navigation = collect($this->navigationFor($user));
        $module = $navigation->firstWhere('slug', $moduleSlug);

        if (!$module) {
            return null;
        }

        $view = collect($module['views'])->firstWhere('slug', $viewSlug);

        if (!$view) {
            return null;
        }

        return [
            'module' => $module,
            'view' => $view,
        ];
    }

    protected function permissionsForViewRoleIds(int $viewId, Collection $roleIds): array
    {
        return DB::table('role_view_permission')
            ->join('permissions', 'permissions.id', '=', 'role_view_permission.permission_id')
            ->where('role_view_permission.module_view_id', $viewId)
            ->whereIn('role_view_permission.role_id', $roleIds)
            ->orderBy('permissions.id')
            ->pluck('permissions.slug')
            ->unique()
            ->values()
            ->all();
    }

    public function adminSnapshot(): array
    {
        return [
            'users' => User::query()->with('roles:id,name,slug')->orderBy('name')->get()->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_ids' => $user->roles->pluck('id')->values(),
                    'roles' => $user->roles->map(function (Role $role) {
                        return [
                            'id' => $role->id,
                            'name' => $role->name,
                            'slug' => $role->slug,
                        ];
                    })->values(),
                ];
            })->values(),
            'roles' => Role::query()->orderBy('name')->get()->map(function (Role $role) {
                return $this->serializeRole($role);
            })->values(),
            'permissions' => Permission::query()->orderBy('name')->get()->map(function (Permission $permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'slug' => $permission->slug,
                    'description' => $permission->description,
                ];
            })->values(),
            'modules' => AppModule::query()->with(['views' => function ($query) {
                $query->orderBy('sort_order');
            }])->orderBy('sort_order')->get()->map(function (AppModule $module) {
                return $this->serializeModule($module);
            })->values(),
        ];
    }

    public function serializeRole(Role $role): array
    {
        $role->loadMissing(['modules:id,name,slug', 'viewPermissions']);

        $viewPermissions = DB::table('role_view_permission')
            ->where('role_id', $role->id)
            ->get()
            ->groupBy('module_view_id')
            ->map(function ($items) {
                return collect($items)->pluck('permission_id')->map(function ($permissionId) {
                    return (int) $permissionId;
                })->values();
            });

        return [
            'id' => $role->id,
            'name' => $role->name,
            'slug' => $role->slug,
            'description' => $role->description,
            'module_ids' => $role->modules->pluck('id')->map(function ($moduleId) {
                return (int) $moduleId;
            })->values(),
            'view_permissions' => $viewPermissions,
        ];
    }

    public function serializeModule(AppModule $module): array
    {
        $module->loadMissing(['views' => function ($query) {
            $query->orderBy('sort_order');
        }]);

        return [
            'id' => $module->id,
            'name' => $module->name,
            'slug' => $module->slug,
            'icon' => $module->icon,
            'description' => $module->description,
            'sort_order' => $module->sort_order,
            'is_active' => (bool) $module->is_active,
            'views' => $module->views->map(function (ModuleView $view) {
                return [
                    'id' => $view->id,
                    'module_id' => $view->module_id,
                    'name' => $view->name,
                    'slug' => $view->slug,
                    'route' => $view->route,
                    'component' => $view->component,
                    'description' => $view->description,
                    'sort_order' => $view->sort_order,
                    'is_active' => (bool) $view->is_active,
                ];
            })->values(),
        ];
    }
}
