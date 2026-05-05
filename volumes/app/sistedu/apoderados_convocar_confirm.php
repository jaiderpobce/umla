<?php   /* error_reporting(E_ALL);
ini_set('display_errors', '1');*/

	 require_once 'include_all.php';

          //require_once 'lib/autoloader.class.php';
	  //require_once 'lib/init.class.php';
          $_page = 'usuarios';

	 //require_once 'lib/auth.php';
          
          
        $comp = New Competencia();
        $comp->getOne($competencia);
        
        if ($respuesta == 0) {
            $bus = 0;
            $alojamiento = 0;
            $acompanantes = 0;
        }
        
        
            if (!empty($nadador) and !empty($categoria) and !empty($competencia)) {
                //echo $respuesta;
                $comp->agregarAsistente($comp->row[0]['id'],$nadador, $categoria, $respuesta, $bus, $alojamiento, $authj->rowff['id'], $acompanantes);
               // if ($bus == 1) {            
                //echo "acompañantes: ".$acompanantes;
                    for ($i = 1; $i <= $acompanantes; $i++) {
                        $rut = "rut_".$i;
                        $nombre = "nombre_".$i;
                        $apellido = "apellido_".$i;
                        $direccion = "direccion_".$i;
                        $fecnac = "fecnac_".$i;
                        //echo ${$rut}.",".${$nombre}.",".${$apellido}.",".${$direccion}.",".${$fecnac}.",".$comp->row[0]['id'].",".$nadador;
                        $comp->agregarAcompanante(${$rut},${$nombre},${$apellido},${$direccion},${$fecnac},$comp->row[0]['id'],$nadador);
                    }
               // }
                echo "ok";
            } else {
                echo "no";
            }
              	 	
      

	  //require_once 'vistas/pruebas.php'; 
        // header("Location: competencias_convocatoria.php?id=".$comp->row[0]['id']);
 


?>
