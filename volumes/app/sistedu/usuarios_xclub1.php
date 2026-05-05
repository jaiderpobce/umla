<?php    
      
      require_once 'lib/autoloader.class.php';
      require_once 'lib/init.class.php';
             
      //require_once 'lib/auth.php';
      //require_once 'datos_roles.php';
      
      
      require 'includes/clases/vendor/autoload.php';
          //require_once 'lib/autoloader.class.php';
	  //require_once 'lib/init.class.php';
          $_page = 'usuarios';

	  //require_once 'lib/auth.php';

         
             
                $club=$club;

                $club0 = New Club();        
               $club0->getOne($club);

               $nadadores = "Nadadores: ";


               for ($i = 1; $i <= $cant_nad; $i++) {
                $rut_var = "rut_nadador_".$i;
                $nadadores .= ${$rut_var}. " - ";

                //echo ${$rut_var};
                //$user->agregarApoderado($user->id, ${$rut_var});	   	 	
            }
           
          
          $roles = array(
                           'nadador' => '0',
                           'apoderado' => 1
    			);

                
          //$datosN = array();
          $datosN = array(
              'genero' => $genero,
              'fecnac' => $fecnac,
              'direccion' => $direccion,
              'telefono' => $telefono,
              'notas' => $notas.$nadadores,
              'externo' => '0',
              'club' => $club,
              'pais' => $club0->row[0]['pais'],
              'region' => $club0->row[0]['region'],
              'ciudad' => $club0->row[0]['ciudad']
          );
        $user = New Usuario();
        $user->agregarPre($rut, $nombre, $apellido, $email, $roles, $datosN);
        
        

	  //require_once 'vistas/pruebas.php'; 
      header("Location: nadadores_xclub.php?clubId=".$club);
 


?>
