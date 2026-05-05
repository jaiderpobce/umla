<?php   /* error_reporting(E_ALL);
ini_set('display_errors', '1');*/
	
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
       
//require_once 'lib/auth.php';
//require_once 'datos_roles.php';


require 'includes/clases/vendor/autoload.php';


        $_page = 'usuarios_add';
        $_menu = 'config';

	//require_once 'lib/auth.php';

        $club = New Club();
        $club->getOne($clubId);

     

        
        $users = New Usuario();
        $users->getAll(1,'entrenador-sysadmin-tesorero-apoderado');


	require_once 'vistas/usuarios_xclub.php';   
 


?>
