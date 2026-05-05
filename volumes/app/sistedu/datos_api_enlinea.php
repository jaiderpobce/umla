<?php  //ini_set('display_errors', '1');
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
//require_once 'lib/auth.php';

?>
<?php      
$db_req = Db::getInstance();
$sql_req = "Select com_club_metodo_pago.api,
				  com_club_metodo_pago.secret
					from com_club_metodo_pago 	
where com_club_metodo_pago.tipo_pago= :tipo_pago 
and com_club_metodo_pago.club= :club and eliminado='0'
";
$bind_req = array(
':tipo_pago' => $tipoPago,
':club' => $idClub
);
$cant_req = $db_req->run($sql_req, $bind_req);
$row_req1 = $db_req->fetchAll($sql_req, $bind_req);

if ($cant_req > 0) {

 
		foreach($row_req1 as $row_req){
		
		echo $row_req['api'].'_'.$row_req['secret'];
          
 	  }		 

 }else{
	echo '<label class="error col-md-6" >No hay Datos asociados a este Banco</label>';
} ?>                     