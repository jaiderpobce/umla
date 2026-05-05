<?php   /* error_reporting(E_ALL);
ini_set('display_errors', '1');*/

        /*require_once 'lib/autoloader.class.php';
	require_once 'lib/init.class.php';
        $_page = 'competencias';
        $_menu = 'competencias';

	require_once 'lib/auth.php';*/

        
        require_once '../../lib/autoloader.class.php';
	require_once '../../lib/init.class.php';
        require_once '../../lib/auth.php';
        
        $img = $base64;
        $img = str_replace('data:image/png;base64,', '', $img);
        $fileData = base64_decode($img);
        $fileName = $clave."_".$prueba."_".$nadador.'.png';
        file_put_contents($fileName, $fileData);

			  
			 ?>
 

