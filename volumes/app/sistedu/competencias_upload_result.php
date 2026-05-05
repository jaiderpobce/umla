<?php  /*  error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'include_all.php';
        $_page = 'competencias_upload_result';
        $_menu = 'competencias';

	require_once 'lib/auth.php';
        
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
       

	require_once 'vistas/competencias_upload_result.php';   
 


?>