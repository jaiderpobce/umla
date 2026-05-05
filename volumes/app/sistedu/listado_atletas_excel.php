<?php /*  error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once 'Spreadsheet/Excel/Writer.php';
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
$_page = 'nadadores';
$_menu = 'nadadores';

require_once 'lib/auth.php';


//$periodo = Licencia::getPeriodoActual();

$workbook = new Spreadsheet_Excel_Writer();

$format_column = & $workbook->addformat(array('Bold'=>1));
$format_column->setBorder(2);


$format_column1 = & $workbook->addformat();
$format_column1->setBorder(1);

// sending HTTP headers
$workbook->send('Notas.xls');
$workbook->setVersion(8);

//$worksheet->setInputEncoding('UTF8');

// Creating a worksheet
$worksheet =& $workbook->addWorksheet(utf8_decode('Notas'));





$atletas = new Notas();
$atletas->getDatos_notas_excel($id_user,$admin);

//$opciones = array();
//$users = new Usuario();






//require_once 'vistas/licencias.php';

        $worksheet->write(0, 0, 'EMAIL',$format_column);
        $worksheet->write(0, 1, 'MATRICULA',$format_column);
        $worksheet->write(0, 2, 'NOMBRE',$format_column);
        $worksheet->write(0, 3, 'APATERNO',$format_column);
		$worksheet->write(0, 4, 'AMATERNO',$format_column);
        $worksheet->write(0, 5, 'PERIODO',$format_column);
		$worksheet->write(0, 6, 'TETRAMESTRE/SEMESTRE',$format_column);
		$worksheet->write(0, 7, 'NIVEL',$format_column);
		$worksheet->write(0, 8, 'ASIGNATURA',$format_column);
		$worksheet->write(0, 9, 'CALIFICACION',$format_column);
		$worksheet->write(0, 10, 'CATEDRATICO',$format_column);

        $fila = 1;  

        if (is_array($atletas->row) && count($atletas->row) > 0) {  
            foreach ($atletas->row as $Elem) {  
                // Agrega esta línea para ver los datos  
               // var_dump($Elem);  
        
                $worksheet->write($fila, 0, utf8_decode($Elem['Email']), $format_column1);  
                $worksheet->write($fila, 1, utf8_decode($Elem['Matricula']), $format_column1);  
                $worksheet->write($fila, 2, utf8_decode($Elem['Nombre']), $format_column1);  
                $worksheet->write($fila, 3, utf8_decode($Elem['APaterno']), $format_column1);  
                $worksheet->write($fila, 4, utf8_decode($Elem['AMaterno']), $format_column1);  
                $worksheet->write($fila, 5, utf8_decode($Elem['Periodo']), $format_column1);  
                $worksheet->write($fila, 6, utf8_decode($Elem['Tetramestre']), $format_column1);  
                $worksheet->write($fila, 7, utf8_decode($Elem['Nivel']), $format_column1);  
                $worksheet->write($fila, 8, utf8_decode($Elem['Asignatura']), $format_column1);  
                $worksheet->write($fila, 9, utf8_decode($Elem['CalificacionFinal']), $format_column1);  
                $worksheet->write($fila, 10, utf8_decode($Elem['Catedratico']), $format_column1);  
        
                $fila++;  
            }  
        } else {  
            echo "No se encontraron registros.";  
        }  
        

$workbook->close();
