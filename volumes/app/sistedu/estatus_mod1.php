<?php /*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'include_all.php';

$_page = 'estatus_mod1';

$data = New Estatu();

$data->modificar($id,$estatus,$authj->rowff['id']);


header("Location: estatus.php");
?>
