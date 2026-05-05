<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once 'Spreadsheet/Excel/Writer.php';

require_once 'lib/autoloader.class.php';
	require_once 'lib/init.class.php';

$workbook = new Spreadsheet_Excel_Writer();

// sending HTTP headers
$workbook->send('regitrados.xls');

//$worksheet->setInputEncoding('UTF8');

// Creating a worksheet
$worksheet =& $workbook->addWorksheet('My first worksheet');


// The actual data
$worksheet->write(0, 0, 'Rut');
$worksheet->write(0, 1, 'Apellido');
$worksheet->write(0, 2, 'Nombre');
$worksheet->write(0, 3, 'Email');



$fila = 2;

 $listvarall = "";
        $listvar = "";
        $listvaro = "";
        foreach ($_GET as $key => $value) {
		  	if ($key == 'cliente') {
		  		$haycli = 1;
		  	} 
  			//if ($key != 'filtro' && $key != 'adfil') {
	  			$listvarall .=  $key."=".$value."&";
  			//}

  			if ($key != 'pagi') {
	  			$listvar .=  $key."=".$value."&";
  			}
  			if ($key != 'orden' && $key != 'tiporden' && $key != 'pagi') {
  				$listvaro .=  $key."=".$value."&";
  			}
		}
        
                $opciones = array();
        $users = New Usuario();
        //$users->usuario = $authj->rowff;
        if (!empty($orden)) {
	  	$users->orden = $orden;
	  }
	 
	  if (!empty($tiporden)) {
	  	$users->tiporden = $tiporden;
	  }

	  if (!empty($pagi)) {
	  	 $users->pag = $pagi;
	  }
          
          if (!empty($nombre)) {
              $opciones["nombre"] = $nombre;              
          }
          if (!empty($genero)) {
              $opciones["genero"] = $genero;              
          }
          if (!empty($ano)) {
              $opciones["ano"] = $ano;              
          }
        $users->getAll(0,'nadador','',0, $opciones);
		
		
		 foreach ($users->row as $Elem) {
			 
			 $fecha = strtotime ($Elem['fecnac'])  ; 


	$worksheet->write($fila, 0, utf8_decode(getPuntosRut($Elem['rut'])));	
	$worksheet->write($fila, 1, utf8_decode($Elem['apellido']));
	$worksheet->write($fila, 2, utf8_decode($Elem['nombre']));
	$worksheet->write($fila, 3, date('d-m-Y', $fecha));  
	$worksheet->write($fila, 4, $Elem['email']);	
	

    $fila++;

}

    

// Let's send the file
$workbook->close();
?>