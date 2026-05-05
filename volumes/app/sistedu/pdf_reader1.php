<?php error_reporting(E_ALL);
ini_set('display_errors', '1');
header("Content-Type: text/html;charset=utf-8");

define("DB_HOST"        , "localhost");
define("DB_USER"        , "cnpa_cnpa");
define("DB_PASSWORD"    , "M0W(G#,QSgbh");
define("DB_NAME"        , "cnpa_cnpa");
$id_campeonato = 50;

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$connection) $success = false;
    
    $connection->set_charset("utf8");

    
 

$fp = fopen("output1.txt", "r");

while (!feof($fp)){
    $text = fgets($fp);
    $text = str_replace("Edad\n", "", $text);
    $text = str_replace("Edad", "", $text);
    $text = str_replace("Equipo", "", $text);
    $text = str_replace("Nombre", "", $text);
    $text = str_replace("Tiempo de Finales", "", $text);
    $text = str_replace("Tiempo de Finales\n", "", $text);
    $text = str_replace("Tiempo de Elim\n", "", $text);
    $text = str_replace("Tiempo de Elim", "", $text);
    $text = str_replace("Tiempo para Sembrado\n", "", $text);
    $text = str_replace("Tiempo para Sembrado", "", $text);
    $text = str_replace("Puntos\n", "", $text);
    $text = str_replace("Puntos", "", $text);
    $text = str_replace("Finales\n", "", $text);
    $text = str_replace("Finales", "", $text);
    $text = str_replace("Resultados", "", $text);
    $text = utf8_encode($text);
 




if (!empty($text) and !ctype_space($text)) {
    echo $text."<br><br>";
            $pos2 = strpos($text, "Evento");  
            $pos2x = strpos($text, "#");  
            if ($pos2x !== false) {
                $saltar = 0;
                 $pos3x = strpos($text, "Relevo");  
                if ($pos3x !== false) {
                    $saltar = 1;
                 } else {
                     $formato = 1;
                    $evento = $text;
                    $control = 1;
                    $sql = "INSERT INTO sys_Evento (CompetenciaId, Nombre) VALUES ('$id_campeonato', '$evento')";
                      echo $sql."<br>";
                      $result = mysqli_query($connection, $sql);
                      $evento_id = mysqli_insert_id($connection);
                 }
                
                 
                  
            } else {
                if ($saltar == 0) {
                $porciones = explode(" ", $text);
                $conta = count($porciones)-1;
                //echo $conta."<br>";
                //echo $porciones[$conta]."<br>";
                
                /* el club*/
                
                $sql0 = "SELECT id, Club FROM sys_Clubes WHERE Club = '$porciones[0]' AND competencia = ".$id_campeonato." LIMIT 1";
                   
                $result0 = mysqli_query($connection, $sql0);

                    if (mysqli_num_rows($result0) > 0) {
                        // output data of each row
                    while($row = mysqli_fetch_assoc($result0)) {
                            $id_club = $row["id"];
                        }
                    } else {
                        $sql1 = "INSERT INTO sys_Clubes (Club, competencia) "
                            . "VALUES ('$porciones[0]', '$id_campeonato')";
                        echo $sql1."<br>";
                           $result1 = mysqli_query($connection, $sql1);
                            $id_club = mysqli_insert_id($connection);
                    }
                    $conta1 = $conta - 1;
                    $conta2 = $conta - 2;
                    
                    $nombre = "";
                    for ($i = 2; $i <= $conta2; $i++) {
                        $nombre .= $porciones[$i];
                        if ($i < $conta2) {
                            $nombre .= " ";
                            
                        }
                    }
                    echo $nombre."<br>";
                    $posicion = 0;
                    $posicion = preg_replace("/[^0-9]/", "", $porciones[$conta1]);
                    if (empty($posicion)) {
                        //echo "entra aqui";
                       $sql = "INSERT INTO sys_Competidor (EventoId, Nombre, club_id, Edad, Posicion, TiempoSembrado, TiempoFinal, Puntos) "
                            . "VALUES ('$evento_id', "
                            . "'$nombre', "
                            . "'$id_club', "
                            . "'$porciones[1]', "
                            . "NULL, "
                            . "'', "
                            . "'$porciones[$conta]', "
                            . "NULL)";
                    } else {
                        $sql = "INSERT INTO sys_Competidor (EventoId, Nombre, club_id, Edad, Posicion, TiempoSembrado, TiempoFinal, Puntos) "
                            . "VALUES ('$evento_id', "
                            . "'$nombre', "
                            . "'$id_club', "
                            . "'$porciones[1]', "
                            . "'$posicion', "
                            . "'', "
                            . "'$porciones[$conta]', "
                            . "NULL)";
                    }
                  //echo "Evento:".$evento."<br />Club: ".$club."<br />Edad: ".$edad."<br />Nadador: ".$nadador."<br />Lugar: ".$lugar."<br />Tiempo: ".$tiempo."<br /><br />";
                  
                            echo $sql."<br>";
                            
                            $result2 = mysqli_query($connection, $sql) or die(mysqli_error($connection));
                            
                   // $result = mysqli_query($connection, $sql);
            }    
                
            }
}
    
}
fclose($fp);

