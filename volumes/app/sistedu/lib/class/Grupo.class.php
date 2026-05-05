<?php
class Grupo
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;

	public $estado;
	public $row;

	public $pag = 1;
	public $limit = 10;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "com_grupos";
	
    }
	
    private function getOrden() {
		
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE orden > :id ORDER BY orden DESC LIMIT 1";
                                $bind = array(
                                ':id' => 0
                                );
		        
				$cont = $db->run($sql, $bind);
				//echo "contador:".$cont;
				if ($cont == 0) {
					$orden = 1;
				} else {
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				   foreach($row_p as $row_p1) {
						$orden = $row_p1['orden'] + 1;
					}
				}
		
		return sprintf($orden);
	}
		
	public function agregar ($grupo,$entrenador,$tipo_grupo,$club,$idUser)
    {
	   if (empty($grupo) or empty($entrenador)) {
		   header("Location: grupos.php?err=1");
	   } else {
               
            //$orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            'grupo' => $grupo,
                            'entrenador' => $entrenador,
                            'tipo_grupo' => $tipo_grupo,
                            'club' => $club,
                            'fecha_cre' => date('Y-m-d h:i:s'),
                            'user_cre' => $idUser,
                        );
            $db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();
		
		header("Location: grupos.php?add=ok");
		
	   }
		
    }
	
	
	
	public function modificar ()
    {
	   if (empty($this->id)) {
		   header("Location: usuarios.php");
	   }
		else if (empty($this->email)) {
		   header("Location: usuarios_mod.php?id=".$this->id);
	   } else {
		
			$db = Db::getInstance();
			$data = array(
        	'nombre' => $this->nombre,
        	'email' => $this->email,
        	'sucursal' => $this->sucursal,
        	'nivel' => $this->nivel
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));
		   
		header("Location: usuarios.php");
	   }
		
    }



	
	public function getAll ($tipo_grupo,$club,$noGrupo)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ".$this->tabla.".*, 
					com_users.nombre, com_users.apellido,
					com_tipo_grupo.id as id_tipo_grupo,
					com_tipo_grupo.tipo_grupo as name_tipo_grupo,
					com_clubes.id as id_club,
					com_clubes.club as name_club
					FROM ".$this->tabla." LEFT JOIN com_users ON ".$this->tabla.".entrenador = com_users.id 
					LEFT JOIN com_tipo_grupo ON ".$this->tabla.".tipo_grupo = com_tipo_grupo.id 
					LEFT JOIN com_clubes ON ".$this->tabla.".club = com_clubes.id 
					";

    				if (!empty($noGrupo)) {
                        $sql .= " WHERE ".$this->tabla.".id != :id";
                         $bind = array(
                                ':id' =>$noGrupo
                            );
                    }else{
            			$sql .= "WHERE ".$this->tabla.".id > :id ";
                            $bind = array(
                                ':id' => '0'
                            );

                    }
		
					
					if (!empty($tipo_grupo)) {
                        $sql .= " AND ".$this->tabla.".tipo_grupo in (".$tipo_grupo.")";
                        //$bind[":tipo_grupo"] = $tipo_grupo;
                    }

        			if (!empty($club)) {
                        $sql .= " AND ".$this->tabla.".club = :club";
                        $bind[":club"] = $club;
                    }


				
					$sql .= " ORDER BY grupo"; 
		
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					return $row_p;
				}
	}
	
	public function getAll_list($tipo_grupo,$club,$noGrupo)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ".$this->tabla.".*, 
					com_users.nombre, com_users.apellido,
					com_tipo_grupo.id as id_tipo_grupo,
					com_tipo_grupo.tipo_grupo as name_tipo_grupo,
					com_clubes.id as id_club,
					com_clubes.club as name_club
					FROM ".$this->tabla." LEFT JOIN com_users ON ".$this->tabla.".entrenador = com_users.id 
					LEFT JOIN com_tipo_grupo ON ".$this->tabla.".tipo_grupo = com_tipo_grupo.id 
					LEFT JOIN com_clubes ON ".$this->tabla.".club = com_clubes.id 
					";

    				if (!empty($noGrupo)) {
                        $sql .= " WHERE ".$this->tabla.".id != :id";
                         $bind = array(
                                ':id' =>$noGrupo
                            );
                    }else{
            			$sql .= "WHERE ".$this->tabla.".id > :id ";
                            $bind = array(
                                ':id' => '0'
                            );

                    }
		
					
					if (!empty($tipo_grupo)) {
                        $sql .= " AND ".$this->tabla.".tipo_grupo in (".$tipo_grupo.")";
                        //$bind[":tipo_grupo"] = $tipo_grupo;
                    }

        			if (!empty($club)) {
                        $sql .= " AND ".$this->tabla.".club = :club";
                        $bind[":club"] = $club;
                    }


				
					$sql .= " ORDER BY grupo"; 
		
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
					return $row_p;
				}
	}

	public function getAllNotIN ($tipo_grupo,$club,$noGrupo)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT com_grupos.id as id_grupo,
					com_grupos.grupo as nombre_grupo
					
					FROM com_grupos";

    				$sql .= " WHERE ".$this->tabla.".id != :id";
                         $bind = array(
                                ':id' =>$noGrupo
                            );
                   
		
					
					if (!empty($tipo_grupo)) {
                        $sql .= " AND ".$this->tabla.".tipo_grupo in (".$tipo_grupo.")";
                        //$bind[":tipo_grupo"] = $tipo_grupo;
                    }

        			if (!empty($club)) {
                        $sql .= " AND ".$this->tabla.".club = :club";
                        $bind[":club"] = $club;
                    }


				
					$sql .= " ORDER BY nombre_grupo"; 
		
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					return $row_p;
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
        
        static function getOnebyName ($grupo)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_grupos WHERE grupo = :grupo LIMIT 1";
                                $bind = array(
                                    ':grupo' => $grupo
                                );
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					return $row_p;
				}
	}
        
        public function getHorarios ()
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_horarios WHERE grupo = :id ORDER BY dia, desde";
                                $bind = array(
                                    ':id' => $this->row[0]['id']
                                );
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					$this->horario = $row_p;
				}
	}
        
        public function agregarHorario ($grupo,$dia,$desde,$hasta,$actividad)
    {
	   if (empty($grupo) or empty($dia)) {
		   header("Location: grupos_horario.php?err=1&id=".$grupo);
	   } else {
               
            //$orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            'dia' => $dia,
                            'desde' => $desde,
                            'hasta' => $hasta,
                            'actividad' => $actividad,
                            'grupo' => $grupo
                            
                        );
            $db->insert('com_horarios', $data);
			//$this->id = $db->lastInsertId();
		
		//header("Location: grupos.php?add=ok");
		
	   }
           
           
		
    }
    
    public function getHorariosUser($id)	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM com_horarios INNER JOIN com_users ON com_horarios.grupo = com_users.grupo"
                                        . " WHERE com_users.id = :id ORDER BY .com_horarios.dia, com_horarios.desde";
                                $bind = array(
                                    ':id' => $id
                                );
                                
                               /* echo $sql;
                                print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					$this->horario = $row_p;
				}
	}


   
		
    

	public function agregarGrupoUsers($idUsuario,$idGrupo,$idUser)
    {

	 if (empty($idGrupo) or empty($idUsuario)) {
		   header("Location: grupos_asociar_add.php?err=1&id=".$idGrupo);
	   } else {
               
            $elrow = $this->validarUserGrupo($idUsuario, $idGrupo);
        	if (empty($elrow)) {
			$db = Db::getInstance();
			$data = array(
			    		'user' => $idUsuario,
                            'grupo' => $idGrupo,
           
                            'fecha_cre' => date('Y-m-d h:i:s'),
                            'user_cre' => $idUser,
                        );
            		$db->insert('com_grupos_users', $data);
			
			}
		
	   }

	 
    }

      public function validarUserGrupo($idUsuario,$idGrupo)
    {
        
            $db = Db::getInstance();
            $sql = "SELECT * FROM com_grupos_users  WHERE user = :user and  grupo = :grupo and eliminado='0'";
            $bind = array(
                ':user' => $idUsuario,
                ':grupo' => $idGrupo,
            );
            
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

	public function elimnarGrupoUsers ($idUsuario,$idGrupo,$idUser)
    {

	 if (empty($idUsuario)) {
		   header("Location: grupos_asociar_add.php?err=1&id=".$idGrupo);
	   } else {
               
            //$orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            
                            'eliminado' => '1',
			    'fecha_mod' => date('Y-m-d h:i:s'),
                            'user_mod' => $idUser,
                            
                        );

		$db->update('com_grupos_users', $data, 'user = :user and grupo= :grupo', array(':user' => $idUsuario,':grupo' => $idGrupo));
         
		
		
	   }

	 
    }
	
	
	public function getAllUsersGrupo ($paginado=1, $tipo='todos', $tipoLimit='', $opciones = array(),$club,$grupo,$nogrupo,$page,$orden,$limit)
    {
              
				$db = Db::getInstance();

				$sql = "SELECT com_users.*, com_clubes.club  
				FROM com_users INNER JOIN com_clubes ON com_users.club = com_clubes.id 
				where com_users.estado='0'";

				if ($tipoLimit  == 'apoderado') {                                    
					$sql .= "INNER JOIN com_apoderados ON ".$this->tabla.".id = com_apoderados.nadador ";
					$sql .= "AND com_apoderados.apoderado = :apoderado";
					$bind = array(
					    ':apoderado' => $this->usuario['id']
					);

				} else {
					if (!empty($grupo)) {
					$sql .= " AND com_users.id  in (select distinct user from com_grupos_users where grupo= :grupo and eliminado='0')";
					   $bind[":grupo"] = $grupo;
					}

					if (!empty($nogrupo) && (empty($opciones['grupos']))) {
						$sql .= "AND com_users.id not in (select distinct user from com_grupos_users where grupo= :grupo and eliminado='0')";
						$bind[":grupo"] = $nogrupo;
					}else if (!empty($nogrupo) && (!empty($opciones['grupos']))) {
						$sql .= "AND com_users.id in (select distinct user from com_grupos_users where grupo= :grupo and eliminado='0' and user not in(select distinct user from com_grupos_users where grupo= '$nogrupo' and eliminado='0' ))  ";
						$bind[":grupo"] = $opciones['grupos'];


					}

					

				}

				

				if (!empty($opciones['nombre'])) {
				$nombre = $opciones['nombre'];
				$nombre = str_replace(", ", ",", $nombre);
				$nombre = str_replace(",", " ", $nombre);
				$nombres = explode(" ", $nombre);
				$concatenador = "AND ";
				$conti = 1;

				foreach($nombres as $word){
			
				        $sql.= " ".$concatenador;
			 
				    $sql .= " (nombre LIKE :nombre_".$conti." OR apellido LIKE :nombre_".$conti.")";
				    $bind[":nombre_".$conti] = "%$word%";
				    $conti ++;
				}

				}

				if (!empty($opciones['genero'])) {
				$sql .= " AND com_users.genero = :genero";
				$bind[":genero"] = $opciones['genero'];
				}

				if (!empty($opciones['ano'])) {
				$sql .= " AND YEAR(com_users.fecnac) = :ano";
				$bind[":ano"] = $opciones['ano'];
				}

				

				if (!empty($club)) {
				 $sql .= " AND com_users.club = :club";
				$bind[":club"] = $club;
				}


				

				if ($tipo != 'todos' and !empty($tipo)) {
				$tipos = explode("-", $tipo);
				$countipo = count($tipos);
				$contador = 1;
				$sql .= " AND (";
				foreach ($tipos as $tipUser) {
				    $sql .= "com_users.". $tipUser." = :".$tipUser;
				    if ($contador < $countipo) {
				        $sql .= " or ";
				    }
				    $bind[":".$tipUser] = '1';
				    $contador ++;
				}
				$sql .= ")";

				}

				$arrayresult=array();

				if (empty($orden)) {
				        $orden = "com_users.apellido,com_users.nombre";
				} else {
				        $orden = $orden;
				}


				if ($this->tiporden == 'desc') {
				        $tiporden = " desc";
				} else {
				        $tiporden = "";
				}

				

				if ($paginado == 1) {


				    $total_results = $db->run($sql, $bind);
				    $arrayresult['total_results']=$total_results;

				   
				$total_pages = ceil($total_results/$limit);
				 $arrayresult['total_pages']=$total_pages;
				

				$arrayresult['page']=$page;
				$starting_limit = ($page-1)*$limit;



				$sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $limit; 
				} else {
				$sql .= " ORDER BY ".$orden.$tiporden;  
				}




                
                $cont = $db->run($sql, $bind);
                if ($cont == 0) {
                	 $arrayresult['resultado']="";
                  
                } else {
                    
                    $db1 = Db::getInstance();
                    $row_p = $db1->fetchAll($sql, $bind);
                     $conty = 0;
                   foreach($row_p as $row_p1) {
                      $conty++;             
                    }
                    $arrayresult['resultado']= $row_p;
                   

                }
                return $arrayresult;
    }
	
	
	
	
		
}
