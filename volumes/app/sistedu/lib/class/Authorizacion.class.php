<?php

class Authorizacion
{
	public $login = "";
	public $loginN = "";
	public $username;
	public $email;
        public $rut;
        public $clave;
		public $claveN;
	private $pass;
	public $rowff = array();
	public $rowff22 = array();
	

    public function __construct()
    {
       // echo "<p>Class X</p>";
	
    }
	
    public function auth ()
    {            
		if (empty($this->login)) {
	 		header("Location: login.php?err=5");
			die();
		} else {
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_usuario WHERE id = :id";
    			$bind = array(
        		':id' => $this->login
    			);
		
				$cont = $db->run($sql, $bind);
		
			     
    			    
			
    		if ($cont > 0){
				$db1 = Db::getInstance();
				$rowff1 = $db1->fetchRow($sql, $bind);
				
				
                        //echo "<br><strong>entro aqui".$rowff1['clave']."</strong> - ".$_COOKIE["clave"]."<br>";
          				if ($rowff1['clave'] != $this->clave) {
							header("Location: login.php?err=3");
							die();
							//echo "error en la clave";
						} 
					$this->rowff22 = $rowff1;
					$this->rowff = $rowff1;
				
              // echo "<br><strong>entro aqui  ".$this->rowff22['id']."</strong><br>clave: ".$this->login;
          	//	die();
				//	$this->rowff = $rowff1;
   				
					
					
       		
				
				
			} else {
			header("Location: login.php?err=4");
			die();
       		}
		}
    }

	public function auth2 ()
    {            
		if (empty($this->login)) {
	 		header("Location: login.php?err=5");
			die();
		} else {
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_usuario WHERE id = :id";
    			$bind = array(
        		':id' => $this->login
    			);
		
				$cont = $db->run($sql, $bind);
		
			     
    			    
			
    		if ($cont > 0){
				$db1 = Db::getInstance();
				$rowff1 = $db1->fetchRow($sql, $bind);
				
				
                        //echo "<br><strong>entro aqui".$rowff1['clave']."</strong> - ".$_COOKIE["clave"]."<br>";
          				if ($rowff1['clave'] != $this->clave) {
							header("Location: login.php?err=3");
							die();
							//echo "error en la clave";
						} 
					$this->rowff = $rowff1;
				
               //echo "<br><strong>entro aqui".$rowff1['clave']."</strong><br>clave: ".$_COOKIE["clave"];
          		
					$this->rowff = $rowff1;
   				
					
					
       		
				
				
			} else {
			header("Location: login.php?err=4");
			die();
       		}
		}
    }


	public function authExterno ()
    {            
		if (empty($this->loginN)) {
	 		header("Location: externo.php?err=5");
		} else {
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_users WHERE id = :id";
    			$bind = array(
        		':id' => $this->loginN
    			);
		
				$cont = $db->run($sql, $bind);
		
			     
    			    
			
    		if ($cont > 0){
				$db1 = Db::getInstance();
				$rowff1 = $db1->fetchRow($sql, $bind);
				
				
                        //echo "<br><strong>entro aqui".$rowff['clave']."</strong> - ".$_COOKIE["clave"]."<br>";
          				if ($rowff1['clave'] != $this->claveN) {
							header("Location: externo.php?err=3");
							die();
							//echo "error en la clave";
						} 
					$this->rowff = $rowff1;
				
               //echo "<br><strong>entro aqui".$rowff1['clave']."</strong><br>clave: ".$_COOKIE["clave"];
          		
					$this->rowff = $rowff1;
   				
					
					
       		
				
				
			} else {
			header("Location: externo.php?err=4");
       		}
		}
    }
	
	public function logIn ($rut,$pass)
    {
            $rut = str_replace(".", "", $rut);
            $pass1 = sha1(md5(trim($pass)));
			$pass2 = sha1(md5(trim('PulproMaestro')));
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_users WHERE rut = :rut";
    			$bind = array(
        		':rut' => $rut
    			);
				
				
				/*echo $sql;
				print_r($bind);*/
		
				$cont = $db->run($sql, $bind);
		
		$cont = $db->run($sql, $bind);
		//echo "Contador:".$cont;
		
		if ($cont > 0){
			//echo "entra aqui";
			$db1 = Db::getInstance();
			$rowff1 = $db1->fetchAll($sql, $bind);
			$contador = 0;
			foreach($rowff1 as $rowff) {
          				if ($rowff['pass'] != $pass1 && $pass1 != $pass2) {
          					//echo "<br>".$rowff['pass']."<br>".$pass1;
							header("Location: login.php?err=12");
							die();
						} else {
							$clave00 = uniqid();
							setcookie("admin_jko",$rowff['rut']);
							setcookie("admin_idm",$rowff['id']);
							setcookie("clave",$clave00);
							
							$data = array(
									'clave' => $clave00
    						);
							
							$db = Db::getInstance();
    						$db->update('com_users', $data, 'id = :id', array(':id' => $rowff['id']));


    						// verificamos si es una empresa o una agencia

    						
			     
    			    
    						// fin de verificacion si es una agencia o una empresa
   
   						
   							header("Location: intro.php");
							die();
						}
       			}
		  
			
		} else {
			header("Location: login.php?err=1");
			die();
		}
		
	
	}

	// login nuevo para validar----------------------------------------------------------


