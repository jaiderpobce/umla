<?php
use App\Models\User;
use App\Services\RbacService;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/html; charset=utf-8');

echo "<html><head><title>RBAC Debugger</title>";
echo "<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0f172a; color: #e2e8f0; margin: 0; padding: 40px; }
.card { max-width: 900px; margin: 0 auto; background: #1e293b; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); border: 1px solid #334155; padding: 30px; }
h1 { color: #f8fafc; font-size: 24px; margin-top: 0; border-bottom: 2px solid #334155; padding-bottom: 15px; }
pre { background: #020617; color: #38bdf8; padding: 15px; border-radius: 8px; overflow-x: auto; border: 1px solid #334155; font-family: monospace; font-size: 14px; }
.user-block { background: #0f172a; border-radius: 8px; padding: 15px; margin-bottom: 15px; border: 1px solid #334155; }
.user-title { font-size: 18px; font-weight: bold; color: #f1f5f9; margin-top: 0; }
.badge { display: inline-block; padding: 2px 8px; background: #3b82f6; color: #fff; border-radius: 4px; font-size: 12px; font-weight: bold; margin-right: 5px; }
.badge-role { background: #10b981; }
</style></head><body>";

echo "<div class='card'>";
echo "<h1>Diagnóstico de Roles y Permisos (RBAC)</h1>";

try {
    $rbacService = app(RbacService::class);
    $users = User::with('roles')->get();

    echo "<p>Total de usuarios encontrados: " . $users->count() . "</p>";

    foreach ($users as $user) {
        $rolesStr = '';
        foreach ($user->roles as $role) {
            $rolesStr .= "<span class='badge badge-role'>{$role->name} (ID: {$role->id}, Slug: {$role->slug})</span>";
        }
        
        echo "<div class='user-block'>";
        echo "<p class='user-title'>User ID: {$user->id} | {$user->name} ({$user->email})</p>";
        echo "<p><strong>Roles asignados:</strong> " . ($rolesStr ?: '<span class="badge" style="background: #ef4444;">Ninguno</span>') . "</p>";
        
        // Navigation payload
        try {
            $nav = $rbacService->navigationFor($user);
            echo "<p><strong>Módulos accesibles:</strong></p>";
            if (empty($nav)) {
                echo "<p style='color: #ef4444; font-weight: bold;'>Ninguno (No tiene acceso a ningún módulo)</p>";
            } else {
                echo "<ul>";
                foreach ($nav as $mod) {
                    echo "<li><strong>{$mod['name']}</strong> ({$mod['slug']})";
                    if (!empty($mod['views'])) {
                        echo "<ul>";
                        foreach ($mod['views'] as $view) {
                            $perms = implode(', ', $view['permissions']);
                            echo "<li>Vista: {$view['name']} ({$view['slug']}) | Permisos: <span style='color: #10b981; font-weight: bold;'>[$perms]</span></li>";
                        }
                        echo "</ul>";
                    }
                    echo "</li>";
                }
                echo "</ul>";
            }
        } catch (\Exception $navEx) {
            echo "<p style='color: #ef4444;'>Error obteniendo navegación: " . htmlspecialchars($navEx->getMessage()) . "</p>";
        }
        
        echo "</div>";
    }
} catch (\Exception $e) {
    echo "<p style='color: #f87171; font-weight: bold;'>Error general en el diagnóstico:</p>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "\n" . $e->getTraceAsString() . "</pre>";
}

echo "</div>";
echo "</body></html>";
