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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('role_view_permission')->truncate();
        DB::table('role_module')->truncate();
        DB::table('role_user')->truncate();
        ModuleView::truncate();
        AppModule::truncate();
        Permission::truncate();
        Role::truncate();
        User::query()->where('email', 'admin@umla.local')->delete();
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
    }

    protected function attachRoleModulesAndPermissions($roles, $permissions, array $viewMap): void
    {
        $definitions = [
            'super-admin' => [
                'modules' => ['dashboard', 'usuarios', 'roles', 'modulos', 'auditoria'],
                'views' => [
                    'dashboard.overview' => ['view'],
                    'usuarios.listado' => ['view', 'create', 'edit', 'delete'],
                    'roles.matriz' => ['view', 'create', 'edit', 'assign'],
                    'modulos.catalogo' => ['view', 'create', 'edit'],
                    'auditoria.eventos' => ['view', 'export'],
                ],
            ],
            'coordinador' => [
                'modules' => ['dashboard', 'usuarios', 'modulos'],
                'views' => [
                    'dashboard.overview' => ['view'],
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