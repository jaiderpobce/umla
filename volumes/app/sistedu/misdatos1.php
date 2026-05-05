<?php    
	  require_once 'include_all.php';
	  //require_once 'lib/autoloader.class.php';
	  //require_once 'lib/init.class.php';
          $_page = 'usuarios';

	  //require_once 'lib/auth.php';
          
          /*$nad = New Usuario();
          $nad->getOne();*/
        
          //$datosN = array();
          $datosN = array(
              'direccion' => $direccion,
              'telefono' => $telefono,
              'origen' => 'misdatos'
          );
        $user = New Usuario();
        $user->modificar($id, $rut, $nombre, $apellido, $email, $roles, $datosN);
        
        
        

	  //require_once 'vistas/pruebas.php'; 
          header("Location: usuarios.php");
 


?>
