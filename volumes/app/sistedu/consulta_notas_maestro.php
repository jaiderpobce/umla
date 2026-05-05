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
      $tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
      $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
      $piscina = (isset($_POST['piscina'])) ? $_POST['piscina'] : '';
      $id = (isset($_POST['id'])) ? $_POST['id'] : '';
    


      if (isset($_GET['action'])) {
        $action = $_GET['action'];
        
        $miClase = New Marcas();
        // verificando que el metodo existe en la clase----//
        if (method_exists($miClase, $action)) {
          switch($action){
            case 'add': //ingresar o actualizar
                 
                    echo $miClase->$action($tipo,$nombre,$piscina);
             
                break;
            case 'update': //modificación
                    echo $miClase->$action($id,$tipo,$nombre,$piscina);
                break;        
            case 'delete'://eliminar
                    echo $miClase->$action($id);              
                break;  
           
          
                      
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
    
        $_page = 'consulta_notas_maestro';
        $_menu = 'notas';

        
          
  $listvarall = "";
  $listvar = "";
  $listvaro = "";
 
        
  
 //$opciones = array();
   

   
   //$club = New Club();
   //$club->getAll($clubUsusario);
  
   //$entrenador = New Usuario();
  // $entrenador->getCoachAll();
  
   //$id_ent=$authj->rowff['sysadmin'];
  // $id_ent = $authj->rowff['id']; 
   
   $usuariob=$authj->rowff22['id'];
   $admin=$authj->rowff22['admin'];
  // $sesion = New Sesion();
  //  echo $usuariob.' - '.$admin; die();
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
   
  // $tabla=$notas->getAllTable($usuariob,$admin);
 // echo $usuariob; die();

 //$texto = "DE00854";
 //$hash_md5 = sha1(md5(trim($texto)));//md5($texto);
 //sha1(md5(trim($matricula)))
 //echo $hash_md5; die();

   $tabla=$notas->getAllTable(1,$usuariob,$admin,$opciones);
  // $marcas->getAllTipo();

	require_once 'vistas/v_consulta_notas_maestro.php';   
  
 

  }

