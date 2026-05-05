<?php    require_once 'lib/autoloader.class.php';
	  require_once 'lib/init.class.php';
          $_page = 'usuarios';

	  require_once 'lib/auth.php';
          
          
          
          $roles = array(
                           'nadador' => $nadador,
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
              'club' => $club
          );
        $user = New Usuario();
        $user->modificar($id, $rut, $nombre, $apellido, $email, $roles, $datosN);
        
        //echo $cant_nad."<br>";
        
        for ($i = 1; $i <= $cant_nad; $i++) {
            //echo "entra<br>";
            $rut_var = "rut_nadador_".$i;
            //echo ${$rut_var}."<br>";
            $user->agregarApoderado($id, ${$rut_var});	   	 	
        }
        
        for ($i = 1; $i <= $a_cant_nad; $i++) {
            //echo "entra<br>";
            $elim_var = "a_elim_".$i;
            $elim = ${$elim_var};
            //echo $elim."<br>";
            if (!empty($elim)) {
                $user->deleteApoderado($id, $elim);
            }          
	   	 		
        }
        
      

	  //require_once 'vistas/pruebas.php'; 
          header("Location: usuarios.php");
 


?>