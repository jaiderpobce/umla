<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $moduleId = DB::table('modules')->where('slug', 'institucion')->value('id');

        if (!$moduleId) {
            $sortOrder = (int) DB::table('modules')->max('sort_order') + 1;
            $moduleId = DB::table('modules')->insertGetId([
                'name' => 'Institución',
                'slug' => 'institucion',
                'icon' => 'IN',
                'description' => 'Configuración institucional y de marca',
                'sort_order' => $sortOrder > 0 ? $sortOrder : 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $viewId = DB::table('module_views')
            ->where('module_id', $moduleId)
            ->where('slug', 'branding')
            ->value('id');

        if (!$viewId) {
            $viewId = DB::table('module_views')->insertGetId([
                'module_id' => $moduleId,
                'name' => 'Branding',
                'slug' => 'branding',
                'route' => '/institucion/branding',
                'component' => 'InstitutionSettings',
                'description' => 'Nombre, subtítulo y logotipo institucional',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $roleId = DB::table('roles')->where('slug', 'super-admin')->value('id');
        $viewPermissionIds = DB::table('permissions')->whereIn('slug', ['view', 'edit'])->pluck('id');

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

            foreach ($viewPermissionIds as $permissionId) {
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
        $moduleId = DB::table('modules')->where('slug', 'institucion')->value('id');

        if (!$moduleId) {
            return;
        }

        $viewIds = DB::table('module_views')->where('module_id', $moduleId)->pluck('id');
        DB::table('role_view_permission')->whereIn('module_view_id', $viewIds)->delete();
        DB::table('role_module')->where('module_id', $moduleId)->delete();
        DB::table('module_views')->where('module_id', $moduleId)->delete();
        DB::table('modules')->where('id', $moduleId)->delete();
    }
};