<?php  /*  error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'include_all.php';
        $_page = 'archivo_upload';
        $_menu = 'archivos';

	require_once 'lib/auth.php';
   // $authj = new Authorizacion();
  // $authj->rowff['id']; die();

    // echo $authj->rowff['id'] ; die();
      /*          
        $comp = New Competencia();
        $comp->getOne($id);
        $comp->getDocumentos();
        
        //$comp->getPruebas();
        
        if ($dayhoy < $comp->row[0]['desde']) {
            $estado_fecha = 1;                                                
        } else if ($dayhoy >= $comp->row[0]['desde'] and $dayhoy <= $comp->row[0]['hasta']) {
            $estado_fecha = 2;
        } else {
            $estado_fecha = 3;
        }
        */
       

	require_once 'vistas/v_archivo_upload.php';   
 


