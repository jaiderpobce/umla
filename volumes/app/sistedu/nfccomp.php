<?php  /*  error_reporting(E_ALL);
ini_set('display_errors', '1');*/

        require_once 'lib/autoloader.class.php';
	require_once 'lib/init.class.php';
        $_page = 'nadadores';
        $_menu = 'nadadores';

	//require_once 'lib/auth.php';
         
        $puede_editar = 0;
        $es_editor = 0;
        $nad = New Usuario();
        
      
        $nad->getOneByRut($rut);
		if (!empty($nad->row[0]['id'])) {
			echo $nad->row[0]['id'];
		} else {
			echo "Resource id #3";
			
		}
		
        
        
        
        
 


?>