<?php
class Usuario_o
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 25;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
        public $usuario;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "com_users_otros";
	
    }
	

		
    public function agregar ($rut, $nombre, $apellido, $email, $roles, $datosN = array())
    {
           
	   if (empty($nombre)) {
		   header("Location: usuarios.php?err=1");
	   } else {
               
               
              
                    $telf = str_replace("-", "", $datosN['telefono']);
                    $telf = str_replace(" ", "", $telf);
			//$pass = uniqid();
			$db = Db::getInstance();
			$data = array(
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'email' => $email,
                            'rut' => $rut,
                            'pass' => $pass,
                            'genero' => $datosN['genero'],
                            'fecnac' => $datosN['fecnac'],
                            'direccion' => $datosN['direccion'],
                            'telefono' => $telf,
                            'nivel' => '4',
                            'nadador' => $roles['nadador'],
                            'entrenador' => $roles['entrenador'],
                            'sysadmin' => $roles['sysadmin'],
                            'tesorero' => $roles['tesorero'],
                            'apoderado' => $roles['apoderado'],
                            'fecin' => date('Y-m-d H:i:s'),
                            'notas' => $datosN['notas']
                        );
                        if ($roles['nadador'] == '1') {
                            
                            $data['colegio'] = $datosN['colegio'];
                            $data['licencia'] = $datosN['licencia'];
                            $data['grupo'] = $datosN['grupo'];
                            
                        }
                        
                $db->insert($this->tabla, $data);
		$this->id = $db->lastInsertId();
                
               
                        
                
              
		//header("Location: usuarios_up.php?id=".$this->id);
		  // header("Location: usuarios.php");
	   }
		
    }
	
	
	
	public function modificar ($id, $rut, $nombre, $apellido, $email, $roles, $datosN = array())
    {
	   if (empty($id)) {
		   header("Location: usuarios.php");
	   
		
	   } else {
               $rut = str_replace(".", "", $rut);
               $telf = str_replace("-", "", $datosN['telefono']);
               $telf = str_replace(" ", "", $telf);
		
			$db = Db::getInstance();
                        if ($datosN['origen'] == 'misdatos') {
                            $data = array(                           
                            'email' => $email,                           
                            'direccion' => $datosN['direccion'],
                            'telefono' => $telf
                            );
                        } else {
                                if (empty($nombre) or empty($apellido) or empty($rut)) {
                                    header("Location: usuarios_mod.php?id=".$id);
                                    die();
                                } else {                                
                            
                                $data = array(
                                'nombre' => $nombre,
                                'apellido' => $apellido,
                                'email' => $email,
                                'rut' => $rut,
                                'genero' => $datosN['genero'],
                                'fecnac' => $datosN['fecnac'],
                                'direccion' => $datosN['direccion'],
                                'telefono' => $telf,
                                'entrenador' => $roles['entrenador'],
                                'sysadmin' => $roles['sysadmin'],
                                'tesorero' => $roles['tesorero'],
                                'apoderado' => $roles['apoderado'],                           
                                'notas' => $datosN['notas']
                                );
                                if ($roles['nadador'] == '1') {    
                                    $data['licencia'] = $datosN['licencia'];
                                    $data['grupo'] = $datosN['grupo'];                            
                                }
                            }
                         }
			
                        if ($roles['nadador'] == '1') {
                            
                            $data['colegio'] = $datosN['colegio'];
                            
                        }
                        
                        //print_r($data);
    	//$db->insert('com_proyectos', $data);
		   
                        $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
                        
                        if ($roles['nadador'] == '1') {
                            $this->asignarCategoria($id);    
                        }
                       
		   
		//header("Location: usuarios.php");
	   }
		
    }


    public function modificarPass ()
    {
	   if (empty($this->id)) {
		   header("Location: usuarios.php");
	   }
		else if (empty($this->pass)) {
		   header("Location: usuarios_mod.php?id=".$this->id);
	   } else {
		
			$db = Db::getInstance();
			$data = array(
        	'pass' => $this->pass
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: usuarios.php");
	   }
		
    }
    
    public function actualizarFoto($valor,$id) {
        
        $db = Db::getInstance();
			$data = array(
                            'imagen' => $valor
                        );

		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
        
    }
	
    public function agregarApoderado($id, $rut) {
        $elrow = $this->getOneByRutExt ($rut, 'nadador');
        if (!empty($elrow)) {
            
                        $db = Null;
                        $db = Db::getInstance();
			$sql = "SELECT * FROM com_apoderados WHERE apoderado = :apoderado AND nadador = :nadador LIMIT 1";
    			$bind = array(
        		':apoderado' => $id,
                        ':nadador' => $elrow[0]['id']
    			);
                        /*echo $sql."<br>";
                        print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
                                
                                //echo "contador de apoderados /nadador:".$cont;
				if ($cont == 0) {
                                        $db1 = Null;
					$db1 = Db::getInstance();
                                        $data1 = array(
                                            'apoderado' => $id,
                                            'nadador' => $elrow[0]['id'],
                                        );
                                        

                                $db1->insert('com_apoderados', $data1);
					
				} else {
					//echo "encontró, no hace nada";
					
					
				}
            
        } 
        
    }
    public function deleteApoderado($id, $nadador) {
       // echo "<br>apoderado: ".$id." nadador:".$nadador;
        $db = Db::getInstance();
        $db->delete('com_apoderados', "apoderado=:id AND nadador=:nadador" , array(':id' => $id,':nadador' => $nadador)); 
    }
	
	public function getAll ($paginado=1, $tipo='todos', $tipoLimit='')
	{
		      
				$db = Db::getInstance();
		     
				$sql = "SELECT ".$this->tabla.".*, com_grupos.grupo FROM ".$this->tabla. " "
                                        . "LEFT JOIN com_grupos ON com_users.grupo = com_grupos.id ";
                                if ($tipoLimit  == 'apoderado') {                                    
                                    $sql .= "INNER JOIN com_apoderados ON ".$this->tabla.".id = com_apoderados.nadador ";
                                    $sql .= "WHERE com_apoderados.apoderado = :apoderado";
                                    $bind = array(
                                        ':apoderado' => $this->usuario['id']
                                    );
                                    
                                } else {
                                    $sql .= "WHERE ".$this->tabla.".id > :id";
                                    $bind = array(
                                        ':id' => '0'
                                    );
                                }
                                
                                if ($tipo != 'todos' and !empty($tipo)) {
                                    $tipos = explode("-", $tipo);
                                    $countipo = count($tipos);
                                    $contador = 1;
                                    $sql .= " AND (";
                                    foreach ($tipos as $tipUser) {
                                        $sql .= $this->tabla.".". $tipUser." = :".$tipUser;
                                        if ($contador < $countipo) {
                                            $sql .= " or ";
                                        }
                                        $bind[":".$tipUser] = '1';
                                        $contador ++;
                                    }
                                    $sql .= ")";
                                    
                                }
				
                                if (empty($this->orden)) {
                                            $orden = $this->tabla.".apellido, ".$this->tabla.".nombre";
                                    } else {
                                            $orden = $this->orden;
                                    }


                                    if ($this->tiporden == 'desc') {
                                            $tiporden = " desc";
                                    } else {
                                            $tiporden = "";
                                    }
                                if ($paginado == 1) {
                                        $total_results = $db->run($sql, $bind);
                                        $this->total_results = $total_results;
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
                                    

                                    $sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 
                                } else {
                                   $sql .= " ORDER BY ".$orden.$tiporden;  
                                }
				/*
				echo $sql;
                                print_r($bind);*/


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					$this->row = $row_p;
				}
	}
        
        public function getCoachAll ()
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM ".$this->tabla." WHERE entrenador = :id ORDER BY apellido, nombre";
                                        $bind = array(
                                            ':id' => '1'
                                        );
					
				
				


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					$this->row = $row_p;
				}
	}
	
	
	public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					$this->row = $row_p;
				}
	}
        
        public function getGenero ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT genero FROM ".$this->tabla." WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					return $row_p[0]['genero'];
				}
	}
        
        public function getOneByRut ($rut, $tipo = "")
	{
            $rut = str_replace(".", "", $rut);
			$db = Db::getInstance();
			$sql = "SELECT * FROM ".$this->tabla." WHERE rut = :rut";
    			$bind = array(
        		':rut' => $rut
    			);
                        if (!empty($tipo)) {
                            $sql .= " AND ".$tipo." = 1";
                        }
                        
                        $sql .= " LIMIT 1";
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					$this->row = "";
                                        $this->check = 0;
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
                                        $this->check = 1;
					$this->row = $row_p;
				}
	}
        
        public function getOneByRutExt ($rut, $tipo = "")
	{
            $rut = str_replace(".", "", $rut);
			$db = Db::getInstance();
			$sql = "SELECT * FROM ".$this->tabla." WHERE rut = :rut";
    			$bind = array(
        		':rut' => $rut
    			);
                        if (!empty($tipo)) {
                            $sql .= " AND ".$tipo." = 1";
                        }
                        
                        $sql .= " LIMIT 1";
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
                                        //$this->check = 1;
					return $row_p;
				}
	}
        
        static function getOneByName ($nombre,$concatenador)
	{
            $nombre = str_replace(", ", ",", $nombre);
            $nombre = str_replace(",", " ", $nombre);
            $nombres = explode(" ", $nombre);
            
			$db = Db::getInstance();
			$sql = "SELECT * FROM com_users WHERE nadador = :nadador AND";
    			$bind = array(
        		':nadador' => 1
    			);
                        $conti = 1;
                        foreach($nombres as $word){
                            if ($conti >1){
                                $sql.= " ".$concatenador;
                            } 
                            $sql .= " (nombre LIKE :nombre_".$conti." OR apellido LIKE :nombre_".$conti.")";
                            $bind[":nombre_".$conti] = "%$word%";
                            $conti ++;
                        }
                        
                        /*
		        echo $sql;
                        print_r($bind);*/
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					return $row_p;
				}
	}
        
        public function checkemail ($rut)
	{
				$rut = str_replace(".", "", $rut);
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE rut = :rut LIMIT 1";
    			$bind = array(
        		':rut' => $rut
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "true";
				} else {
					return "false";
				}
	}
        
        public function asignarCategoria($user) {
                        $sqlm = "SELECT EXTRACT(YEAR FROM fecnac) AS anonac FROM ".$this->tabla." WHERE id = :id LIMIT 1";
    			$bindm = array(
        		':id' => $user
    			);
                        
                        echo $sqlm;
                        print_r($bindm);
                        
                        $db2 = Null;
                        $db2 = Db::getInstance();
                        
                        $cont = $db2->run($sqlm, $bindm);
                        
                        if ($cont == 0) {
					
					return "";
				} else {
					$db1 = Null;
					$db1 = Db::getInstance();
					$rowff1 = $db1->fetchAll($sqlm, $bindm);
                                        $anonac = $rowff1[0]['anonac'];
                                        $edad = date('Y')-$anonac;
                                        echo $user." - ".$edad."<br>";
                                        
                                        $categ = New Categoria();
                                        $categ->asignarCategoria($user,$edad);
				}
                        
                      
                        
                        
                       
            
            
        }
        
        public function getRepresentados($id) {
            
            $db = Db::getInstance();
		     
				$sql = "SELECT ".$this->tabla.".*, com_grupos.grupo FROM ".$this->tabla. " "
                                        . "LEFT JOIN com_grupos ON com_users.grupo = com_grupos.id ";                                   
                                    $sql .= "INNER JOIN com_apoderados ON ".$this->tabla.".id = com_apoderados.nadador ";
                                    $sql .= "WHERE com_apoderados.apoderado = :apoderado";
                                    $bind = array(
                                        ':apoderado' => $id
                                    );
                                    
                             
                          
				
                                if (empty($this->orden)) {
                                            $orden = $this->tabla.".apellido, ".$this->tabla.".nombre";
                                    } else {
                                            $orden = $this->orden;
                                    }


                                    if ($this->tiporden == 'desc') {
                                            $tiporden = " desc";
                                    } else {
                                            $tiporden = "";
                                    }
                              
                                   $sql .= " ORDER BY ".$orden.$tiporden;  
                                
				
				/*echo $sql;
                                print_r($bind);*/


		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
                                   // echo "No encontro";
					$row_p = "";
                                       // $this->representados = "";
				} else {
					//echo "SI encontro";
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				  
					$this->representados = $row_p;
				}
            
        }
        
        public function puedeEditar($apoderado,$id){
            $db = Db::getInstance();
				$sql = "SELECT * FROM com_apoderados WHERE apoderado = :apoderado AND nadador = :nadador LIMIT 1";
    			$bind = array(
                            ':apoderado' => $apoderado,
                            ':nadador' => $id
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return 0;
				} else {
					return 1;
				}
            
        }
      



	
	
	
	
		
}