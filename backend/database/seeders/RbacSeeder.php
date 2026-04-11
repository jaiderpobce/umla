<?php

namespace Database\Seeders;

use App\Models\AppModule;
use App\Models\ModuleView;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        $studentUserIds = DB::table('calificaciones_old')
            ->whereNotNull('id_estudiante')
            ->distinct()
            ->pluck('id_estudiante')
            ->filter()
            ->map(function ($userId) {
                return (int) $userId;
            })
            ->values()
            ->all();

        $existingStudentRoleUserIds = DB::table('role_user')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.slug', 'estudiante')
            ->pluck('role_user.user_id')
            ->map(function ($userId) {
                return (int) $userId;
            })
            ->values()
            ->all();

        $studentUserIds = collect(array_merge($studentUserIds, $existingStudentRoleUserIds))
            ->unique()
            ->values()
            ->all();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('role_view_permission')->truncate();
        DB::table('role_module')->truncate();
        DB::table('role_user')->truncate();
        ModuleView::truncate();
        AppModule::truncate();
        Permission::truncate();
        Role::truncate();
        User::query()->whereIn('email', ['admin@umla.local', 'operador@umla.local'])->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $permissions = collect([
            ['name' => 'Ver', 'slug' => 'view'],
            ['name' => 'Crear', 'slug' => 'create'],
            ['name' => 'Editar', 'slug' => 'edit'],
            ['name' => 'Eliminar', 'slug' => 'delete'],
            ['name' => 'Asignar', 'slug' => 'assign'],
            ['name' => 'Exportar', 'slug' => 'export'],
        ])->mapWithKeys(function ($permission) {
            $model = Permission::create($permission);
            return [$model->slug => $model];
        });

        $roles = collect([
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Control total del sistema'],
            ['name' => 'Coordinador', 'slug' => 'coordinador', 'description' => 'Operación académica y usuarios'],
            ['name' => 'Docente', 'slug' => 'docente', 'description' => 'Consulta y operación docente'],
            ['name' => 'Operador', 'slug' => 'operador', 'description' => 'Operación diaria sin acceso a configuración'],
            ['name' => 'Estudiante', 'slug' => 'estudiante', 'description' => 'Cuenta creada automáticamente para alumnos importados'],
            ['name' => 'Consulta', 'slug' => 'consulta', 'description' => 'Solo lectura'],
        ])->mapWithKeys(function ($role) {
            $model = Role::create($role);
            return [$model->slug => $model];
        });

        $modules = [
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'icon' => 'DS',
                'description' => 'Panel general del sistema',
                'views' => [
                    ['name' => 'Resumen', 'slug' => 'overview', 'route' => '/dashboard/overview', 'component' => 'DashboardOverview', 'description' => 'Indicadores globales'],
                ],
            ],
            [
                'name' => 'Calificaciones',
                'slug' => 'calificaciones',
                'icon' => 'CL',
                'description' => 'Carga ZIP con CSV para calificaciones históricas',
                'views' => [
                    ['name' => 'Importación', 'slug' => 'importacion', 'route' => '/calificaciones/importacion', 'component' => 'GradesImport', 'description' => 'Importación masiva hacia calificaciones_old'],
                ],
            ],
            [
                'name' => 'Notas',
                'slug' => 'notas',
                'icon' => 'NT',
                'description' => 'Consulta y gestión de calificaciones por usuario',
                'views' => [
                    ['name' => 'Grid', 'slug' => 'grid', 'route' => '/notas/grid', 'component' => 'NotesGrid', 'description' => 'Consulta paginada de notas'],
                ],
            ],
            [
                'name' => 'Usuarios',
                'slug' => 'usuarios',
                'icon' => 'US',
                'description' => 'Gestión de cuentas y perfiles',
                'views' => [
                    ['name' => 'Listado', 'slug' => 'listado', 'route' => '/usuarios/listado', 'component' => 'UsersList', 'description' => 'Administración de usuarios'],
                ],
            ],
            [
                'name' => 'Roles',
                'slug' => 'roles',
                'icon' => 'RB',
                'description' => 'Administración RBAC',
                'views' => [
                    ['name' => 'Matriz RBAC', 'slug' => 'matriz', 'route' => '/roles/matriz', 'component' => 'RolesMatrix', 'description' => 'Asignación de permisos por rol'],
                ],
            ],
            [
                'name' => 'Módulos',
                'slug' => 'modulos',
                'icon' => 'MD',
                'description' => 'Configuración de módulos y vistas',
                'views' => [
                    ['name' => 'Catálogo', 'slug' => 'catalogo', 'route' => '/modulos/catalogo', 'component' => 'ModulesCatalog', 'description' => 'Catálogo de módulos y vistas'],
                ],
            ],
            [
                'name' => 'Institución',
                'slug' => 'institucion',
                'icon' => 'IN',
                'description' => 'Configuración institucional y de marca',
                'views' => [
                    ['name' => 'Branding', 'slug' => 'branding', 'route' => '/institucion/branding', 'component' => 'InstitutionSettings', 'description' => 'Nombre, subtítulo y logotipo institucional'],
                ],
            ],
            [
                'name' => 'Auditoría',
                'slug' => 'auditoria',
                'icon' => 'AU',
                'description' => 'Bitácora y exportación',
                'views' => [
                    ['name' => 'Eventos', 'slug' => 'eventos', 'route' => '/auditoria/eventos', 'component' => 'AuditEvents', 'description' => 'Bitácora de cambios'],
                ],
            ],
        ];

        $viewMap = [];
        foreach ($modules as $index => $moduleData) {
            $module = AppModule::create([
                'name' => $moduleData['name'],
                'slug' => $moduleData['slug'],
                'icon' => $moduleData['icon'],
                'description' => $moduleData['description'],
                'sort_order' => $index + 1,
            ]);

            foreach ($moduleData['views'] as $viewIndex => $viewData) {
                $view = ModuleView::create([
                    'module_id' => $module->id,
                    'name' => $viewData['name'],
                    'slug' => $viewData['slug'],
                    'route' => $viewData['route'],
                    'component' => $viewData['component'],
                    'description' => $viewData['description'],
                    'sort_order' => $viewIndex + 1,
                ]);

                $viewMap[$module->slug . '.' . $view->slug] = $view;
            }
        }

        $this->attachRoleModulesAndPermissions($roles, $permissions, $viewMap);

        $admin = User::create([
            'name' => 'Administrador UMLA',
            'email' => 'admin@umla.local',
            'password' => Hash::make('password'),
        ]);

        $admin->roles()->sync([$roles['super-admin']->id]);

        $operator = User::create([
            'name' => 'Operador UMLA',
            'email' => 'operador@umla.local',
            'password' => Hash::make('password'),
        ]);

        $operator->roles()->sync([$roles['operador']->id]);

        if (!empty($studentUserIds)) {
            User::query()
                ->whereIn('id', $studentUserIds)
                ->get()
                ->each(function (User $user) use ($roles) {
                    $user->roles()->syncWithoutDetaching([$roles['estudiante']->id]);
                });
        }
    }

    protected function attachRoleModulesAndPermissions($roles, $permissions, array $viewMap): void
    {
        $definitions = [
            'super-admin' => [
                'modules' => ['dashboard', 'calificaciones', 'notas', 'usuarios', 'roles', 'modulos', 'institucion', 'auditoria'],
                'views' => [
                    'dashboard.overview' => ['view'],
                    'calificaciones.importacion' => ['view', 'create'],
                    'notas.grid' => ['view', 'edit', 'delete'],
                    'usuarios.listado' => ['view', 'create', 'edit', 'delete'],
                    'roles.matriz' => ['view', 'create', 'edit', 'assign'],
                    'modulos.catalogo' => ['view', 'create', 'edit'],
                    'institucion.branding' => ['view', 'edit'],
                    'auditoria.eventos' => ['view', 'export'],
                ],
            ],
            'coordinador' => [
                'modules' => ['dashboard', 'calificaciones', 'usuarios', 'modulos'],
                'views' => [
                    'dashboard.overview' => ['view'],
                    'calificaciones.importacion' => ['view', 'create'],
                    'usuarios.listado' => ['view', 'create', 'edit'],
                    'modulos.catalogo' => ['view'],
                ],
            ],
            'docente' => [
                'modules' => ['dashboard', 'modulos'],
                'views' => [
                    'dashboard.overview' => ['view'],
                    'modulos.catalogo' => ['view'],
                ],
            ],
            'operador' => [
                'modules' => ['dashboard', 'calificaciones', 'notas'],
                'views' => [
                    'dashboard.overview' => ['view'],
                    'calificaciones.importacion' => ['view', 'create'],
                    'notas.grid' => ['view', 'edit', 'delete'],
                ],
            ],
            'estudiante' => [
                'modules' => ['dashboard', 'notas'],
                'views' => [
                    'dashboard.overview' => ['view'],
                    'notas.grid' => ['view'],
                ],
            ],
            'consulta' => [
                'modules' => ['dashboard', 'auditoria'],
                'views' => [
                    'dashboard.overview' => ['view'],
                    'auditoria.eventos' => ['view'],
                ],
            ],
        ];

        foreach ($definitions as $roleSlug => $definition) {
            $role = $roles[$roleSlug];
            $moduleIds = AppModule::query()->whereIn('slug', $definition['modules'])->pluck('id');
            $role->modules()->sync($moduleIds);

            foreach ($definition['views'] as $viewKey => $permissionSlugs) {
                $view = $viewMap[$viewKey];
                foreach ($permissionSlugs as $permissionSlug) {
                    DB::table('role_view_permission')->insert([
                        'role_id' => $role->id,
                        'module_view_id' => $view->id,
                        'permission_id' => $permissions[$permissionSlug]->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}