//    include 'vendor/autoload.php';
 
$text = "";
// Parse pdf file and build necessary objects.
/*$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('open1.pdf');
$clave_st = uniqid();
 
//$pages  = $pdf->getPages();
 
// Loop over each page to extract text.
/*foreach ($pages as $page) {
    echo $page->getText();
}*/
//$text .= $pdf->getText();



//echo $text."<br><br><br><br>";

/*

$text = str_replace("Edad\n", "", $text);
$text = str_replace("Edad", "", $text);
$text = str_replace("Equipo", "", $text);
$text = str_replace("Nombre", "", $text);
$text = str_replace("Tiempo de Finales", "", $text);
$text = str_replace("Tiempo de Finales\n", "", $text);
$text = str_replace("Tiempo de Elim\n", "", $text);
$text = str_replace("Tiempo de Elim", "", $text);
$text = str_replace("Tiempo para Sembrado\n", "", $text);
$text = str_replace("Tiempo para Sembrado", "", $text);
$text = str_replace("Puntos\n", "", $text);
$text = str_replace("Puntos", "", $text);
$text = str_replace("Finales\n", "", $text);
$text = str_replace("Finales", "", $text);
$text = str_replace("Resultados", "", $text);


$nombre_archivo = "resultados/logs_".$clave_st.".txt"; 
 
    if(file_exists($nombre_archivo))
    {
        //$mensaje = "El Archivo $nombre_archivo se ha modificado";
    }
 
    else
    {
        //$mensaje = "El Archivo $nombre_archivo se ha creado";
    }
 
    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, $text))
        {
            echo "Se ha ejecutado correctamente";
        }
        else
        {
            echo "Ha habido un problema al crear el archivo";
        }
 
        fclose($archivo);
    }

    
    $file = fopen($nombre_archivo, "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
    $contador = 0;
    $linea1 = '';
    $linea2 = 'aaaa';
     $formato = 1;
while(!feof($file))
{
   // $formato = 1;
    $contador ++;
    $linea = trim(fgets($file));
    
    if ($contador == 1) {
        $linea1 = $linea;
    } else if ($contador == 2) {
        $linea2 = $linea;        
    }
    
    $pos = strpos($linea, "HY-TEK");
    $pos1 = strpos($linea, $linea2);

    if ($pos === false and $pos1 === false) {
        $revisor = trim ( $linea );
        //echo "---".$revisor."---<br />";
        if (empty($revisor)) {
            //echo "<strong>iiii".$linea. "</strong>";
        } else {
            //echo "\"".$revisor. "\"<br />";
            $pos2 = strpos($linea, "Evento");  
            $pos2x = strpos($linea, "#");  
            if ($pos2 !== false or $pos2x !== false) {
                 $formato = 1;
              $evento = $linea;
              $control = 1;
              $sql = "INSERT INTO sys_Evento (CompetenciaId, Nombre) VALUES ('$id_campeonato', '$evento')";
                echo $sql;
                    
            } else {
               //
              if ($control <= 4) {
                  if ($control == 1) {
                      $formato = 1;
                      if(is_numeric ( $linea )) {
                          echo "<br><strong>es un numero</strong><br>";
                          $formato = 2;
                          
                      }
                  }
                  
                  
                 echo "<br>formato: ".$formato."<br>";
                  if ($formato === 1) {
                     
                     if ($control == 1) {
                        $club = $linea;
                        //echo "<br><br><strong>linea 1</strong> \"".$linea."\"<br>";
                     } else if ($control == 2) {
                        // echo "<strong>linea 2</strong> ".$linea."<br>";
                        $edad = $linea; 
                     } else if ($control == 3) {
                        // echo "<strong>linea 3</strong> ".$linea."<br>";
                        $nadador = $linea; 
                     } else if ($control == 4) {
                        // echo "<strong>linea 4</strong> ".$linea."<br>";
                        $tiempo1 = explode(" ", $linea);
                        $lugar = $tiempo1[0];
                        $tiempo = $tiempo1[1];
                        $puntos = $tiempo1[2];
                        $control = 0;
                     }
                  } else {
                      if ($control == 4) {
                        $club = $linea;
                       // echo "<br><br><strong>linea 4</strong> \"".$linea."\"<br>";
                     } else if ($control == 1) {
                        // echo "<strong>linea 1</strong> ".$linea."<br>";
                        $edad = $linea; 
                     } else if ($control == 2) {
                        // echo "<strong>linea 2</strong> ".$linea."<br>";
                        $nadador = $linea; 
                     } else if ($control == 3) {
                        // echo "<strong>linea 3</strong> ".$linea."<br>";
                        $tiempo1 = explode(" ", $linea);
                        $lugar = $tiempo1[0];
                        $tiempo = $tiempo1[1];
                        $puntos = $tiempo1[2];
                        $control = 0;
                     }
                      
                  }
                  
                  
                  

              } 
              
              if ($control == 0) {
                  $pos4 = strpos($evento, "Relevo");  
                if ($pos4 === false) {
                  $sql0 = "SELECT id, Club FROM sys_Clubes WHERE Club = '$club' LIMIT 1";
                    $result0 = mysqli_query($connection, $sql0);

                    if (mysqli_num_rows($result0) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result0)) {
                            $id_club = $row["id"];
                        }
                    } else {
                        $sql1 = "INSERT INTO sys_Clubes (Club) "
                            . "VALUES ('$club')";
                        echo $sql1."<br>";
                           $result1 = mysqli_query($connection, $sql1);
                            $id_club = mysqli_insert_id($connection);
                    }
                    
                  echo "Evento:".$evento."<br />Club: ".$club."<br />Edad: ".$edad."<br />Nadador: ".$nadador."<br />Lugar: ".$lugar."<br />Tiempo: ".$tiempo."<br /><br />";
                  $sql = "INSERT INTO sys_Competidor (EventoId, Nombre, club_id, Edad, Posicion, TiempoSembrado, TiempoFinal, Puntos) "
                            . "VALUES ({$evento_id}, "
                            . "'$nadador', "
                            . "'$id_club', "
                            . "$edad, "
                            . "$lugar, "
                            . "'', "
                            . "'$tiempo', "
                            . "'$puntos')";
                            echo $sql;
                    //$result = mysqli_query($connection, $sql);
                }
              }
              $control ++;
            }
        }
        
      
    }
    
    
    

}
fclose($file);
*/

?>