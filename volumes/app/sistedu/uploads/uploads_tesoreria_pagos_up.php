<?php  
	  require_once '../lib/autoloader.class.php';
	  require_once '../lib/init.class.php';
      require_once '../lib/auth.php';





if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if(isset($_GET["delete"]) && $_GET["delete"] == true)
	{
		
	}
	else
	{
		/*$chequeo = "empezamos";
		is_array($file) ? $chequeo = 'Array' : $chequeo = 'No es un array';*/
		
		$comp = New TesoreriaPago();
		$file = $_FILES["file"]["name"];
		$filetype = $_FILES["file"]["type"];
		$filesize = $_FILES["file"]["size"];
		$fileParts  = pathinfo($_FILES['file']['name']);
        $imagen = $fileParts['filename'];
        $ext = $fileParts['extension'];
		 
        $valor = uniqid();
		
		$targetFile1 = "tesoreria/PAGO_".$id."_".$valor.".".$fileParts['extension'];

		
		
		/*$file = fopen("archivo.txt", "w");
    fwrite($file, $chequeo." lo h movido".$targetFile1." . el nombre del archivo".$_FILES["file"]["tmp_name"]." . peso".$filesize." . extension".$fileParts['extension']);
    fclose($file);*/

		if($file && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile1))
		{
			
			echo "respuesta";
			
			$comp->guardarDoc($id, $valor, $imagen, $ext,$authj->rowff['id']);
			echo json_encode(array("res" => false, "mensaje" => $id.", ".$valor.", ".$imagen.", ".$ext));

			//chmod($targetFile1, 0777); //COMENTAR EN PRODUCCION
			//$targetFile2 = $path_web."NOS_".$id."_".$valor.".".$fileParts['extension'];//COMENTAR /EN PRODUCCION
			//copy($targetFile1, $targetFile2);//COMENTAR EN PRODUCCION
			//chmod($targetFile2, 0777);


		}

		
	}
}