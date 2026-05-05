<?php   /*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

	require_once 'include_all.php';
        //require_once 'lib/autoloader.class.php';
	//require_once 'lib/init.class.php';
        $_page = 'misdatos';
        $_menu = 'misdatos';

	//require_once 'lib/auth.php';
        
        $nad = New Usuario();
          $nad->getOne($authj->rowff['id']);
        
        $col = New Colegio();
        $col->getAll();
        
        $gru = New Grupo();
        //$gru->getAll();
        
        
        $roles = "";
        if ($authj->rowff['nadador']==1) {
           $roles = "Nadador"; 
        }
        if ($authj->rowff['admin']==1) {
            if (!empty($roles)) {
                $roles .= " - ";
            }
           $roles .= "Admin"; 
        }
        if ($authj->rowff['apoderado']==1) {
            if (!empty($roles)) {
                $roles .= " - ";
            }
           $roles .= "Apoderado"; 
        }
        if ($authj->rowff['entrenador']==1) {
            if (!empty($roles)) {
                $roles .= " - ";
            }
           $roles .= "Entrenador"; 
        }
        if ($authj->rowff['tesorero']==1) {
            if (!empty($roles)) {
                $roles .= " - ";
            }
           $roles .= "Tesorero"; 
        }
        
        if ($authj->rowff['sysadmin']==1) {
            if (!empty($roles)) {
                $roles .= " - ";
            }
           $roles .= "Sysadmin"; 
        }
        
       


	require_once 'vistas/misdatos.php';   
 


?>
