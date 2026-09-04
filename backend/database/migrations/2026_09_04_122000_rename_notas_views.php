<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('module_views')->where('slug', 'grid')->where('component', 'NotesGrid')->update(['name' => 'Listado de notas', 'updated_at' => now()]);
        DB::table('module_views')->where('slug', 'reportes')->where('component', 'NotesReports')->update(['name' => 'Notas detalladas', 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('module_views')->where('slug', 'grid')->where('component', 'NotesGrid')->update(['name' => 'Grid', 'updated_at' => now()]);
        DB::table('module_views')->where('slug', 'reportes')->where('component', 'NotesReports')->update(['name' => 'Reportes', 'updated_at' => now()]);
    }
};