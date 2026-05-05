<?php /*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'lib/autoloader.class.php';
	  require_once 'lib/init.class.php';

	  require_once 'lib/auth.php';



	  $clichk = new Authorizacion();  

	  echo $clichk->checkrut(str_replace(".", "", $rut));

 


?>