<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $module = DB::table('modules')->where('slug', 'notas')->first();
        if (!$module) { return; }
        $viewId = DB::table('module_views')->where('module_id', $module->id)->where('slug', 'reportes')->value('id');
        if (!$viewId) {
            $viewId = DB::table('module_views')->insertGetId(['module_id' => $module->id, 'name' => 'Reportes', 'slug' => 'reportes', 'route' => '/notas/reportes', 'component' => 'NotesReports', 'description' => 'Detalle histórico de notas por alumno', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()]);
        }
        $permissionIds = DB::table('permissions')->whereIn('slug', ['view', 'export'])->pluck('id', 'slug');
        $roles = DB::table('roles')->whereIn('slug', ['super-admin', 'coordinador', 'operador', 'estudiante'])->get();
        foreach ($roles as $role) {
            DB::table('role_module')->updateOrInsert(['role_id' => $role->id, 'module_id' => $module->id], []);
            foreach ($role->slug === 'estudiante' ? ['view'] : ['view', 'export'] as $permission) {
                if (isset($permissionIds[$permission])) {
                    DB::table('role_view_permission')->updateOrInsert(['role_id' => $role->id, 'module_view_id' => $viewId, 'permission_id' => $permissionIds[$permission]], []);
                }
            }
        }
    }

    public function down(): void
    {
        $viewId = DB::table('module_views')->where('slug', 'reportes')->where('component', 'NotesReports')->value('id');
        if (!$viewId) { return; }
        DB::table('role_view_permission')->where('module_view_id', $viewId)->delete();
        DB::table('module_views')->where('id', $viewId)->delete();
    }
};
