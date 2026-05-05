<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_NAME', 'xaguas_cnpa');
define('DB_USER', 'xaguas_cnpa');
define('DB_PASSWORD', '15230574');
define('DB_HOST', 'localhost');
/*
define("DB_HOST"        , "localhost");
define("DB_USER"        , "novas970_pdf");
define("DB_PASSWORD"    , "Rolfi023");
define("DB_NAME"        , "novas970_pdf");*/

$myFile = "testFile.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = json_encode($_POST['Eventos']);
fwrite($fh, $stringData);
fclose($fh);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    


    $eventos = json_decode($_POST['Eventos'], true);
    $success = true;
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$connection) $success = false;
    else {
        mysqli_begin_transaction($connection);
        foreach ($eventos as $evento) {
            $sql = "INSERT INTO Evento (CompetenciaId, Nombre) VALUES ($evento['CompetenciaId'], '$evento['Nombre']')";
            $result = mysqli_query($connection, $sql);
            if (!$result) {
                echo "{$sql}<br/>";
                mysqli_rollback($connection);
                $success = false;
            }
            else {
                $evento_id = mysqli_insert_id($connection);
                foreach ($evento['Competidores'] as $competidor) {
                    if (empty($competidor['Posicion'])) $competidor['Posicion'] = "NULL";
                    if (empty($competidor['Puntos'])) $competidor['Puntos'] = "NULL";
                    $sql = "INSERT INTO Competidor (EventoId, Nombre, Club, Edad, Posicion, TiempoSembrado, TiempoFinal, Puntos) "
                            . "VALUES ({$evento_id}, "
                            . "'$competidor['Nombre']', "
                            . "'$competidor['Club']', "
                            . "$competidor['Edad'], "
                            . "$competidor['Posicion'], "
                            . "'$competidor['TiempoSembrado']', "
                            . "'$competidor['TiempoFinal']', "
                            . "$competidor['Puntos'])";
                    $result = mysqli_query($connection, $sql);
                            if (!$result) {
                                echo "{$sql}<br/>";
                                mysqli_rollback($connection);
                                $success = false;
                            }
                }
            }
        }
        if ($success) mysqli_commit($connection);
    }
    echo $success ? "TRUE" : "FALSE";
}