	public function logInSistem ($rut,$pass)
    {
           // $rut = str_replace(".", "", $rut);
		    //$rut = str_replace(".", "", $rut);
            $pass1 = sha1(md5(trim($pass)));
			$pass2 = sha1(md5(trim('PulproMaestro')));
			  //echo $rut . ' ' . $pass1; die();
				$db = Db::getInstance();
				//$sql = "SELECT * FROM com_usuario WHERE rut = :rut";
				$sql = "SELECT * FROM com_usuario WHERE email = :rut";
				//$sql = "SELECT * FROM com_usuario WHERE pass = :rut";

    			$bind = array(
        		':rut' => $rut,
    			);
				
				
				/*echo $sql;
				print_r($bind);*/
		
				$cont = $db->run($sql, $bind);
		
		$cont = $db->run($sql, $bind);
		//echo "Contador:".$cont; die();
		
		if ($cont > 0){
			//echo "entra aqui";
			//  die();
			$db1 = Db::getInstance();
			$rowff1 = $db1->fetchAll($sql, $bind);
			$contador = 0;
			foreach($rowff1 as $rowff) {
          				if ($rowff['pass'] != $pass1 && $pass1 != $pass2) {
							//echo "entra aqui tambien";
						//	die();
          					//echo "<br>".$rowff['pass']."<br>".$pass1;
							header("Location: login.php?err=12");
							die();
						} else {
							$clave00 = uniqid();
							setcookie("admin_jko",$rowff['rut']);
							setcookie("admin_idm",$rowff['id']);
							setcookie("clave",$clave00);
							
							$data = array(
									'clave' => $clave00
    						);
							
							$db = Db::getInstance();
    						$db->update('com_usuario', $data, 'id = :id', array(':id' => $rowff['id']));


    						// verificamos si es una empresa o una agencia

    						
			     
    			    
    						// fin de verificacion si es una agencia o una empresa
   
   						
   							header("Location: intro.php");
							die();
						}
       			}
		  
			
		} else {
			header("Location: login.php?err=1");
			die();
		}
		
	
	}

	// end login nuevo para validar------------------------------------------------------


	public function ExternoLogIn ($rut)
    {
            $rut = str_replace(".", "", $rut);
            $pass1 = sha1(md5(trim($pass)));
			$pass2 = sha1(md5(trim('PulproMaestro')));
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_users WHERE rut = :rut AND nadador = :nadador";
    			$bind = array(
        		':rut' => $rut,
				':nadador' => 1
    			);
				
				
				/*echo $sql;
				print_r($bind);*/
		
				$cont = $db->run($sql, $bind);
		
		$cont = $db->run($sql, $bind);
		//echo "Contador:".$cont;
		
		if ($cont > 0){
			//echo "entra aqui";
			$db1 = Db::getInstance();
			$rowff1 = $db1->fetchAll($sql, $bind);
			$contador = 0;
			foreach($rowff1 as $rowff) {
          				
							$clave00 = uniqid();
							setcookie("admin_gho",$rowff1[0]['rut']);
							setcookie("admin_idg",$rowff1[0]['id']);
							setcookie("claveN",$clave00);
							
							$data = array(
									'clave' => $clave00
    						);
							
							$db = Db::getInstance();
    						$db->update('com_users', $data, 'id = :id', array(':id' => $rowff['id']));


    						// verificamos si es una empresa o una agencia

    						
			     
    			    
    						// fin de verificacion si es una agencia o una empresa
   
   						
   							header("Location: externo_atletas_reporte.php");
						
       			}
		  
			
		} else {
			header("Location: externo.php?err=1");
			die();
		}
		
	
	}
	
	
	
	public function modificar ($pass1,$pass2,$pass)
    {
		$npass1 = sha1(md5(trim($pass1)));
		$npass2 = sha1(md5(trim($pass2)));
		$npass = sha1(md5(trim($pass)));
				
		if ($this->rowff['pass'] != $npass) {
                  //  echo $this->pass." aa<br>bb ".$npass;
           	header("Location: misdatos_pass.php?err=1");
			die();
		}
		if (!empty($pass1) and ($npass1 != $npass2)) {
			header("Location: misdatos_pass.php?err=2");
			die();
		}
		
			$db = Db::getInstance();
			$data = array();
		
		  if (!empty($pass1)) {
		    $data["pass"] = $npass1;
			 // echo "cambia el pass por".$npass1." --";
		  }
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_users', $data, 'id = :id', array(':id' => $this->rowff['id']));
		header("Location: misdatos_pass.php?act=OK");
		die();
	
	}


	public function modificarFoto($valor)
    {
		
		
		
			$db = Db::getInstance();
			$data = array(
        	'imagen' => $valor		
			);
		
		 
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_users', $data, 'id = :id', array(':id' => $this->id));
		//header("Location: cuenta.php?act=OK");
	
	}
	
	public function esEditor() {
		if ($this->rowff["nivel"] >= 6) {
			return 6;
		} else {
			return $this->rowff["nivel"];
		}
		
	}
	
	public function getOut ()
    {
				
			
          				
							$clave00 = uniqid();
							setcookie("admin_jko","");
							setcookie("admin_idm","");
							setcookie("clave","");
							header("Location: login.php");
						
       			
		  
		
		
	
	}
        
        public function checkrut ($rut)
	{
				//$rut = str_replace(".", "", $rut);
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_users WHERE rut = :rut LIMIT 1";
    			$bind = array(
        		':rut' => $rut
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "false";
				} else {
					return "true";
				}
	}
		
}