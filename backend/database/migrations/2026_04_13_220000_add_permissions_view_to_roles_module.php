<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $moduleId = DB::table('modules')->where('slug', 'roles')->value('id');

        if (!$moduleId) {
            return;
        }

        $viewId = DB::table('module_views')
            ->where('module_id', $moduleId)
            ->where('slug', 'permisos')
            ->value('id');

        if (!$viewId) {
            $sortOrder = (int) DB::table('module_views')->where('module_id', $moduleId)->max('sort_order') + 1;

            $viewId = DB::table('module_views')->insertGetId([
                'module_id' => $moduleId,
                'name' => 'Permisos',
                'slug' => 'permisos',
                'route' => '/roles/permisos',
                'component' => 'PermissionsList',
                'description' => 'Administración de permisos reutilizables',
                'sort_order' => $sortOrder > 0 ? $sortOrder : 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $roleId = DB::table('roles')->where('slug', 'super-admin')->value('id');
        $permissionIds = DB::table('permissions')->whereIn('slug', ['view', 'create', 'edit', 'delete'])->pluck('id');

        if ($roleId) {
            $roleModuleExists = DB::table('role_module')
                ->where('role_id', $roleId)
                ->where('module_id', $moduleId)
                ->exists();

            if (!$roleModuleExists) {
                DB::table('role_module')->insert([
                    'role_id' => $roleId,
                    'module_id' => $moduleId,
                ]);
            }

            foreach ($permissionIds as $permissionId) {
                $exists = DB::table('role_view_permission')
                    ->where('role_id', $roleId)
                    ->where('module_view_id', $viewId)
                    ->where('permission_id', $permissionId)
                    ->exists();

                if (!$exists) {
                    DB::table('role_view_permission')->insert([
                        'role_id' => $roleId,
                        'module_view_id' => $viewId,
                        'permission_id' => $permissionId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        $moduleId = DB::table('modules')->where('slug', 'roles')->value('id');

        if (!$moduleId) {
            return;
        }

        $viewId = DB::table('module_views')
            ->where('module_id', $moduleId)
            ->where('slug', 'permisos')
            ->value('id');

        if (!$viewId) {
            return;
        }

        DB::table('role_view_permission')->where('module_view_id', $viewId)->delete();
        DB::table('module_views')->where('id', $viewId)->delete();
    }
};