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
		
		
		$file = $_FILES["file"]["name"];
		$filetype = $_FILES["file"]["type"];
		$filesize = $_FILES["file"]["size"];
		$fileParts  = pathinfo($_FILES['file']['name']);
                $nombre = $fileParts['filename'];
                $ext = $fileParts['extension'];
		 
                //$valor = uniqid();
                $valor = $unico;
		
		$targetFile1 = "excel/xls_".$valor.".".$fileParts['extension'];
                if($file && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile1))
		{
                    //echo $valor;
                    $response = array (
                        'status' => 'ok',
                        'info'   => 'Todo salio bien'
                    );
                    echo json_encode($response);
                }
		
		
 
			
		}
	}
 ?>