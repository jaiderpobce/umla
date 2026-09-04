<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $roleId = DB::table('roles')->where('slug', 'estudiante')->value('id');
        $viewId = DB::table('module_views')->where('slug', 'reportes')->where('component', 'NotesReports')->value('id');
        $permissionId = DB::table('permissions')->where('slug', 'view')->value('id');
        if ($roleId && $viewId && $permissionId) {
            DB::table('role_view_permission')->updateOrInsert(['role_id' => $roleId, 'module_view_id' => $viewId, 'permission_id' => $permissionId], []);
        }
    }

    public function down(): void
    {
        $roleId = DB::table('roles')->where('slug', 'estudiante')->value('id');
        $viewId = DB::table('module_views')->where('slug', 'reportes')->where('component', 'NotesReports')->value('id');
        $permissionId = DB::table('permissions')->where('slug', 'view')->value('id');
        DB::table('role_view_permission')->where(['role_id' => $roleId, 'module_view_id' => $viewId, 'permission_id' => $permissionId])->delete();
    }
};
