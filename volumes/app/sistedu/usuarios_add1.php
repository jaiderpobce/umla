<?php    
      
	  require_once 'include_all.php';
          //require_once 'lib/autoloader.class.php';
	  //require_once 'lib/init.class.php';
          $_page = 'usuarios';

	  //require_once 'lib/auth.php';

          if ($authj->rowff['sysadmin']==1) {
             
                $club=$club;
           }else{
               $club=$authj->rowff['club'];

           }
          
          $roles = array(
                           'nadador' => '0',
                           'entrenador' => $entrenador,
                           'sysadmin' => $sysadmin,
                           'tesorero' => $tesorero,
                           'apoderado' => $apoderado,
                           'admin' => $admin
    			);
          //$datosN = array();
          $datosN = array(
              'genero' => $genero,
              'fecnac' => $fecnac,
              'direccion' => $direccion,
              'telefono' => $telefono,
              'notas' => $notas,
              'externo' => '0',
              'club' => $club,
          );
        $user = New Usuario();
        $user->agregar($rut, $nombre, $apellido, $email, $roles, $datosN);
        
        for ($i = 1; $i <= $cant_nad; $i++) {
            $rut_var = "rut_nadador_".$i;
            //echo ${$rut_var};
            $user->agregarApoderado($user->id, ${$rut_var});	   	 	
        }

	  //require_once 'vistas/pruebas.php'; 
          header("Location: usuarios.php");
 


?>
