<?php  /*  error_reporting(E_ALL);
ini_set('display_errors', '1');*/

 require_once 'include_all.php';
      //require_once 'lib/autoloader.class.php';
      //require_once 'lib/init.class.php';
 $_page = 'usuarios_elim';

      //require_once 'lib/auth.php';

 $data = New Usuario();

 $st='0';
 $data->cambiarEstado($id,$st,$authj->rowff['id']);

 header("Location: nadadores.php");

?>
