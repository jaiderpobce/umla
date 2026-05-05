            <?php 
            ini_set('gd.jpeg_ignore_warning', 1);
            require_once '../lib/autoloader.class.php';
            require_once '../lib/init.class.php';
            require_once '../lib/auth.php';


            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                if (isset($_GET["delete"]) && $_GET["delete"] == true) {
                } else {
                    /*$chequeo = "empezamos";
		is_array($file) ? $chequeo = 'Array' : $chequeo = 'No es un array';*/


                    $file = $_FILES["file"]["name"];
                    $filetype = $_FILES["file"]["type"];
                    $filesize = $_FILES["file"]["size"];
                    $fileParts  = pathinfo($_FILES['file']['name']);
                    $nombre = $fileParts['filename'];
                    $ext = strtolower($fileParts['extension']);

                    $valor = uniqid();

                    $targetFile1 = "zip/" . $valor . "." . $ext;

                    /*$file = fopen("archivo.txt", "w");
    fwrite($file, $chequeo." lo h movido".$targetFile1." . el nombre del archivo".$_FILES["file"]["tmp_name"]." . peso".$filesize." . extension".$fileParts['extension']);
    fclose($file);*/
                    // echo $authj->rowff['id'];

                    if ($ext == "zip") {
                        if ($file && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile1)) {


                            $CZip = new Competencia();

                            $CZip->agregarCompetenciaZip($valor,$nombre,$authj->rowff['id'],'1');

                            
                            

                            $micarpeta = "zip/".$valor;

                            if (!file_exists($micarpeta)) {
                                mkdir($micarpeta, 0777, true);
                            }

                            $zip = new ZipArchive;
                            if ($zip->open($targetFile1) === TRUE) {
                                //$path = getcwd(); // Path del directorio actual
                                $zip->extractTo($micarpeta); // Extraemos el contenido en el directorio actual
                                $zip->close();
                               // echo 'ok';

                              
                                if ($handler = opendir($micarpeta)) {
                                    while (false !== ($archivo = readdir($handler))) {


                                        if ($archivo != "." && $archivo != ".." && substr($archivo,-4)==".ev3") {

                                            

                                            $file = fopen($micarpeta."/".$archivo, "r");
                                            $no_linea = 1;
                                            while(!feof($file) && empty($error)) {
                                                $line = fgets($file);

                                                $datos_comp =  explode(";", $line);

                                                if ($no_linea == 1) {


                                                    /*$file = fopen("archivo.txt", "w");
                                            fwrite($file, $chequeo." lo h movido".$targetFile1." . el nombre del archivo".$archivo." . peso".$filesize." . line".$fileParts['extension']);
                                            fclose($file);*/
                                                   
                                                    $piscina_meet = $datos_comp[5];

                                                    

                                                    $piscina = Funciones::getPiscina($piscina_meet);

                                                    $max_pruebas = $datos_comp[19];
                                                    if (empty($max_pruebas)) {
                                                        $max_pruebas = 0;
                                                    }

                                                    $desde = Funciones::fechaEngToDB($datos_comp[2]);
                                                    $hasta = Funciones::fechaEngToDB($datos_comp[3]);
                                                    $fec_categoria = Funciones::fechaEngToDB($datos_comp[4]);

                                                    $datosN = array(
                                                        'nombre' => Funciones::encodeUTF8($datos_comp[0]),
                                                        'abre' => Funciones::encodeUTF8($abre),
                                                        'lugar' => Funciones::encodeUTF8($datos_comp[1]),
                                                        'piscina' => $piscina,
                                                        'piscina_meet' => $piscina_meet,
                                                        'federacion' => $federacion,
                                                        'desde' => $desde,
                                                        'hasta' => $hasta,
                                                        'fec_categoria' => $fec_categoria,
                                                        'local' => '0',
                                                        'bus' => '0',
                                                        'alojamiento' => '0',
                                                        'inscripciones_hasta' => Funciones::fechaEngToDB($datos_comp[23]),
                                                        'notas' => '',
                                                        'max_pruebas' => $max_pruebas,
                                                        'max_jornadas' => '0',
                                                        'user_id' => $authj->rowff['id'],
                                                        'club_id' => $authj->rowff['club'],
                                                        'cargado_zip' => '1'
                                                    );

                                                    $info = implode ( ";" , $datosN );

                                                     $file0 = fopen("archivo1.txt", "w");
                                                    fwrite($file0, $info);
                                                    fclose($file0);
                                                    
                                               
                                                  $CZip->agregar($datosN);

                                                } else if (!empty($line)) {

                                                    

                                                    $id_comp = $CZip->id;

                                                    

                                                    

                                                    $Tpiscina = array();
                                                    $Tpiscina['piscina'] = Funciones::getPiscina($datos_comp[25]);
                                                    $Tpiscina['piscina_meet'] = $datos_comp[25];

                                                    

                                                    $maxn = array();
                                                    $maxn['maxn'] = $datos_comp[27];
                                                    $maxn['maxnr'] = $datos_comp[28];
                                                    $maxn['maxnt'] = $datos_comp[26];

                                                   /* $info = implode ( ";" , $Tpiscina );
                                                    $info1 = implode ( ";" , $maxn );*/

                                                    $file0 = fopen("archivo.txt", "w");
                                                    fwrite($file0, $datos_comp[25]);
                                                    fclose($file0); 


                                                      

                                                    // revisamos o agregamos la jornada antes de agregar la prueba
                                                    //unset($jornada);

                                                    

                                                    $jornada = $CZip->getJornada($id_comp, $datos_comp[21]);


                                                    if (empty($jornada)) {

                                                        $dia_comp = $datos_comp[23]-1;
                                                        
                                                        if ($dia_comp >0){
                                                            $mod_date = strtotime($desde."+ ".$dia_comp." days");
                                                            $fecha_jornada = date("Y-m-d",$mod_date);
                                                        } else {
                                                            $fecha_jornada = $desde;
                                                        }   
                                                        
                                                        $partesHora = explode(":", $datos_comp[24]);
                                                    
                                                        $minutos =  substr($partesHora[1], 0, 2);
                                                        $ampm = substr($partesHora[1], 2, 4);
    
                                                       /* echo ",minutos".$minutos."<br>";
                                                        echo "ampm".$ampm."<br>";*/
                                                        if ($ampm == 'PM') {
                                                            $hora = $partesHora[0]+12;
                                                        } else {
                                                            $hora = $partesHora[0];
                                                        }
                                                        // echo "horamodificada".$hora."<br>";
    
                                                        $lahora = $hora.":".$minutos.":00";

                                                        

                                                        $toda_la_info = $fecha_jornada.", ".$lahora.", ".$datos_comp[21].", ".$info .", ".$info1;

                                                        /*$file0 = fopen("archivo.txt", "w");
                                                    fwrite($file0, $toda_la_info);
                                                    fclose($file0);*/

                                                    /* $file0 = fopen("archivo.txt", "w");
                                                    fwrite($file0, $toda_la_info);
                                                    fclose($file0);         */                                         

                                                        $jornadaP = $CZip->agregarJornada($fecha_jornada, $lahora, $datos_comp[21], $Tpiscina, $maxn);

                                                    } else {
                                                        $jornadaP = $jornada[0]['id'];
                                                    }


                                                    // terminamos de revisar o agregar la jornada
                                                    $categoria = 0;

                                                    $edad_desde = $datos_comp[6];
                                                    $edad_hasta = $datos_comp[7];

                                                    $edad_desde_cal = ($datos_comp[6]);
                                                    $edad_hasta_cal = ($datos_comp[7])+1;

                                                    $date_desde = strtotime($fec_categoria."- ".$edad_desde_cal." years");
                                                    $fecha_desde = date("Y-m-d",$date_desde);

                                                    $date_hasta = strtotime($fec_categoria."- ".$edad_hasta_cal." years");
                                                    $fecha_hasta = date("Y-m-d",$date_hasta);

                                                    $edades = array();
                                                    $edades['edad_desde'] = $edad_desde;
                                                    $edades['edad_hasta'] = $edad_hasta;
                                                    $edades['fecha_desde'] =  $fecha_desde;
                                                    $edades['fecha_hasta'] =  $fecha_hasta;

                                                    

                                                    $prueba_arr = Prueba::getByValoresMeet($datos_comp[9], $datos_comp[8]);
                                                                                                      
                                                    $prueba = $prueba_arr[0]['id'];
                                                    $tipo_pru = $prueba_arr[0]['relevo'];
                                                    
                                                    if ($datos_comp[5]=='W' || $datos_comp[5]=='G') {
                                                        $genero = 1;
                                                    } else if ($datos_comp[5]=='M' || $datos_comp[5]=='B') {
                                                        $genero = 2;

                                                    } else if ($datos_comp[5]=='X') {
                                                        $genero = 3;

                                                    }


                                                    $mm_50 = $datos_comp[16];
                                                    $mm_y =  $datos_comp[17];
                                                    $mm_25 =  $datos_comp[18];

                                                  
                                                    if (!empty($mm_50)) {
                                                        $mm_50 = str_replace(",", ".", $mm_50);
                                                    }
                                                    if (!empty($mm_25)) {
                                                        $mm_25 = str_replace(",", ".", $mm_25);
                                                    }
                                                    if (!empty($mm_y)) {
                                                        $mm_y = str_replace(",", ".", $mm_y);
                                                    }

                                                    $marcas = $mm_50." - ".$mm_y." - ".$mm_25;

                                                    



                                                    /*
                                                    $mm_50 = ($datos_comp[16])*1000;
                                                    $mm_y = ($datos_comp[17])*1000;
                                                    $mm_25 = ($datos_comp[18])*1000;
                                                    */

                                                    if ($datos_comp[25] == "S") {
                                                        $marca_min = $mm_25;
                                                    } else if ($datos_comp[25] == "L") {
                                                        $marca_min = $mm_50;
                                                    }  else if ($datos_comp[254] == "Y") {
                                                        $marca_min = $mm_y;
                                                    }

                                                    $marca_minA = $datos_comp[25]." - ".$marca_minA." - ".$marca_min;

                                                    $mm = array();
                                                    $mm['mm_50'] = $mm_50;
                                                    $mm['mm_y'] = $mm_y;
                                                    $mm['mm_25'] = $mm_25;


                                                    180, 1, , , 0, 1, 329, , Array, Array, Array, Array

                                                    $contenidoff = $id_comp.", ".$datos_comp[0].", ".$prueba.", ".$tipo_pru.", ".$categoria.", ".$genero.", ".$jornadaP.", ".$marca_min.", ".$mm.", ".$maxn.", ".$edades.", ".$Tpiscina;
                                                    $file0 = fopen("archivo2.txt", "w");
                                                    fwrite($file0,  $contenidoff);
                                                    fclose($file0); 
                                                    


                                                    

                                           

                                                    $CZip->agregarPrueba($id_comp, $datos_comp[0], $prueba, $tipo_pru, $categoria, $genero, $jornadaP, $marca_min, $mm, $maxn, $edades, $Tpiscina);
                                                }
                                                

                                                $no_linea ++;



                                            }

                                           // echo "$file<br>";
                                        }
                                            
                                    }
                                    closedir($handler);
                                    return "Ok";
                                }


                            } else {
                               // echo 'failed';
                            }

                            /*header('Content-type: application/json');
                            echo json_encode(['target_file' => 'V_'.$valor]);*/
                            //return $valor;

                        }
                    } else {
                         return "error";
                    }
                }
            } 
            
           
                                                    
                                                    ?>