<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', '1');*/
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */

$page = 'personal';

/*
require_once 'lib/autoloader.class.php';
require_once 'lib/init.class.php';
require_once 'lib/auth.php';
*/
require_once 'include_all.php';


//DATOS DEL USUARIO
$nombre=$authj->rowff['nombre']." ".$authj->rowff['apellido'];
$usuario=$authj->rowff['id'];
$email=$authj->rowff['email'];

//DATOS DEL PAGO
$data = New TesoreriaPago();
$data->getOne($idpago);
$montopago=$data->row[0]['monto'];
$club=$data->row[0]['clubid'];
$data2 = New Club();
$data2->getOne($club);
$clubnombre=$data2->row[0]['club'];
$comentario='Cuota del '.$clubnombre;
$subject='Pago';

//echo $nombre.'-'.$usuario.'-'.$monto.'-'.$club.'-'.$clubnombre.'-'.$comentario;




			require("lib/class/FlowApi.class.php");

			//Para datos opcionales campo "optional" prepara un arreglo JSON
			$optional = array(
				"nombre" => $nombre,
				"usuario" => $authj->rowff['id'],
				"idpago" =>  $idpago,
				"Curso" => $comentario
			);
			$optional = json_encode($optional);

			//Prepara el arreglo de datos
			$params = array(
				"commerceOrder" => $idpago."-".uniqid(),
				"subject" => $subject,
				"currency" => "CLP",
				"amount" =>$montopago,
				"email" => $email,
				"paymentMethod" => 9,
				"urlConfirmation" => Config::get("BASEURL") . "/confirm.php?id=".$idpago,
				"urlReturn" => Config::get("BASEURL") ."/confirm1.php?id=".$idpago."&page=".$page_tpagos,
				"optional" => $optional
			);
			//Define el metodo a usar
			//print_r($params);
			$serviceName = "payment/create";

			try {
				// Instancia la clase FlowApi
				$flowApi = new FlowApi;
				// Ejecuta el servicio
				$response = $flowApi->send($serviceName, $params,"POST");
				//Prepara url para redireccionar el browser del pagador
				$redirect = $response["url"] . "?token=" . $response["token"];
				header("location:$redirect");
			} catch (Exception $e) {
				echo $e->getCode() . " - " . $e->getMessage();
			}







?>
