<?php   /* error_reporting(E_ALL);
ini_set('display_errors', '1');*/

	require_once 'include_all.php';

        //require_once 'lib/autoloader.class.php';
	//require_once 'lib/init.class.php';

        $_page = 'usuarios';
        $_menu = 'config';

	//require_once 'lib/auth.php';
        
        $users = New Usuario();
        $users->getAll(1,'entrenador-sysadmin-tesorero-apoderado-admin');


	require_once 'vistas/usuarios.php';   
 


?>
