            <?php ini_set('gd.jpeg_ignore_warning', 1);
	  require_once '../lib/autoloader.class.php';
	  require_once '../lib/init.class.php';
      require_once '../lib/auth.php';

      

function image_fix_orientation($filename) {
    $exif = exif_read_data($filename);
    if (!empty($exif['Orientation'])) {
        $image = imagecreatefromjpeg($filename);
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;

            case 6:
                $image = imagerotate($image, -90, 0);
                break;

            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }

        imagejpeg($image, $filename, 90);
    }
}


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
		 
        $valor = uniqid();
		
		$targetFile1 = "logo_".$id."_".$valor.".".$fileParts['extension'];
		
		/*$file = fopen("archivo.txt", "w");
    fwrite($file, $chequeo." lo h movido".$targetFile1." . el nombre del archivo".$_FILES["file"]["tmp_name"]." . peso".$filesize." . extension".$fileParts['extension']);
    fclose($file);*/
               // echo $authj->rowff['id'];

		if($file && move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile1))
		{
			
			
			//$comp->guardarDoc($id, $valor, $nombre, $ext);
                    
                        
                        
                //image_fix_orientation($targetFile1);
				 
				 $img=getimagesize($targetFile1);
                                 
                                  $thumb = new easyphpthumbnail;
   $ancho1=$img[0];
   $alto1=$img[1];
  //echo $ancho1."alto".$alto1."<br>";
   
   // la imagen grande
   // la imagen grande
  $anchop = 322;
   $altop = ($anchop * $alto1) / $ancho1;
   
   if($altop >= 322) {
      $crl = 0;
	  $crr = 0;
	  $altoc = ($altop - 322) / 2;
	  $altof = ($alto1 * $altoc) / $altop;
	  $crt = intval($altof);
	  $crb = intval($altof);
   }
   else {
      $altop = 322;
	  $anchop = ($ancho1 * $altop) / $alto1;
	  
	  $anchoc = ($anchop - 322) / 2;
	  $anchof = ($ancho1 * $anchoc) / $anchop;
	  
	  $anchop = 284;
	    
	  $crl = intval($anchof);
	  $crr = intval($anchof);	  
	  $crt = 0;
	  $crb = 0;
   }
   
   
  
    
     $thumb -> Thumbwidth = $anchop;
     $thumb -> Cropimage = array(1,1,$crl,$crr,$crt,$crb);
  	
   $thumb -> Thumbsaveas = 'jpg';
   $thumb -> Thumbprefix = 'l_';

   $thumb -> Createthumb($targetFile1,'file');  
   
   $user = New Club();
			
   $imagen=$valor.".".$fileParts['extension'];
   $user->actualizarLogo($imagen,$id);
			
	/*header('Content-type: application/json');
        echo json_encode(['target_file' => 'V_'.$valor]);*/
  //return $valor;
			
		}
	}
} ?>