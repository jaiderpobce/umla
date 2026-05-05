<?php /*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

    require_once 'lib/autoloader.class.php';
	require_once 'lib/init.class.php';
    require_once 'lib/auth.php';

$host = DB_HOST; /* Host name */
$user = DB_USER; /* User */
$password = DB_PASSWORD; /* Password */
$dbname = DB_NAME; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
mysqli_set_charset($con, "utf8");
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}


//$request = $_POST['request'];   // request

// Get username list

   // $search = $_POST['search'];
//echo "entro aqui";
    //$query = "SELECT * FROM productos WHERE codigo ='".$codigo."' LIMIT 1";
$rut = str_replace(".", "", $rut);
$query = "SELECT * FROM com_users  WHERE rut ='".$rut."' UNION ALL SELECT * FROM com_acompanantes  WHERE rut ='".$rut."' LIMIT 1";
    $result = mysqli_query($con,$query);
    
    if($row = mysqli_fetch_array($result) ){
       
       
        //echo $query1;
       
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $codigo = $row['id'];
        
        $response[] = array("value"=>$row['id'],"nombre"=>$nombre,"apellido"=>$row['apellido'],"direccion"=>$row['direccion'],"fecnac"=>$row['fecnac']);
    } else {
         $response[] = array("value"=>"","nombre"=>"","apellido"=>"","direccion"=>"","fecnac"=>"");
    }
    // encoding array to json format
    echo json_encode($response);
    exit;






?>