<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
define("DB_HOST"        , "localhost");
define("DB_USER"        , "f45t_resultados");
define("DB_PASSWORD"    , "J3Yvpz--)7,@");
define("DB_NAME"        , "f45t_resultados");*/

define('DB_NAME', 'xaguas_cnpa');
define('DB_USER', 'xaguas_cnpa');
define('DB_PASSWORD', '15230574');
define('DB_HOST', 'localhost');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $eventos = json_decode($_POST['Eventos'], true);
    $success = true;
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$connection) $success = false;
    else {
        mysqli_begin_transaction($connection);
        mysqli_query($connection, "SET NAMES 'utf8'");
        foreach ($eventos as $evento) {
            $sql = "INSERT INTO sys_Evento (CompetenciaId, Nombre) VALUES ({$evento['IdCompetencia']}, '{$evento['Nombre']}')";
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
                    
                    $sql0 = "SELECT id, Club FROM sys_Clubes WHERE Club = '{$competidor['Club']}' LIMIT 1";
                    $result0 = mysqli_query($connection, $sql0);

                    if (mysqli_num_rows($result0) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result0)) {
                            $id_club = $row["id"];
                        }
                    } else {
                        $sql1 = "INSERT INTO sys_Clubes (Club) "
                            . "VALUES ('{$competidor['Club']}')";
                            $result1 = mysqli_query($connection, $sql1);
                            $id_club = mysqli_insert_id($connection);
                    }

                    $sql = "INSERT INTO sys_Competidor (EventoId, Nombre, club_id, Edad, Posicion, TiempoSembrado, TiempoFinal, Puntos) "
                            . "VALUES ({$evento_id}, "
                            . "'{$competidor['Nombre']}', "
                            . "'{$id_club}', "
                            . "{$competidor['Edad']}, "
                            . "{$competidor['Posicion']}, "
                            . "'{$competidor['TiempoSembrado']}', "
                            . "'{$competidor['TiempoFinal']}', "
                            . "{$competidor['Puntos']})";
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