<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

echo "<html><head><title>Database Connection Test</title>";
echo "<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0f172a; color: #e2e8f0; margin: 0; padding: 40px; }
.card { max-width: 600px; margin: 0 auto; background: #1e293b; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); border: 1px solid #334155; padding: 30px; }
h1 { color: #f8fafc; font-size: 24px; margin-top: 0; border-bottom: 2px solid #334155; padding-bottom: 15px; }
pre { background: #020617; color: #f43f5e; padding: 15px; border-radius: 8px; overflow-x: auto; border: 1px solid #e11d48; font-family: monospace; font-size: 14px; }
.success-msg { color: #4ade80; font-weight: bold; font-size: 16px; margin: 15px 0; }
.error-msg { color: #f87171; font-weight: bold; font-size: 16px; margin: 15px 0; }
.info-msg { color: #38bdf8; font-weight: bold; font-size: 16px; margin: 15px 0; }
ul { background: #0f172a; border-radius: 8px; padding: 15px 15px 15px 35px; border: 1px solid #334155; }
li { margin-bottom: 8px; color: #94a3b8; }
li strong { color: #f1f5f9; }
summary { cursor: pointer; color: #38bdf8; font-weight: bold; margin-top: 15px; }
details ul { background: #020617; }
details li { color: #cbd5e1; }
.btn-back { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #3b82f6; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; }
.btn-back:hover { background: #2563eb; }
</style></head><body>";

echo "<div class='card'>";
echo "<h1>Prueba de Conexión a la Base de Datos</h1>";

// 1. Read .env file
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    echo "<p class='error-msg'>Error: El archivo .env no se encuentra en " . htmlspecialchars($envPath) . "</p>";
} else {
    echo "<p style='color: #4ade80;'>✓ Archivo .env encontrado.</p>";
    $envContent = file_get_contents($envPath);
    $lines = explode("\n", $envContent);
    $config = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            $config[$key] = $value;
        }
    }

    $db_conn = isset($config['DB_CONNECTION']) ? $config['DB_CONNECTION'] : 'no definido';
    $db_host = isset($config['DB_HOST']) ? $config['DB_HOST'] : 'no definido';
    $db_port = isset($config['DB_PORT']) ? $config['DB_PORT'] : 'no definido';
    $db_name = isset($config['DB_DATABASE']) ? $config['DB_DATABASE'] : 'no definido';
    $db_user = isset($config['DB_USERNAME']) ? $config['DB_USERNAME'] : 'no definido';
    $db_pass = isset($config['DB_PASSWORD']) ? $config['DB_PASSWORD'] : '';

    $masked_pass = '';
    if (!empty($db_pass)) {
        $masked_pass = substr($db_pass, 0, 1) . str_repeat('*', max(0, strlen($db_pass) - 2)) . substr($db_pass, -1);
    } else {
        $masked_pass = '(vacío)';
    }

    echo "<h3>Configuración leída de .env:</h3>";
    echo "<ul>";
    echo "<li><strong>DB_CONNECTION:</strong> " . htmlspecialchars($db_conn) . "</li>";
    echo "<li><strong>DB_HOST:</strong> " . htmlspecialchars($db_host) . "</li>";
    echo "<li><strong>DB_PORT:</strong> " . htmlspecialchars($db_port) . "</li>";
    echo "<li><strong>DB_DATABASE:</strong> " . htmlspecialchars($db_name) . "</li>";
    echo "<li><strong>DB_USERNAME:</strong> " . htmlspecialchars($db_user) . "</li>";
    echo "<li><strong>DB_PASSWORD:</strong> " . htmlspecialchars($masked_pass) . "</li>";
    echo "</ul>";

    // 2. Try raw PDO connection
    echo "<h3>Intentando conectar...</h3>";
    try {
        $dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT            => 5,
        ];
        
        $start = microtime(true);
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
        $end = microtime(true);
        
        echo "<p class='success-msg'>¡Conexión Exitosa! (Tardó " . round(($end - $start) * 1000, 2) . " ms)</p>";
        
        // Check DB Version
        $stmt = $pdo->query("SELECT VERSION() as version");
        $row = $stmt->fetch();
        echo "<p><strong>Versión de la Base de Datos:</strong> " . htmlspecialchars($row['version']) . "</p>";

        // List tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p><strong>Tablas encontradas:</strong> " . count($tables) . "</p>";
        if (count($tables) > 0) {
            echo "<details><summary>Mostrar Tablas</summary><ul>";
            foreach ($tables as $table) {
                echo "<li>" . htmlspecialchars($table) . "</li>";
            }
            echo "</ul></details>";
        } else {
            echo "<p class='info-msg'>La base de datos está vacía (no contiene tablas).</p>";
        }
        
    } catch (PDOException $e) {
        echo "<p class='error-msg'>¡Conexión Fallida!</p>";
        echo "<pre>Código de error: " . $e->getCode() . "\nDetalle: " . htmlspecialchars($e->getMessage()) . "</pre>";
        echo "<h4>Sugerencias de diagnóstico:</h4>";
        echo "<ul>";
        echo "<li>Asegúrate de que el servicio de MariaDB/MySQL esté corriendo en el servidor.</li>";
        echo "<li>En Docker, el host de la base de datos suele ser el nombre del servicio (<code>db</code>), pero en producción fuera de Docker (o dependiendo del hosting), podría ser <code>127.0.0.1</code> o <code>localhost</code>.</li>";
        echo "<li>Verifica que el nombre de la base de datos, usuario y contraseña coincidan con los de producción.</li>";
        echo "<li>Asegúrate de que el puerto (<code>" . htmlspecialchars($db_port) . "</code>) esté correcto.</li>";
        echo "</ul>";
    }
}

echo "</div>";
echo "</body></html>";
