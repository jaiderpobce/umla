<?php 

 // desabilitar para visualizar  errores
  // error_reporting(E_ALL);
//ini_set('display_errors', '1'); 

	 require_once 'include_all.php';

// detectar llamada al archivo php---------//
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// si La solicitud es por AJAX----------------//
if($isAjax) {
    
    // si el metodo es post -------------//
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

      //capturando valores de las varibles recibidas//
      $id = (isset($_POST['id'])) ? $_POST['id'] : '';
      $id_nota = (isset($_POST['id_nota'])) ? $_POST['id_nota'] : '';
      $email = (isset($_POST['email'])) ? $_POST['email'] : '';
      $matricula = (isset($_POST['matricula'])) ? $_POST['matricula'] : '';
      $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';

      $apaterno = (isset($_POST['apaterno'])) ? $_POST['apaterno'] : '';
      $amaterno = (isset($_POST['amaterno'])) ? $_POST['amaterno'] : '';
      $periodo = (isset($_POST['periodo'])) ? $_POST['periodo'] : '';
      $tetramestre = (isset($_POST['tetramestre'])) ? $_POST['tetramestre'] : '';
      $nivel = (isset($_POST['nivel'])) ? $_POST['nivel'] : '';
      $asignatura = (isset($_POST['asignatura'])) ? $_POST['asignatura'] : '';
      $calificacion = (isset($_POST['calificacion'])) ? $_POST['calificacion'] : '';
      $catedratico = (isset($_POST['catedratico'])) ? $_POST['catedratico'] : '';
    


      if (isset($_GET['action'])) {
        $action = $_GET['action'];
        
        $miClase  =new Notas();
        // verificando que el metodo existe en la clase----//
        if (method_exists($miClase, $action)) {
          switch($action){
            case 'add': //ingresar o actualizar
                 
              echo $miClase->$action($email,$matricula,$nombre,$apaterno,$amaterno,$periodo,$tetramestre,$nivel,$asignatura,$calificacion,$catedratico);
             
                break;
            case 'update_registro': //modificación
                    echo $miClase->$action($id,$email,$matricula,$nombre,$apaterno,$amaterno,$periodo,$tetramestre,$nivel,$asignatura,$calificacion,$catedratico);
                break;        
            case 'delete'://eliminar
                    echo $miClase->$action($id_nota);              
                break; 
                case 'getDatos_nota'://eliminar
                 // echo 'entre';
                  echo $miClase->$action($id_nota);              
              break;
              //getDatos 
           
          
                      
           }
         //  echo "Función  encontrada";
        } else {
        //  echo "Función  no encontrada";   
          $miClase = New Grupo();

          // verificando que el metodo existe en la clase----//
          if (method_exists($miClase, $action)) {
            switch($action){
              case 'getAll_list'://listar
                    echo $miClase->$action($tipoGrupo,$clubUsusario,'');  
                   // $tabla=$gru->getAll($tipoGrupo,$clubUsusario,'');           
                  break;        
            }
          //  echo "Función  encontrada";
          } 
        }
     }
     //$ = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
     

    } else {
        echo "Acceso denegado";
    }
} else {

  // si la llamada al archivo no es ajax----------------------------------------//
    
        $_page = 'notas_maestro';
        $_menu = 'archivos';

        
          
  $listvarall = "";
  $listvar = "";
  $listvaro = "";

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

if (!empty($pagi)) {
  $users->pag = $pagi;
}
 
        
  

   

   
 
  $usuariob=$authj->rowff22['id'];
  $admin=$authj->rowff22['admin'];

  $notas=new Notas();
  $opciones = array();
  if (!empty($pagi)) {
    $notas->pag = $pagi;
  }
  if (!empty($emailb)) {
    $opciones["email"] = $emailb;
}
if (!empty($matriculab)) {
    $opciones["matricula"] = $matriculab;
}


   //$tabla=$notas->getAllTable();
   $tabla=$notas->getAllTable(1,$usuariob,$admin,$opciones);
  // $marcas->getAllTipo();

	require_once 'vistas/v_notas_maestro.php';   
  
 

  }

