<?php   /* error_reporting(E_ALL);
ini_set('display_errors', '1');*/

	 require_once 'include_all.php';

        //require_once 'lib/autoloader.class.php';
	//require_once 'lib/init.class.php';
        $_page = 'estatus';
        $_menu = 'config';

	//require_once 'lib/auth.php';
        
          
  $listvarall = "";
  $listvar = "";
  $listvaro = "";
  foreach ($_GET as $key => $value) {
    if ($key == 'cliente') {
      $haycli = 1;
    } 

    $listvarall .=  $key."=".$value."&";

    if ($key != 'pagi') {
      $listvar .=  $key."=".$value."&";
    }
    if ($key != 'orden' && $key != 'tiporden' && $key != 'pagi') {
      $listvaro .=  $key."=".$value."&";
    }
  }
        
  
 $opciones = array();
   
    if (!empty($pagi)) {
       $pagi = $pagi;
    }else{
      $pagi = '1';
    }
          

   

    if (!empty($estatus)) {
        $opciones["estatus"] = $estatus;              
    }

  


   $data = New Estatu();
   
   $tabla=$data->getAllTable(1,'', $opciones,'',$pagi,'','25');


	require_once 'vistas/estatus.php';   
 


?>
