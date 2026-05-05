<?php   /* error_reporting(E_ALL);
ini_set('display_errors', '1');*/
	
		require_once 'include_all.php';
        //require_once 'lib/autoloader.class.php';
	//require_once 'lib/init.class.php';
        $_page = 'usuarios_mod';
        $_menu = 'config';

	//require_once 'lib/auth.php';
        
        $club = New Club();
        $club->getAll($clubUsusario);
        
        $nad = New Usuario();
          $nad->getOne($id);
          $nad->getRepresentados($id);

           
          
        /*$users = New Usuario();
        $users->getAll(1,'entrenador-sysadmin-tesorero-apoderado');*/


	require_once 'vistas/usuarios_mod.php';   
 


?>
