<?php
class Competencia
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
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "com_competencias";
	
    }
	

		
	public function agregar ($datosN = array())
    {

	   if (empty($datosN['nombre'])) {
		   header("Location: competencias_add.php?err=1");
	   } else {
               if (empty($datosN['max_pruebas'])) {
                   $datosN['max_pruebas'] = 0;
               }
               if (empty($datosN['max_jornadas'])) {
                   $datosN['max_jornadas'] = 0;
               }
               
			$db = Db::getInstance();
			$data = array(
                            'nombre' => $datosN['nombre'],
                            'abre' => $datosN['abre'],
                            'lugar' => $datosN['lugar'],
                            'piscina' => $datosN['piscina'],
                            'federacion' => $datosN['federacion'],
                            'desde' => $datosN['desde'],
                            'hasta' => $datosN['hasta'],
                            'local' => $datosN['local'],
                            'bus' => $datosN['bus'],
                            'alojamiento' => $datosN['alojamiento'],
                            'notas' => $datosN['notas'],
                            'max_pruebas' => $datosN['max_pruebas'],
                            'max_jornadas' => $datosN['max_jornadas']
                        );
                        
                        
                $db->insert($this->tabla, $data);
		$this->id = $db->lastInsertId();
                
                
	   }
		
    }
    
    public function agregarCategoria($categoria) {
        $cat = New Categoria();
        $cat->getOne($categoria);
        
        $desde = date('Y') - ($cat->row[0]['desde']);
        $hasta = date('Y') - ($cat->row[0]['hasta']);
        
        $db = Null;
        $db = Db::getInstance();
			$data = array(
                            'competencia' => $this->id,
                            'categoria' => $categoria,
                            'desde' => $desde,
                            'hasta' => $hasta
                        );
                        
                        
                $db->insert('com_competencias_categorias', $data);
		//$this->id = $db->lastInsertId();
        
        
    }
    
    public function agregarJornada($fecha, $hora, $orden) {
        
        
        $db = Null;
        $db = Db::getInstance();
			$data = array(
                            'competencia' => $this->id,
                            'orden' => $orden,
                            'fecha' => $fecha,
                            'hora' => $hora
                        );
                        
                        
                $db->insert('com_competencias_jornadas', $data);
		//$this->id = $db->lastInsertId();
        
        
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

    public function eliminar($id) {
        
        $this->elimAlojamiento($id);
        $this->elimBus($id);
        $this->elimAsistentes($id);
        $this->elimCompCate($id);
        $this->elimConvocados($id);
        $this->elimDocu($id);
        $this->elimJornadas($id);
        $this->elimPruebas($id);//aqui hay que eliminar las pruebas inscritas por los nadadores tambien y las pruebas categorias
        
        $db = Db::getInstance();
	$db->delete('com_competencias', "id=:id" , array(':id' => $id)); 
                        
        
    }
  
	

	
	public function getAll ($paginado=1)
	{
		      
				$db = Db::getInstance();
		     
				$sql = "SELECT ".$this->tabla.".*, com_federaciones.federacion AS nombre_fed FROM ".$this->tabla." LEFT JOIN com_federaciones ON ".$this->tabla.".federacion = com_federaciones.id  WHERE ".$this->tabla.".id > :id";
    				$bind = array(
        			':id' => '0'
    				);
                                /*
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
                                    
                                }*/
				
                                if (empty($this->orden)) {
                                            $orden = $this->tabla.".desde DESC";
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
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
                                    

                                    $sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 
                                } else {
                                   $sql .= " ORDER BY ".$orden.$tiporden;  
                                }
				
				/*echo $sql;
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
        
        public function getAllconZip ($paginado=1)
	{
		      
				$db = Db::getInstance();
		     
				$sql = "SELECT ".$this->tabla.".* FROM ".$this->tabla." INNER JOIN Evento ON ".$this->tabla.".id = Evento.competencia  WHERE ".$this->tabla.".id > :id";
    				$bind = array(
        			':id' => '0'
    				);
                                /*
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
                                    
                                }*/
				
                                if (empty($this->orden)) {
                                            $orden = $this->tabla.".desde DESC";
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
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
                                    

                                    $sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 
                                } else {
                                   $sql .= " ORDER BY ".$orden.$tiporden;  
                                }
				
				/*echo $sql;
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
        
      
	
	
	public function getOne ($id, $zip = 0)
	{
				$db = Db::getInstance();
				//$sql = "SELECT * FROM ".$this->tabla." WHERE id = :id LIMIT 1";
                                if ($zip == 1) {
                                    $sql = "SELECT ".$this->tabla.".*, com_federaciones.federacion AS nombre_fed, Evento.FechaDesde, Evento.FechaHasta, Evento.FechaCorteEdad FROM ".$this->tabla." LEFT JOIN com_federaciones ON ".$this->tabla.".federacion = com_federaciones.id ";
                                
                                } else {
                                    $sql = "SELECT ".$this->tabla.".*, com_federaciones.federacion AS nombre_fed FROM ".$this->tabla." LEFT JOIN com_federaciones ON ".$this->tabla.".federacion = com_federaciones.id ";
                                
                                }
                                $bind = array(
                                    ':id' => $id
                                );
                                
                                if ($zip == 1) {
                                    $sql .= " LEFT JOIN Evento ON ".$this->tabla.".id = Evento.competencia ";
                                }
                                
                                $sql .= " WHERE ".$this->tabla.".id = :id LIMIT 1";
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					$this->row = $row_p;
                                        
                                        
                                        $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_competencias_categorias.*, com_categorias.categoria AS nombre_cat FROM com_competencias_categorias LEFT JOIN com_categorias ON com_competencias_categorias.categoria = com_categorias.id WHERE com_competencias_categorias.competencia = :competencia";
                                        $bind2 = array(
                                            ':competencia' => $row_p[0]['id']
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['categorias'] = $row_p1;
                                        }
                                        
                                        // las pruebas de la competencia
                                        $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_competencias_pruebas.*, com_pruebas.nombre AS pru_nombre, com_pruebas.id AS pru_id, com_competencias_jornadas.orden AS jor_nombre, com_pruebas.relevo FROM com_competencias_pruebas "
                                                    . "INNER JOIN com_pruebas ON com_competencias_pruebas.prueba = com_pruebas.id "
                                                . "LEFT JOIN com_competencias_jornadas ON com_competencias_pruebas.jornada = com_competencias_jornadas.id "
                                                . "WHERE com_competencias_pruebas.competencia = :competencia ORDER BY com_competencias_jornadas.orden, com_competencias_pruebas.no_prueba";
                                        $bind2 = array(
                                            ':competencia' => $row_p[0]['id']
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        //echo "encontro".$cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                $this->row[0]['pruebas'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['pruebas'] = $row_p1;
                                        }
                                       
                                        //terminan las prueba de la competencia
				}
	}
        
        public function getMarcas ($competencia) {
             $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_marcas_tiemp.id, com_marcas_tiemp.*, com_pruebas.nombre AS pru_nombre, com_pruebas.id AS pru_id, com_pruebas.relevo FROM com_marcas_tiemp "
                                                    . "INNER JOIN com_pruebas ON com_marcas_tiemp.prueba = com_pruebas.id "
                                                . "WHERE com_marcas_tiemp.competencia = :competencia";
                                        $bind2 = array(
                                            ':competencia' => $competencia
                                        );
                                       /* if ($genero > 0) {
                                            $sql2 .=  " AND genero = :genero";
                                            $bind2['genero'] = $genero;                                            
                                        }*/
                                        
                                        $sql2 .=  " ORDER BY com_marcas_tiemp.id";

                                        $cont = $db2->run($sql2, $bind2);
                                        //echo "encontro".$cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                return "";
                                               // $this->row[0]['pruebas'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                return $row_p1;
                                                //$this->row[0]['pruebas'] = $row_p1;
                                        }
        } 
        
        
        public function getMarcasOne ($id) {
             $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_marcas_tiemp.id, com_marcas_tiemp.*, com_pruebas.nombre AS pru_nombre, com_pruebas.id AS pru_id, com_pruebas.relevo FROM com_marcas_tiemp "
                                                    . "INNER JOIN com_pruebas ON com_marcas_tiemp.prueba = com_pruebas.id "
                                                . "WHERE com_marcas_tiemp.id = :id ORDER BY com_marcas_tiemp.id";
                                        $bind2 = array(
                                            ':competencia' => $competencia
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        //echo "encontro".$cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                return "";
                                               // $this->row[0]['pruebas'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                return $row_p1;
                                                //$this->row[0]['pruebas'] = $row_p1;
                                        }
        } 
        
        
        
        public function getVarios ($ids, $piscina="")
	{
          
				$db = Db::getInstance();
			
                                $sql = "SELECT ".$this->tabla.".*, com_federaciones.federacion AS nombre_fed FROM ".$this->tabla." LEFT JOIN com_federaciones ON ".$this->tabla.".federacion = com_federaciones.id";
                                $primer = 0;
                                $hay = 0;
                         
                                foreach ($ids as $id) {
                                     $hay = 1;
                                            
                                    if ($primer == 0) {
                                        $sql .= "  WHERE (";
                                        
                                    } else {
                                        $sql .= "  OR ";
                                    }
                                    $sql .= $this->tabla.".id = :id".$primer;
                                    
                                    $bind[':id'.$primer] = $id;
                                            $primer++;

                                   } 
                                   
                                   if ($hay == 1) {
                                       $sql .= ") ";
                                   }
                                   
                                   if (!empty($piscina)) {
                                       if ($hay == 1) {
                                            $sql .= "  AND ";

                                        } else {
                                            $sql .= "  WHERE ";
                                        }
                                        
                                        $sql .= $this->tabla.".piscina = :piscina";
                                    
                                    $bind[':piscina'] = $piscina;
                                   }
                                   
                                   $sql .= " ORDER BY com_competencias.desde";
                                
                              
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					
				} else {
					
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					$this->row = $row_p;
                                        
				}
          
           
	}
        
        public function getCalendario ()
	{
		      
				$db = Db::getInstance();
		     
				$sql = "SELECT ".$this->tabla.".* FROM ".$this->tabla."  WHERE ".$this->tabla.".desde >= :fecha";
    				$sql .= " UNION ALL SELECT ".$this->tabla.".* FROM ".$this->tabla." WHERE ".$this->tabla.".desde < :fecha LIMIT 10" ;
                                $bind = array(
        			':fecha' => date('Y-m-d')
    				);
                             
				
				
				/*echo $sql;
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
        
        public function getJornadas() {
            
                                        $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT * FROM com_competencias_jornadas WHERE competencia = :competencia ORDER BY orden";
                                        $bind2 = array(
                                            ':competencia' => $this->row[0]['id']
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['jornadas'] = $row_p1;
                                        }
            
        }
 
        
   
        
        public function asignarCategoria($user) {
                        $sql = "SELECT EXTRACT(YEAR FROM fecnac) AS anonac FROM ".$this->tabla." WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $user
    			);
                        $db1 = Null;
                        $db1 = Db::getInstance();
			$rowff1 = $db1->fetchRow($sql, $bind);
                        
                        $anonac = $rowff1['anonac'];
                        $edad = date('Y')-$anonac;
                        $categ = New Categoria();
                        $categ->asignarCategoria($user,$edad);
            
            
        }
        
        public function agregarPrueba($competencia, $no_prueba, $prueba, $categoria, $genero, $jornada, $marca_min, $maxn) {
                   // echo "marca_min: ".$no_prueba." ".$marca_min." genero: ".$genero."<br>";
                        if (empty($marca_min)) {
                            $con_marca = 0;
                            $tiempo = 0;
                        } else {
                            $con_marca = 1;
                            $tiempo = Funciones::convertiraMS($marca_min);
                        }
                        if (empty($maxn)) {
                            $maxn = 0;
                        }
                        $db = Db::getInstance();
			$data = array(
                            'competencia' => $competencia,
                            'no_prueba' => $no_prueba,
                            'prueba' => $prueba,
                            'genero' => $genero,
                            'jornada' => $jornada,
                            'con_marca' => $con_marca,
                            'marca_min' => $tiempo,
                            'maxn' => $maxn
                        );
                        
                        
                $db->insert('com_competencias_pruebas', $data);
		$prueba_id = $db->lastInsertId();
                foreach ($categoria as $Cate) {
                    $this->agregarCatPrueba ($prueba_id, $Cate);
                }
        }
        
        
        public function agregarMarcaPrueba($competencia, $prueba, $genero, $marcaa, $marcab, $marcac, $marcad) {
                    //echo "marca_min: ".$no_prueba." ".$marca_min." genero: ".$genero."<br>";
                        if (empty($marcaa)) {
                            $marcaa = 0;
                        } else {
                            $marcaa = Funciones::convertiraMS($marcaa);
                        }
                        
                        if (empty($marcab)) {
                            $marcab = 0;
                        } else {
                            $marcab = Funciones::convertiraMS($marcab);
                        }
                        
                        if (empty($marcac)) {
                            $marcac = 0;
                        } else {
                            $marcac = Funciones::convertiraMS($marcac);
                        }
                        
                        if (empty($marcad)) {
                            $marcad = 0;
                        } else {
                            $marcad = Funciones::convertiraMS($marcad);
                        }
                      
                        $db = Db::getInstance();
			$data = array(
                            'competencia' => $competencia,
                            'genero' => $genero,
                            'prueba' => $prueba,
                            'marcaA' => $marcaa,
                            'marcaB' => $marcab,
                            'marcaC' => $marcac,
                            'marcaD' => $marcad
                        );
                        
                        
               // $db->insert('com_marcas_tiemp', $data);
		//$prueba_id = $db->lastInsertId();
                
                $db->save('com_marcas_tiemp', $data, "competencia=:competencia AND prueba = :prueba AND genero = :genero" , array('competencia' => $competencia, 'prueba' => $prueba, 'genero' => $genero));
                 
                
                /*foreach ($categoria as $Cate) {
                    $this->agregarCatPrueba ($prueba_id, $Cate);
                }*/
        }
        
        private function agregarCatPrueba ($prueba, $categoria) {
                        
                        $db = Db::getInstance();
			$data = array(
                            'prueba' => $prueba,
                            'categoria' => $categoria,
                            'desde' => '0',
                            'hasta' => '0'
                            
                        );
                        
                        
                $db->insert('com_competencias_pruebas_cat', $data);
            
        }
        
        public function getTimeConfig($id) {
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT * FROM com_competencias_timeconfig WHERE competencia = :competencia LIMIT 1";
                                        $bind2 = array(
                                            ':competencia' => $id
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                $row_p1 = array();
                                                $row_p1[0] = array(
                                                    'tipo_piscina' => '1',
                                                    'criterio' => 'mejor'
                                                );
                                                return $row_p1;
                                                //echo "NO encontró";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                return $row_p1;
                                                //$this->row[0]['jornadas'] = $row_p1;
                                        }
        
        }
        
        public function guardarTimeConfig($competencia, $tipo_piscina,$criterio){
            if (empty($tipo_pisicina)) {
                $tipo_pisicina = 0;
            }
            if (empty($criterio)) {
                $tipo_pisicina = 'mejor';
            }
             $db = Db::getInstance();
			$data = array(
                            'competencia' => $competencia,
                            'tipo_piscina' => $tipo_piscina,
                            'criterio' => $criterio
                        );
                        
                $db->save('com_competencias_timeconfig', $data, "competencia=:competencia" , array('competencia' => $competencia));
                        
            
        }
        public function getEstadoInscripcion($nadador,$competencia) {
             $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT * FROM com_competencias_asistentes WHERE competencia = :competencia AND nadador = :nadador LIMIT 1";
                                        $bind2 = array(
                                            ':competencia' => $competencia,
                                            ':nadador' => $nadador
                                        );
                                        /*echo $sql2;
                                        print_r($bind2);*/

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                               // echo "NO encontró";
                                                return 0;
                                                
                                        } else {
                                               // echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                return $row_p1[0]['cerrado'];
                                                //$this->row[0]['jornadas'] = $row_p1;
                                        }
            
        }
        
        public function iniciarConvocatoria($fec_convocatoria) {
            if (empty($fec_convocatoria)) {
		   //header("Location: usuarios.php");
	   } else {
		
			$db = Db::getInstance();
			$data = array(
                            'convocatoria' => '1',
                            'convocatoria_hasta' => $fec_convocatoria. " 23:59:00"
                        );
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->row[0]['id']));
		   
		
	   }
            
        }
        

        
        public function getConvocados() {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano, com_competencias_convocados.categoria AS cate, com_competencias_convocados.respondido FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) OR (YEAR(com_users.fecnac) > com_competencias_categorias.desde or YEAR(com_users.fecnac) < com_competencias_categorias.hasta) "
                    . "LEFT JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "INNER JOIN com_competencias_convocados ON com_competencias_convocados.nadador = com_users.id "
                    . "WHERE com_competencias.id = :id AND com_users.nadador = :nadador AND com_competencias_convocados.competencia = :id AND com_users.externo >= 0 "
                    . "GROUP BY com_users.id, com_competencias_convocados.categoria, com_competencias_convocados.respondido";
    				$bind2 = array(
        			':id' => $this->row[0]['id'],
                                'nadador'=> '1'
    				);
                                
                                /*echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_convocados'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['convocados'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['convocados'] = $row_p1;
                                        }
            
        }
        
        static function countConvocados($id) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano, com_competencias_convocados.categoria AS cate, com_competencias_convocados.respondido FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) OR (YEAR(com_users.fecnac) > com_competencias_categorias.desde or YEAR(com_users.fecnac) < com_competencias_categorias.hasta) "
                    . "LEFT JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "INNER JOIN com_competencias_convocados ON com_competencias_convocados.nadador = com_users.id "
                    . "WHERE com_competencias.id = :id AND com_users.nadador = :nadador AND com_competencias_convocados.competencia = :id AND com_users.externo = 0 "
                    . "GROUP BY com_users.id, com_competencias_convocados.categoria, com_competencias_convocados.respondido";
    				$bind2 = array(
        			':id' => $id,
                                'nadador'=> '1'
    				);
                                
                                /*echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                return $cont;
            
        }
        
        public function getAsistentes() {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, com_users.genero, com_users.rut, YEAR(com_users.fecnac) AS ano, com_users.fecnac, com_competencias_asistentes.categoria AS cate, com_competencias_asistentes.inscrito AS inscrito, com_competencias_asistentes.cerrado AS cerrado FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) OR (YEAR(com_users.fecnac) > com_competencias_categorias.desde or YEAR(com_users.fecnac) < com_competencias_categorias.hasta) "
                    . "LEFT JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "INNER JOIN com_competencias_asistentes ON com_competencias_asistentes.nadador = com_users.id "
                    . "WHERE com_competencias.id = :id AND com_users.nadador = :nadador AND com_competencias_asistentes.competencia = :id AND com_users.externo >= 0 "
                    . "GROUP BY com_users.id, com_competencias_asistentes.categoria, com_competencias_asistentes.inscrito, com_competencias_asistentes.cerrado ORDER BY com_users.genero, com_users.fecnac DESC";
            
    				$bind2 = array(
        			':id' => $this->row[0]['id'],
                                'nadador'=> '1'
    				);
                                
                                /*echo $sql2."<br>";
                                
                                print_r($bind2);
                                echo "<br>";*/
                                
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_asistentes'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['asistentes'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['asistentes'] = $row_p1;
                                        }
            
        }
        static function countAsistentes($id) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, com_users.rut, YEAR(com_users.fecnac) AS ano, com_users.fecnac, com_competencias_asistentes.categoria AS cate, com_competencias_asistentes.inscrito AS inscrito FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) OR (YEAR(com_users.fecnac) > com_competencias_categorias.desde or YEAR(com_users.fecnac) < com_competencias_categorias.hasta) "
                    . "LEFT JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "INNER JOIN com_competencias_asistentes ON com_competencias_asistentes.nadador = com_users.id "
                    . "WHERE com_competencias.id = :id AND com_users.nadador = :nadador AND com_competencias_asistentes.competencia = :id AND com_users.externo = 0 AND com_users.externo = 0 "
                    . "GROUP BY com_users.id, com_competencias_asistentes.categoria, com_competencias_asistentes.inscrito";
            
    				$bind2 = array(
        			':id' => $id,
                                'nadador'=> '1'
    				);
                                
                                /*echo $sql2."<br>";
                                
                                print_r($bind2);
                                echo "<br>";*/
                                
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                return $cont;
            
        }
        
        
        public function getNadadoresMarcas($competencia) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, com_users.rut, YEAR(com_users.fecnac) AS ano, com_users.fecnac, com_pruebas.id AS idPru, com_pruebas.nombre AS nombrePru, com_resultados.tiempo, com_resultados.fecha AS fecresul, compR.nombre AS nombrecomp, com_marcas_tiemp.marcaA, com_marcas_tiemp.marcaB, com_marcas_tiemp.marcaC, com_marcas_tiemp.marcaD FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) "
                    . "INNER JOIN com_competencias AS comp ON com_competencias_categorias.competencia = comp.id "
                    . "INNER JOIN com_marcas_tiemp ON com_marcas_tiemp.competencia = comp.id "
                    . "LEFT JOIN com_pruebas ON com_marcas_tiemp.prueba = com_pruebas.id "
                    . "INNER JOIN com_resultados ON com_users.id = com_resultados.nadador AND ((com_marcas_tiemp.marcaA >= com_resultados.tiempo AND com_marcas_tiemp.marcaA > 0 AND com_marcas_tiemp.prueba = com_resultados.prueba AND com_users.genero = com_marcas_tiemp.genero) OR (com_marcas_tiemp.marcaB >= com_resultados.tiempo AND com_marcas_tiemp.marcaB > 0 AND com_marcas_tiemp.prueba = com_resultados.prueba AND com_users.genero = com_marcas_tiemp.genero) OR (com_marcas_tiemp.marcaC >= com_resultados.tiempo AND com_marcas_tiemp.marcaC > 0 AND com_marcas_tiemp.prueba = com_resultados.prueba AND com_users.genero = com_marcas_tiemp.genero))  "
                    . "INNER JOIN com_competencias AS compR ON com_resultados.competencia = compR.id "
                    . "WHERE comp.id = :id AND com_users.nadador = :nadador AND com_marcas_tiemp.competencia = :id AND com_competencias_categorias.competencia = :id "
                    . "GROUP BY com_users.id, idPru, com_resultados.tiempo ORDER BY com_users.apellido, com_resultados.tiempo";
            
    				$bind2 = array(
        			':id' => $competencia,
                                'nadador'=> '1'
    				);
                                
                                /*echo $sql2."<br>";
                                
                                print_r($bind2);
                                echo "<br>";*/
                                
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_marcas'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                return "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
            
        }
        
        public function getNadadoresPosiblesClasi($competencia) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, com_users.rut, YEAR(com_users.fecnac) AS ano, com_users.fecnac, com_users.genero FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) "
                    . "INNER JOIN com_competencias AS comp ON com_competencias_categorias.competencia = comp.id "
                    . "WHERE comp.id = :id AND com_users.nadador = :nadador AND com_competencias_categorias.competencia = :id AND com_users.estado=0 "
                    . "GROUP BY com_users.id ORDER BY com_users.genero, com_users.apellido";
            
    				$bind2 = array(
        			':id' => $competencia,
                                'nadador'=> '1'
    				);
                                
                                /*echo $sql2."<br>";
                                
                                print_r($bind2);
                                echo "<br>";*/
                                
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_marcas'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                return "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
            
        }
        
        public function getNadadoresMarcasC($competencia) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, com_users.rut, YEAR(com_users.fecnac) AS ano, com_users.fecnac, com_pruebas.id AS idPru, com_pruebas.nombre AS nombrePru, com_resultados.tiempo, com_resultados.fecha AS fecresul, compR.nombre AS nombrecomp, com_marcas_tiemp.marcaA, com_marcas_tiemp.marcaB, com_marcas_tiemp.marcaC, com_marcas_tiemp.marcaD FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) "
                    . "INNER JOIN com_competencias AS comp ON com_competencias_categorias.competencia = comp.id "
                    . "INNER JOIN com_marcas_tiemp ON com_marcas_tiemp.competencia = comp.id "
                    . "LEFT JOIN com_pruebas ON com_marcas_tiemp.prueba = com_pruebas.id "
                    . "INNER JOIN com_resultados ON com_users.id = com_resultados.nadador AND ((com_marcas_tiemp.marcaC < com_resultados.tiempo AND com_marcas_tiemp.marcaC > 0 AND com_marcas_tiemp.prueba = com_resultados.prueba AND com_users.genero = com_marcas_tiemp.genero) AND ((((com_marcas_tiemp.marcaC*com_pruebas.factor2)/100)+com_marcas_tiemp.marcaC) >= com_resultados.tiempo))  "
                    . "INNER JOIN com_competencias AS compR ON com_resultados.competencia = compR.id "
                    . "WHERE comp.id = :id AND com_users.nadador = :nadador AND com_marcas_tiemp.competencia = :id AND com_competencias_categorias.competencia = :id "
                    . "GROUP BY com_users.id, com_pruebas.id ORDER BY com_users.apellido";
            
    				$bind2 = array(
        			':id' => $competencia,
                                'nadador'=> '1'
    				);
                                
                                /*echo $sql2."<br>";
                                
                                print_r($bind2);
                                echo "<br>";*/
                                
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_marcasC'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                return "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
            
        }
        
        static function getNadadoresMarcaCerca($competencia, $prueba, $ult_marca, $genero, $fecha) {
            
           $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, com_users.rut, YEAR(com_users.fecnac) AS ano, com_users.fecnac, com_pruebas.id AS idPru, com_pruebas.nombre AS nombrePru, com_resultados.tiempo, com_resultados.fecha AS fecresul, compR.nombre AS nombrecomp, com_marcas_tiemp.marcaA, com_marcas_tiemp.marcaB, com_marcas_tiemp.marcaC, com_marcas_tiemp.marcaD FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) "
                    . "INNER JOIN com_competencias AS comp ON com_competencias_categorias.competencia = comp.id "
                    . "INNER JOIN com_marcas_tiemp ON com_marcas_tiemp.competencia = comp.id "
                    . "LEFT JOIN com_pruebas ON com_marcas_tiemp.prueba = com_pruebas.id "
                   . "INNER JOIN com_resultados ON com_users.id = com_resultados.nadador AND ((com_marcas_tiemp.marcaC < com_resultados.tiempo AND com_marcas_tiemp.marcaC > 0 AND com_marcas_tiemp.prueba = com_resultados.prueba AND com_users.genero = com_marcas_tiemp.genero) AND ((((com_marcas_tiemp.marcaC*100)/100)+com_marcas_tiemp.marcaC) >= com_resultados.tiempo))  "
                   // . "INNER JOIN com_resultados ON com_users.id = com_resultados.nadador AND ((com_marcas_tiemp.marcaC < com_resultados.tiempo AND com_marcas_tiemp.marcaC > 0 AND com_marcas_tiemp.prueba = com_resultados.prueba AND com_users.genero = com_marcas_tiemp.genero))  "
                    . "INNER JOIN com_competencias AS compR ON com_resultados.competencia = compR.id "
                    . "WHERE com_resultados.prueba = :prueba AND comp.id = :id AND com_users.nadador = :nadador AND com_marcas_tiemp.competencia = :id AND com_competencias_categorias.competencia = :id AND com_users.genero = :genero AND com_resultados.fecha >= :fecha "
                    . "GROUP BY com_users.id, idPru, com_resultados.tiempo ORDER BY com_resultados.tiempo LIMIT 15";  
           
           
           $bind2 = array(
        			':id' => $competencia,
                                'nadador'=> '1',
                                ':prueba' => $prueba,
                                ':genero' => $genero,
                                ':fecha' => $fecha
    				);
           
           $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                return "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
        }
        
        public function getBus($competencia) {
            // nadadores que van en el bus
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_users.* FROM com_users "
                                                . "INNER JOIN com_competencias_bus ON com_competencias_bus.nadador = com_users.id "
                                                . "WHERE com_competencias_bus.competencia = :competencia AND com_users.externo = 0 ORDER BY com_users.apellido, com_users.nombre";
                                        $bind2 = array(
                                            ':competencia' => $competencia
                                        );
                                        //echo $sql2;

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                $this->bus = $row_p;
                                        } else {
                                               // echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->bus = $row_p1;
                                        }
        }
        
        public function getAlojamiento($competencia) {
            // nadadores que van en el bus
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_users.* FROM com_users "
                                                . "INNER JOIN com_competencias_alojamiento ON com_competencias_alojamiento.nadador = com_users.id "
                                                . "WHERE com_competencias_alojamiento.competencia = :competencia AND com_users.externo = 0 ORDER BY com_users.apellido, com_users.nombre";
                                        $bind2 = array(
                                            ':competencia' => $competencia
                                        );
                                        //echo $sql2;

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                $this->alojamiento = $row_p;
                                        } else {
                                               // echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->alojamiento = $row_p1;
                                        }
        }
        
        public function getAsistentesRes($externos=0,$ano_desde=0,$ano_hasta=0,$grupo=0,$paginado=0,$pagi=1) {
            // nadadores que ya fueron convocados
            $compe = count($this->row);
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, com_users.rut, com_users.genero, YEAR(com_users.fecnac) AS ano, com_users.fecnac, com_users.externo FROM com_users "
                    . "LEFT JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) OR (YEAR(com_users.fecnac) > com_competencias_categorias.desde or YEAR(com_users.fecnac) < com_competencias_categorias.hasta) "
                    . "LEFT JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "INNER JOIN com_resultados ON com_resultados.nadador = com_users.id "
                    . "WHERE com_users.nadador = :nadador AND";
            
                    $sql2 .= " (";
                    $primer = 0;
                    //if (!empty($this->row as $id)) {
                    foreach ($this->row as $id) {
            
                                            
                                    if ($primer == 0) {
                                        
                                        
                                    } else {
                                        $sql2 .= "  OR ";
                                    }
                                    $sql2 .= " com_resultados.competencia = :id".$primer;
                                    
                                    $bind2[':id'.$primer] = $id['id'];
                                            $primer++;

                                   } 
                    //}
                    $sql2 .= " )";
                    if ($ano_desde >0) {
                        $sql2 .=  " AND YEAR(com_users.fecnac) >= :ano_desde ";
                        $bind2[':ano_desde'] = $ano_desde;
                        
                    }
                    if ($ano_hasta>0) {
                        $sql2 .=  " AND YEAR(com_users.fecnac) <= :ano_hasta ";
                        $bind2[':ano_hasta'] = $ano_hasta;
                        
                    }
                    
                    if ($grupo>0) {
                        $sql2 .=  " AND com_users.grupo = :grupo ";
                        $bind2[':grupo'] = $grupo;
                        
                    }
                            
                    $sql2 .=  " AND com_users.externo = :externos ";
                    $sql2 .= "GROUP BY com_users.id";
                    $bind2[':nadador'] = '1';
                    $bind2[':externos'] = $externos;
                    
                    /*echo "aqui antes del paginado sql".$sql2."<br><br>";
                    print_r($bind2);*/
                    $orden = "com_users.fecnac";
                    if ($paginado == 1) {
                        
                        $limit = 15;
                                        $db = Null;
                                        $db = Db::getInstance();
                                        $total_results = $db->run($sql2, $bind2);
					$total_pages = ceil($total_results/$limit);
					$this->total_AsisPages = $total_pages;
                                        $this->total_AsisResult = $total_results;

                                        if ($pagi==0 or empty($pagi)) {
                                           $starting_limit = ($pagi-1)*$limit; 
                                        } else {
                                            $starting_limit = ($pagi-1)*$limit;
                                        }
					
    				
                                    

                                    $sql2 .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $limit; 
                                } else {
                                   $sql2 .= " ORDER BY ".$orden.$tiporden;  
                                }
                                
                    
    				
                    
                    /*$bind2 = array(
        			':id' => $this->row[0]['id'],
                                'nadador'=> '1'
    				);
                                */
                    
                               /*echo $sql2;
                                print_r($bind2);
                                echo "<br><br>";*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_asistentes'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['asistentesR'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['asistentesR'] = $row_p1;
                                        }
            
        }
        
        public function getPruebasRes() {
            $db = Db::getInstance();
		     
				$sql = "SELECT com_pruebas.* FROM com_pruebas LEFT JOIN com_resultados ON com_pruebas.id = com_resultados.prueba";
                                
                                $primer = 0;
                                foreach ($this->row as $id) {
            
                                            
                                    if ($primer == 0) {
                                        $sql .= "  WHERE ";
                                        
                                    } else {
                                        $sql .= "  OR ";
                                    }
                                    $sql .= "com_resultados.competencia = :competencia".$primer;
                                    
                                    $bind[':competencia'.$primer] = $id['id'];
                                            $primer++;

                                   } 
                                   
                                $sql .= " GROUP BY com_pruebas.id ORDER BY com_pruebas.orden";
    			                        
                              
				/*echo $sql;
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
					$this->row[0]['pruebasR'] = $row_p;
				}
        }
        
        
        public function getPruebasNad($nadador,$piscina) {
            //echo "piscina".$piscina;
            $db = Db::getInstance();
		     
				$sql = "SELECT com_pruebas.* FROM com_pruebas LEFT JOIN com_resultados ON com_pruebas.id = com_resultados.prueba";
                                
                                $primer = 0;
                                $hay = 0;
                                foreach ($this->row as $id) {
                                    $hay = 1;
                                            
                                    if ($primer == 0) {
                                        $sql .= "  WHERE (";
                                        
                                    } else {
                                        $sql .= "  OR ";
                                    }
                                    $sql .= "com_resultados.competencia = :competencia".$primer;
                                    
                                    $bind[':competencia'.$primer] = $id['id'];
                                            $primer++;

                                   } 
                                   
                                   if ($hay == 1) {
                                       $sql .= ") ";
                                   }
                                   
                                   $hay1= 0;
                                   if (!empty($piscina)) {
                                       $hay1 = 1;
                                       if ($hay == 1) {
                                            $sql .= "  AND ";

                                        } else {
                                            $sql .= "  WHERE ";
                                        }
                                        
                                        $sql .= "com_resultados.piscina = :piscina";
                                    
                                    $bind[':piscina'] = $piscina;
                                   }
                                   
                                   if ($hay == 1 or $hay1 == 1) {
                                       $sql .= " AND ";
                                   }
                                   
                                $sql .= " com_resultados.nadador = :nadador";  
                                $bind[':nadador'] = $nadador;
                                $sql .= " GROUP BY com_pruebas.id ORDER BY com_pruebas.orden";
    			                        
                              
				/*echo $sql;
                                print_r($bind);*/
				
				
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					$db1 = Null;
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
					$this->row[0]['pruebasN'] = $row_p;
				}
                         
                         
        }
        
        
        public function getNadadoresElegibles($prueba,$competencia,$genero,$ano_desde,$ano_hasta) {
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                         $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano FROM com_users "
                                                . "LEFT JOIN com_competencias_asistentes ON com_competencias_asistentes.nadador = com_users.id "
                                                 . "WHERE com_competencias_asistentes.competencia = :competencia AND YEAR(com_users.fecnac) >= :ano_hasta AND com_users.genero = :genero  "
                                                . "GROUP BY com_users.id ORDER BY com_users.fecnac";
                                      
                                         $bind2 = array(
                                        
                                            ':competencia' => $competencia,
                                             ':ano_hasta' => $ano_hasta,
                                             ':genero' => $genero
                                        );
                                        /*$sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano FROM com_users "
                                                . "LEFT JOIN com_competencias_asistentes ON com_competencias_asistentes.nadador = com_users.id "
                                                 . "WHERE com_competencias_asistentes.competencia = :competencia AND YEAR(com_users.fecnac) >= :ano_hasta "
                                                . "GROUP BY com_users.id ORDER BY com_users.fecnac";
                                      
                                         $bind2 = array(
                                        
                                            ':competencia' => $competencia,
                                             ':ano_hasta' => $ano_hasta
                                        );*/
                                         
                                        /*echo $sql2;
                                        print_r($bind2);*/

                                        $cont = $db2->run($sql2, $bind2);
                                        //echo "<br>".$cont;
                                        if ($cont == 0) {
                                                $row_p1 = "";
                                                return $row_p1;
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
                                        
            
        }
        
        
        public function getPruebasporNadador($competencia,$genero,$categoria) {
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_competencias_pruebas.*, com_pruebas.nombre AS pru_nombre, com_pruebas.id AS pru_id, com_pruebas.relevo AS relevo, com_competencias_jornadas.orden AS jor_nombre FROM com_competencias_pruebas "
                                                . "LEFT JOIN com_pruebas ON com_competencias_pruebas.prueba = com_pruebas.id "
                                                . "LEFT JOIN com_competencias_jornadas ON com_competencias_pruebas.jornada = com_competencias_jornadas.id "
                                                . "INNER JOIN com_competencias_pruebas_cat ON com_competencias_pruebas.id = com_competencias_pruebas_cat.prueba "
                                                . "WHERE com_competencias_pruebas.competencia = :competencia AND com_competencias_pruebas.genero = :genero AND com_competencias_pruebas_cat.categoria = :categoria ORDER BY com_competencias_jornadas.orden, com_competencias_pruebas.no_prueba";
                                        $bind2 = array(
                                            ':competencia' => $competencia,
                                            ':genero' => $genero,
                                            ':categoria' => $categoria
                                        );
                                        /*echo $sql2;
                                        print_r($bind2);*/

                                        $cont = $db2->run($sql2, $bind2);
                                        unset($this->pruebas); 
                                        $this->pruebas = array();
                                        if ($cont == 0) {
                                                $row_p1 = "";
                                                $this->pruebas = $row_p1;
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->pruebas = $row_p1;
                                        }
                                        
            
        }
        
        public function getPruebasOne ($id) {
            
            $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_competencias_pruebas.*, com_pruebas.nombre AS pru_nombre, com_pruebas.id AS pru_id, com_pruebas.relevo AS relevo, com_competencias_jornadas.orden AS jor_nombre FROM com_competencias_pruebas "
                                                . "LEFT JOIN com_pruebas ON com_competencias_pruebas.prueba = com_pruebas.id "
                                                . "LEFT JOIN com_competencias_jornadas ON com_competencias_pruebas.jornada = com_competencias_jornadas.id "
                                                . "INNER JOIN com_competencias_pruebas_cat ON com_competencias_pruebas.id = com_competencias_pruebas_cat.prueba "
                                                . "WHERE com_competencias_pruebas.id = :id";
                                        $bind2 = array(
                                            ':id' => $id
                                        );
                                        /*echo $sql2;
                                        print_r($bind2);*/

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p1 = "";
                                                return $row_p1;
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
            
        }
        
        public function getPruebasCategorias($id) {
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_competencias_categorias.* FROM com_competencias_categorias "
                                               . "INNER JOIN com_competencias_pruebas_cat ON com_competencias_categorias.id = com_competencias_pruebas_cat.categoria "
                                                . "WHERE com_competencias_pruebas_cat.prueba = :id ORDER BY hasta DESC";
                                        $bind2 = array(
                                            ':id' => $id
                                        );
                                        /*echo $sql2;
                                        print_r($bind2);*/

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p1 = "";
                                                return $row_p1;
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
                                        
            
        }
        
        
        
        public function getPruebaFin($competencia, $prueba, $nadador) {
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_competencias_pruebas.id, com_competencias_jornadas.fecha FROM com_competencias_pruebas "
                                                . "INNER JOIN com_competencias_nad_pru ON com_competencias_nad_pru.prueba = com_competencias_pruebas.id "
                                                . "LEFT JOIN com_competencias_jornadas ON com_competencias_pruebas.jornada = com_competencias_jornadas.id "
                                               . "WHERE com_competencias_pruebas.competencia = :competencia AND com_competencias_pruebas.prueba = :prueba AND com_competencias_nad_pru.nadador = :nadador LIMIT 1";
                                        $bind2 = array(
                                            ':competencia' => $competencia,
                                            ':prueba' => $prueba,
                                            ':nadador' => $nadador
                                        );
                                        //echo $sql2;

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                return 0;
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
            
        }
        
        
        static function PruebasNadador($competencia,$nadador) {
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_competencias_pruebas.*, com_competencias_nad_pru.tiempo, com_pruebas.nombre AS pru_nombre, com_pruebas.id AS pru_id, com_pruebas.relevo AS relevo, com_competencias_jornadas.orden AS jor_nombre FROM com_competencias_pruebas "
                                                ."INNER JOIN com_competencias_nad_pru ON com_competencias_nad_pru.prueba = com_competencias_pruebas.id "
                                                . "LEFT JOIN com_pruebas ON com_competencias_pruebas.prueba = com_pruebas.id "
                                                . "LEFT JOIN com_competencias_jornadas ON com_competencias_pruebas.jornada = com_competencias_jornadas.id "
                                                . "INNER JOIN com_competencias_pruebas_cat ON com_competencias_pruebas.id = com_competencias_pruebas_cat.prueba "
                                                . "WHERE com_competencias_pruebas.competencia = :competencia AND com_competencias_nad_pru.nadador = :nadador GROUP BY com_competencias_nad_pru.id ORDER BY com_competencias_jornadas.orden, com_competencias_pruebas.no_prueba";
                                        $bind2 = array(
                                            ':competencia' => $competencia,
                                            ':nadador' => $nadador
                                        );
                                        //echo $sql2;

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                return $row_p1;
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1;
                                        }
                                        
            
        }
        
        static function getPruebasComp ($prueba, $competencia, $genero) {
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_competencias_pruebas.id FROM com_competencias_pruebas "
                                                . "WHERE com_competencias_pruebas.competencia = :competencia AND com_competencias_pruebas.prueba = :prueba AND com_competencias_pruebas.genero = :genero LIMIT 1";
                                        $bind2 = array(
                                            ':competencia' => $competencia,
                                            ':prueba' => $prueba, 
                                            ':genero' => $genero
                                        );
                                        //echo $sql2;

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                return 0;
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                return $row_p1[0]['id'];
                                        }
            
        }
        static function getCompTiempo($tiempo,$nadador,$prueba) {
            
                                        $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_resultados.competencia, com_resultados.fecha, com_competencias.nombre FROM com_resultados "
                                                . "LEFT JOIN com_competencias ON com_competencias.id = com_resultados.competencia "
                                                . "WHERE com_resultados.nadador = :nadador AND com_resultados.tiempo = :tiempo AND com_resultados.prueba = :prueba";
                                        $bind2 = array(
                                            ':nadador' => $nadador,
                                            ':tiempo' => $tiempo,
                                            ':prueba' => $prueba
                                        );
                                        //echo $sql2;

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                return "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $id_comp0 = $row_p1[0]['competencia'];
                                                $id_comp = $row_p1[0]['nombre'];
                                                if ($id_comp0 == 0) {
                                                    
                                                    
                                                    $db23 = Null;
                                                    $db23 = Db::getInstance();
                                                    $sql23 = "SELECT com_competencias.id, com_competencias.nombre FROM com_competencias WHERE com_competencias.desde <= :fecha AND com_competencias.hasta >= :fecha";
                                                    $bind23 = array(
                                                        ':fecha' => $row_p1[0]['fecha']
                                                    );
                                                    /*echo $sql23 ;
                                                    print_r($bind23);
                                                    echo "<br>";*/
                                                    

                                                    $cont3 = $db23->run($sql23, $bind23);
                                                    if ($cont3 == 0) {
                                                           //echo " NO encontró";
                                                    } else {
                                                           // echo "encontró";
                                                            $db13 = Null;
                                                            $db13 = Db::getInstance();
                                                            $row_p13 = $db1->fetchAll($sql23, $bind23);

                                                            $id_comp = $row_p13[0]['nombre'];
                                                            
                                                    }
                                                    
                                                    
                                                }
                                                return $id_comp;
                                        }
            
        }
        static function getNadadoresPrueba($prueba, $nadadorExc = 0) {
            $db2 = Null;
                
                                $db2 = Db::getInstance();
                                $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido FROM com_users"
                                        . " INNER JOIN com_competencias_nad_pru ON com_users.id = com_competencias_nad_pru.nadador WHERE com_competencias_nad_pru.prueba = :prueba ";
                                $bind2 = array(
                                            ':prueba' => $prueba
                                        );
                                if ($nadadorExc != 0) {
                                    $sql2 .= " AND com_competencias_nad_pru.nadador != :nadador ";
                                    $bind2[':nadador'] = $nadadorExc;
                                }
                            
                                    
                                /*echo $sql2;
                                print_r($bind2);*/
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                            
                                                return "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                
                                                
                                                return $row_p1;
                                        }
            
        }
        
        static function getPruebasJornadaNad($nadador,$jornada) {
            $db2 = Null;
                
                                $db2 = Db::getInstance();
                                $sql2 = "SELECT com_competencias_nad_pru.* FROM com_competencias_nad_pru"
                                        . " INNER JOIN com_competencias_pruebas ON com_competencias_pruebas.id = com_competencias_nad_pru.prueba WHERE com_competencias_pruebas.jornada = :jornada AND com_competencias_nad_pru.nadador = :nadador ";
                                $bind2 = array(
                                            ':jornada' => $jornada,
                                            ':nadador' => $nadador
                                        );
                               
                           
                                    
                               /* echo $sql2;
                                print_r($bind2);*/
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                            
                                                return "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                
                                                
                                                return $row_p1;
                                        }
                                        
            
        }
                
        
        public function getResultados($competencia) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT sys_Competidor.*, sys_Evento.Nombre AS evento_nombre, sys_Evento.final AS final FROM sys_Competidor "
                    . "LEFT JOIN sys_Evento ON sys_Evento.EventoId = sys_Competidor.EventoId "
                    . "LEFT JOIN sys_Clubes ON sys_Competidor.club_id = sys_Clubes.id "
                    . "WHERE sys_Evento.CompetenciaId = :comp_id AND sys_Clubes.activo = 5 AND sys_Competidor.usado=0 GROUP BY sys_Competidor.CompetidorId LIMIT 50";
    				$bind2 = array(
                                    ':comp_id' => $competencia
    				);
                                
                               /* echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_asistentes'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['resultados'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['resultados'] = $row_p1;
                                        }
            
        }
        
        public function getResultadosZip($competencia) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT Competidor.*, Club.Nombre AS Club FROM Competidor "
                    . "LEFT JOIN Evento ON Evento.EventoId = Competidor.EventoId "
                    . "LEFT JOIN Club ON Competidor.ClubId = Club.ClubId "
                    . "WHERE Evento.competencia = :comp_id AND Club.activo = 5 AND Competidor.usado=0 GROUP BY Competidor.CompetidorId";
    				$bind2 = array(
                                    ':comp_id' => $competencia
    				);
                                
                               /* echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_asistentes'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['resultadosZip'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['resultadosZip'] = $row_p1;
                                        }
            
        }
        
        public function getResultadosZip1($competencia) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT Resultado.*, Competidor.Nombres, Competidor.Apellidos, Competencia.Numero, Competencia.Sexo, Competencia.Modalidad, Competencia.EdadMinima, Competencia.EdadMaxima, Club.Nombre AS Club, com_users.nombre, com_users.apellido, com_users.id AS Oid FROM Resultado "
                    . "LEFT JOIN Competidor ON Competidor.CompetidorId = Resultado.CompetidorId "
                    . "LEFT JOIN Evento ON Competidor.EventoId = Evento.EventoId "
                    . "LEFT JOIN Competencia ON Resultado.CompetenciaId = Competencia.CompetenciaId "
                    . "LEFT JOIN Club ON Club.ClubId = Competidor.ClubId "
                    . "LEFT JOIN com_users ON com_users.id = Competidor.OctopusId "
                    . "WHERE Evento.competencia = :comp_id AND Club.activo = 5 AND Competidor.usado=0 AND Resultado.usado=0 LIMIT 50";
    				$bind2 = array(
                                    ':comp_id' => $competencia
    				);
                                /*
                                echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                $this->row[0]['cant_asistentes'] = $cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['resultados'] = "";
                                        } else {
                                               //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['resultados'] = $row_p1;
                                        }
            
        }
        
        public function actualizarUserComp($id, $nadador) {
            
            $db = Null;
                $db = Db::getInstance();
			$datar = array(
                            'OctopusId' => $nadador
                        );
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('Competidor', $datar, 'CompetidorId = :id', array(':id' => $id));
                        
                     
                   
            
        }
        
        public function getResultadosPro($competencia,$ano_desde=0,$ano_hasta=0) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_resultados.*, com_users.nombre, com_users.apellido AS apellido, com_pruebas.distancia, com_pruebas.estilo FROM com_resultados "
                    . "LEFT JOIN com_users ON com_resultados.nadador = com_users.id "
                    . "LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                    . "WHERE com_resultados.competencia = :competencia";
    				$bind2 = array(
                                ':competencia' => $competencia
    				);
            if ($ano_desde >0) {
                $sql2 .= " AND YEAR(com_users.fecnac) >= :ano_desde";
                $bind2[':ano_desde'] = $ano_desde;
            }
            if ($ano_hasta >0) {
                $sql2 .= " AND YEAR(com_users.fecnac) <= :ano_hasta";
                $bind2[':ano_hasta'] = $ano_hasta;
                
            }
            
            $sql2 .= " ORDER BY com_users.genero, com_resultados.prueba, com_resultados.lugar";
                                
                               /* echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                               
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['resultados'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['resultados'] = $row_p1;
                                        }
            
        }

        // funcion para conocer la cantidad de nadadores que tiene una prueba en el resultado
        static function getTotNadPruRes ($evento) {
            
            $sql2 = "SELECT sys_Competidor.CompetidorId FROM sys_Competidor "
                    . "WHERE sys_Competidor.EventoId = :id";
    				$bind2 = array(
                                ':id' => $evento
    				);
                                
                               /* echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                return $cont;
            
        }
        
        static function ZipHayFinales($evento) {
            $sql2 = "SELECT Resultado.ResultadoId FROM Resultado "
                    . "WHERE Resultado.CompetenciaId = :id AND EsFinal = 0 AND EsRelevo = 0";
    				$bind2 = array(
                                ':id' => $evento
    				);
                                
                               /* echo $sql2;
                                print_r($bind2);*/ 
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo $co
                                return $cont;
        }
        
        static function getTotNadPruResZip ($evento) {
            
            $hayfinales = self::ZipHayFinales($evento);
            
            //echo "fiales: ".$hayfinales;
            $sql2 = "SELECT Resultado.ResultadoId FROM Resultado "
                    . "WHERE Resultado.CompetenciaId = :id AND Resultado.EsRelevo = 0";
    				$bind2 = array(
                                ':id' => $evento
    				);
                                
            if ($hayfinales > 0) {
                $sql2 .= " AND Resultado.EsFinal = 0"; 
            }
                                
                               /* echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                return $cont;
            
        }
        
        public function getPosiblesConvocados() {
            // nadadores que no han sido convocados pero estan dentro de categoria
                    $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano, com_competencias_categorias.id AS cate FROM com_users "
                    . "INNER JOIN com_competencias_categorias ON YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta "
                    . "INNER JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "LEFT JOIN com_competencias_convocados ON com_competencias_convocados.nadador = com_users.id "
                    . "WHERE com_competencias.id = :id AND com_users.nadador = :nadador AND com_competencias_categorias.competencia = :id AND com_users.externo = 0 AND com_users.estado = 0 "
                    . "GROUP BY com_users.id, com_competencias_categorias.id";
    				$bind2 = array(
        			':id' => $this->row[0]['id'],
                                'nadador'=> '1'
    				);
                                
                                /*echo $sql2;
                                print_r($bind2);*/
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['posibles'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['posibles'] = $row_p1;
                                        }
            
        }
        public function getConvocadosOut() {
            // nadadores fuera de categoria para ser convocados
            $desde= array();
            $hasta= array();
            
            foreach ($this->row[0]['categorias'] AS $Cate) {
                $desde[] = $Cate['desde'];
                $hasta[] = $Cate['hasta'];                
            }
            
            sort($desde, '1');
            sort($hasta, '1');
            
            $primer_ano = $hasta[0];
            $ultimo_ano = end($desde);
            
            $ano_noesta = array();
            for ($i = $primer_ano; $i <= $ultimo_ano; $i++) {
                $esta = 0;
                foreach ($this->row[0]['categorias'] AS $Cate) {
                    if ($i <= $Cate['desde'] and  $i >= $Cate['hasta']) {
                        $esta = 1;
                    }                
                }
                if ($esta == 0) {
                    $ano_noesta[] = $i;
                }
                //echo $i;
            }
            /*echo "<br>";
            print_r($ano_noesta);
            echo "<br>";
            echo "primer ano: ".$primer_ano."<br>segundo ano: ".$ultimo_ano."<br>";*/
                    $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano FROM com_users " 
                    . "LEFT JOIN com_competencias_categorias ON YEAR(com_users.fecnac) > com_competencias_categorias.desde or YEAR(com_users.fecnac) < com_competencias_categorias.hasta "                   
                    . "LEFT JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "LEFT JOIN com_competencias_convocados ON com_competencias_convocados.nadador = com_users.id "
                    . "WHERE com_competencias.id = :id AND com_users.nadador = :nadador AND com_competencias_categorias.competencia = :id AND com_users.externo = 0 AND com_users.estado = 0 "
                    . "AND (YEAR(com_users.fecnac) < :primer_ano or YEAR(com_users.fecnac) > :ultimo_ano";
                    // AND com_competencias_convocados.nadador IS NULL
                    $bind2 = array(
        			':id' => $this->row[0]['id'],
                                'nadador'=> '1',
                                'primer_ano' => $primer_ano,
                                'ultimo_ano' => $ultimo_ano,
    				);
                    $conta = 1;
                    foreach ($ano_noesta AS $ano) {
                        $sql2 .=  " OR YEAR(com_users.fecnac) = :ano_".$conta;
                        $bind2[':ano_'.$conta] = $ano;
                        $conta ++;
                    }    
                    $sql2 .= ")"
                            
                    . "GROUP BY com_users.id";
    				
                                
                                //echo $sql2;
                                //print_r($bind2);
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró out";
                                                $this->row[0]['convoOut'] = "";
                                        } else {
                                                //echo "encontró out";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['convoOut'] = $row_p1;
                                        }
            
        }
        
        public function getConvocadosOne($nadador) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano, com_competencias_convocados.categoria AS cate, com_competencias_convocados.respondido FROM com_users "
                    . "INNER JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) OR (YEAR(com_users.fecnac) > com_competencias_categorias.desde or YEAR(com_users.fecnac) < com_competencias_categorias.hasta) "
                    . "INNER JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "INNER JOIN com_competencias_convocados ON com_competencias_convocados.nadador = com_users.id "
                    . "WHERE com_competencias.id = :id AND com_competencias_convocados.competencia = :id AND com_users.nadador = :nadador AND com_users.id = :user "
                    . "GROUP BY com_users.id,com_competencias_convocados.categoria, com_competencias_convocados.respondido";
    				$bind2 = array(
        			':id' => $this->row[0]['id'],
                                'nadador'=> '1',
                                'user' => $nadador
    				);
                                
                                //echo $sql2;
                                //print_r($bind2);
                                
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['convocados'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['convocados'] = $row_p1;
                                        }
            
        }
        
        static function verificarConvocado($nadador, $competencia) {
            // nadadores que ya fueron convocados
            
            $sql2 = "SELECT * FROM com_competencias_convocados WHERE com_competencias_convocados.competencia = :id AND com_competencias_convocados.nadador = :nadador";
    				$bind2 = array(
        			':id' => $competencia,
                                ':nadador'=> $nadador
    				);
                                
                                //echo $sql2;
                                //print_r($bind2);
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                return 0;
                                        } else {
                                                //echo "encontró";
                                                return 1;
                                        }
            
        }
        
        public function getConvocadosApo($apoderado) {
            // nadadores que ya fueron convocados
            
            /*$sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano, com_competencias_convocados.categoria AS cate, com_competencias_convocados.respondido, com_competencias.id AS comp_id, com_competencias.nombre AS comp_nombre, com_competencias.lugar AS comp_lugar, com_competencias.desde AS comp_desde, com_competencias.hasta AS comp_hasta, com_competencias.convocatoria_hasta FROM com_users "
                    . "INNER JOIN com_apoderados ON com_apoderados.nadador = com_users.id "
                    . "INNER JOIN com_competencias_categorias ON (YEAR(com_users.fecnac) <= com_competencias_categorias.desde AND YEAR(com_users.fecnac) >= com_competencias_categorias.hasta) OR (YEAR(com_users.fecnac) > com_competencias_categorias.desde or YEAR(com_users.fecnac) < com_competencias_categorias.hasta) "
                    . "INNER JOIN com_competencias ON com_competencias_categorias.competencia = com_competencias.id "
                    . "INNER JOIN com_competencias_convocados ON com_competencias_convocados.nadador = com_users.id "
                    . "WHERE com_competencias.convocatoria = :convocatoria AND com_users.nadador = :nadador AND com_competencias.convocatoria_hasta >= :hasta AND com_apoderados.apoderado = :apoderado AND com_competencias_convocados.respondido = :respuesta "
                    . "GROUP BY com_competencias.id";*/
                    
                    $sql2 = "SELECT com_users.id, com_users.nombre, com_users.apellido, YEAR(com_users.fecnac) AS ano, com_competencias_convocados.categoria AS cate, com_competencias_convocados.respondido, com_competencias.id AS comp_id, com_competencias.nombre AS comp_nombre, com_competencias.lugar AS comp_lugar, com_competencias.desde AS comp_desde, com_competencias.hasta AS comp_hasta, com_competencias.convocatoria_hasta FROM com_users "
                    . "INNER JOIN com_apoderados ON com_apoderados.nadador = com_users.id "
                    . "INNER JOIN com_competencias_convocados ON com_competencias_convocados.nadador = com_users.id "
                    . "INNER JOIN com_competencias ON com_competencias_convocados.competencia = com_competencias.id "                    
                    . "WHERE com_competencias.convocatoria = :convocatoria AND com_users.nadador = :nadador AND com_competencias.convocatoria_hasta >= :hasta AND com_apoderados.apoderado = :apoderado AND com_competencias_convocados.respondido = :respuesta "
                    . "GROUP BY com_competencias.id, com_users.id, com_competencias_convocados.categoria";
                    
                        $fecha = date('Y-m-d h:i:s');
    				$bind2 = array(
        			':convocatoria' => '1',
                                ':hasta' => $fecha,
                                'nadador'=> '1',
                                'apoderado' => $apoderado,
                                ':respuesta' => 0
    				);
                                
                                //echo $sql2;
                                //print_r($bind2);
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $this->row[0]['convocados'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                
                                                //print_r($row_p1);

                                                $this->convocados = $row_p1;
                                        }
            
        }


        public function agregarConvocado($competencia,$nadador, $cat_nadador) {
                $db = Db::getInstance();
			$data = array(
                            'competencia' => $competencia,
                            'nadador' => $nadador,
                            'categoria' => $cat_nadador
                        );
                        
                $db->save('com_competencias_convocados', $data, "competencia=:competencia AND nadador = :nadador" , array('competencia' => $competencia, 'nadador' => $nadador));
                              
               // $db->insert('com_competencias_convocados', $data);
                
                $this->enviarEmailConv($competencia,$nadador);

        }
        
        public function agregarAsistente($competencia,$nadador, $cat_nadador, $respuesta, $bus, $alojamiento, $user, $acompanantes=0) {
                        
                if ($respuesta == 1) {
                               
                        $db = Db::getInstance();
                            $data = array(
                                'competencia' => $competencia,
                                'nadador' => $nadador,
                                'categoria' => $cat_nadador
                            );
                         $db->save('com_competencias_asistentes', $data, "competencia=:competencia AND nadador = :nadador" , array('competencia' => $competencia, 'nadador' => $nadador));
                        

                        if ($bus == 1) {
                            $db = Null;
                            $db = Db::getInstance();
                                $datab = array(
                                    'competencia' => $competencia,
                                    'nadador' => $nadador,
                                    'acompanantes' => $acompanantes
                                );
                             //$db->insert('com_competencias_bus', $data);
                                $db->save('com_competencias_bus', $datab, "competencia=:competencia AND nadador = :nadador" , array('competencia' => $competencia, 'nadador' => $nadador));
                         

                        }

                        if ($alojamiento == 1) {
                            $db = Null;
                            $db = Db::getInstance();
                                $datah = array(
                                    'competencia' => $competencia,
                                    'nadador' => $nadador
                                );
                             //$db->insert('com_competencias_alojamiento', $data);
                                $db->save('com_competencias_alojamiento', $datah, "competencia=:competencia AND nadador = :nadador" , array('competencia' => $competencia, 'nadador' => $nadador));
                         

                        }
               
                    
                }     
                
                $db = Null;
                $db = Db::getInstance();
			$datar = array(
                            'respondido' => '1',
                            'user_respuesta' => $user
                        );
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_competencias_convocados', $datar, 'competencia = :competencia AND nadador = :nadador', array(':competencia' => $competencia, ':nadador' => $nadador));
                        
                        
                        
               

        }
        
        public function agregarAcompanante($rut,$nombre,$apellido,$direccion,$fecnac,$competencia,$nadador) {
            
            $rut = str_replace(".", "", $rut);
            $db = Db::getInstance();
			$data = array(
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'rut' => $rut,
                            'fecnac' => $fecnac
                        );
                        
                $db->save('com_acompanantes', $data, "rut=:rut" , array('rut' => $rut));
                
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $sql2 = "SELECT * FROM com_acompanantes WHERE rut = :rut LIMIT 1";
                                        $bind2 = array(
                                            ':rut' => $rut
                                        );
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                                //$row_p = "";
                                                //echo "NO encontró";
                                                //$this->row[0]['convocados'] = "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                
                                                $db = Db::getInstance();
                                                $data = array(
                                                    'competencia' => $competencia,
                                                    'nadador' => $nadador,
                                                    'acompanante' => $row_p1[0]['id'],
                                                    'tabla' => 'com_acompanantes'
                                                );

                                        $db->save('com_competencias_bus_acomp', $data, "competencia=:competencia AND acompanante=:acompanante" , array('competencia' => $competencia,'acompanante' => $row_p1[0]['id']));
                                                
                                        }
                   
            
        }
        
        public function agregarPruNad($nadador,$prueba,$pru_id,$tiempo) {
           // echo "vemos el tiempo que viene a la funcion". $tiempo."<br>";
            if ($tiempo !== 0) {
               // echo "el tiempo es 0<br><br>";
                $tiempo = Funciones::convertiraMS($tiempo);
            }
            
                        $db = Db::getInstance();
			$data = array(
                            'nadador' => $nadador,
                            'prueba' => $prueba,
                            'id_prueba' => $pru_id,
                            'tiempo' => $tiempo
                        );
                        
                $db->save('com_competencias_nad_pru', $data, "nadador=:nadador AND prueba= :prueba" , array('nadador' => $nadador, 'prueba' => $prueba));
                              
            
        }
        
        public function borrarPruNad($nadador,$prueba,$pru_id) {
          
                $tiempo = Funciones::convertiraMS($tiempo);
         
            
                        $db = Db::getInstance();
			
                 
                        $db->delete('com_competencias_nad_pru', "nadador=:nadador AND prueba=:prueba" , array(':nadador' => $nadador,':prueba' => $prueba)); 
                            
            
        }
        
        public function actInscrito($nadador, $competencia,$cerrado=0) {
            
            
                $db = Db::getInstance();
			$datar = array(
                            'inscrito' => '1',
                            'cerrado' => $cerrado
                        );
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_competencias_asistentes', $datar, 'competencia = :competencia AND nadador = :nadador', array(':competencia' => $competencia, ':nadador' => $nadador));
                        
                        
                   
            
        }
        
        static function getPruebaNadComp($nadador, $prueba){
                                $db2 = Null;
                                $db2 = Db::getInstance();
                                $sql2 = "SELECT * FROM com_competencias_nad_pru WHERE nadador = :nadador AND prueba = :prueba LIMIT 1";
                                        $bind2 = array(
                                            ':nadador' => $nadador,
                                            ':prueba' => $prueba
                                        );
                                $cont = $db2->run($sql2, $bind2);
                                //echo "cuantos nadadores".$cont;
                                        if ($cont == 0) {
                                            $resultado = array(
                                                        "inscrita" => 0,
                                                        "tiempo" => ""
                                                    );
                                                return $resultado;
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                
                                                $resultado = array(
                                                        "inscrita" => 1,
                                                        "tiempo" => $row_p1[0]['tiempo']
                                                    );
                                                return $resultado;
                                        }
            
            
        }
        
        public function borrarResp($competencia,$nadador) {
                        
                $db = Null;
                $db = Db::getInstance();
                $db->delete('com_competencias_alojamiento', "competencia=:competencia AND nadador = :nadador" , array(':competencia' => $competencia,':nadador' => $nadador)); 	
                    
                $db = Null;
                $db = Db::getInstance();
                $db->delete('com_competencias_bus', "competencia=:competencia AND nadador = :nadador" , array(':competencia' => $competencia,':nadador' => $nadador)); 	
                
                $db = Null;
                $db = Db::getInstance();
                $db->delete('com_competencias_asistentes', "competencia=:competencia AND nadador = :nadador" , array(':competencia' => $competencia,':nadador' => $nadador)); 	
                     
                        
                $db = Null;
                $db = Db::getInstance();
			$datar = array(
                            'respondido' => '0',
                            'user_respuesta' => $user
                        );
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('com_competencias_convocados', $datar, 'competencia = :competencia AND nadador = :nadador', array(':competencia' => $competencia, ':nadador' => $nadador));
                        
                        
                        
               

        }
        
        public function verificarAsistencia($nadador,$competencia = 0) {
            $respuesta= array();
            if ($competencia == 0){
                $competencia = $this->row[0]['id'];
            }
                                        $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT * FROM com_competencias_asistentes WHERE competencia = :competencia AND nadador = :nadador LIMIT 1";
                                        $bind2 = array(
                                            ':competencia' => $competencia,
                                            ':nadador' => $nadador
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                $respuesta['asiste'] = 0;
                                        } else {
                                                //echo "encontró";
                                                $respuesta['asiste'] = 1;
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                //unset($respuesta['asiste']['asistencia']);
                                                //$respuesta['asiste']['asistencia'] = $row_p1;
                                                
                                                $db2 = Null;
                                                $db2 = Db::getInstance();
                                                $sql2 = "SELECT * FROM com_competencias_bus WHERE competencia = :competencia AND nadador = :nadador LIMIT 1";
                                                $bind2 = array(
                                                    ':competencia' => $this->row[0]['id'],
                                                    ':nadador' => $nadador
                                                );

                                                $cont = $db2->run($sql2, $bind2);
                                                if ($cont == 0) {
                                                    $row_p = "";
                                                    //echo "NO encontró";
                                                    $respuesta['bus'] = 0;
                                                } else {
                                                    $respuesta['bus'] = 1;
                                                }
                                                
                                                $db2 = Null;
                                                $db2 = Db::getInstance();
                                                $sql2 = "SELECT * FROM com_competencias_alojamiento WHERE competencia = :competencia AND nadador = :nadador LIMIT 1";
                                                $bind2 = array(
                                                    ':competencia' => $this->row[0]['id'],
                                                    ':nadador' => $nadador
                                                );

                                                $cont = $db2->run($sql2, $bind2);
                                                if ($cont == 0) {
                                                    $row_p = "";
                                                    //echo "NO encontró";
                                                    $respuesta['alojamiento'] = 0;
                                                } else {
                                                    $respuesta['alojamiento'] = 1;
                                                }
                                        }
                                        
                                        return $respuesta;
            
        }
        
        public function getDocumentos() {
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT * FROM com_competencias_doc WHERE competencia = :competencia ORDER BY id";
                                        $bind2 = array(
                                            ':competencia' => $this->row[0]['id']
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                $this->row[0]['doc'] = $row_p1;
                                        }
            
        }
        public function getDocumentoOne($id) {
            
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT * FROM com_competencias_doc WHERE id = :id LIMIT 1";
                                        $bind2 = array(
                                            ':id' => $id
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);

                                                //$this->row[0]['doc'] = $row_p1;
                                                return $row_p1;
                                        }
            
        }
        
        public function guardarDoc($id, $valor, $nombre, $ext) {
            $db = Db::getInstance();
			$data = array(
                            'competencia' => $id,
                            'clave' => $valor,
                            'nombre' => $nombre,
                            'extension' => $ext
                        );
                        
                        
                $db->insert('com_competencias_doc', $data);
		//$this->id = $db->lastInsertId();
            
        }
        
        public function enviarEmailConv($competencia,$nadador) {
            
            $mailhost = "server.tuehost.com";
$maillogin = "comunicaciones-tba@gsx7.com";
$mailpass = "15230574";
$mailemail = "comunicaciones-tba@gsx7.com"; 
$mailport = "";
$mailsecure = "";
            $sql = "select apo.nombre as apo_nombre, apo.apellido as apo_apellido, apo.email as apo_email, nad.nombre as nad_nombre, nad.apellido as nad_apellido, comp.nombre as comp_nombre, comp.lugar, comp.desde, comp.hasta
            from com_users as nad
            inner join com_apoderados as rel on nad.id = rel.nadador
            inner join com_users as apo on rel.apoderado = apo.id
            inner join com_competencias_convocados AS conv on conv.nadador = nad.id
            inner join com_competencias as comp on comp.id = conv.competencia
            where nad.id = :nadador and comp.id = :competencia";
            $db2 = Null;
            $db2 = Db::getInstance();
            unset($bind2);
            
            $bind2 = array(
                ':competencia' => $this->row[0]['id'],
                ':nadador' => $nadador
            );

            $cont = $db2->run($sql, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                //echo "NO encontró";
                                                //$respuesta['asiste'] = 0;
                                        } else {
                                                //echo "encontró";
                                                //$respuesta['asiste'] = 1;
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql, $bind2);
                                                
                                                foreach ($row_p1 as $row_p2) {
                                                    if (!empty($row_p2['apo_email'])) {
                                                    
                                                
                                          /*
                                                    $content = "Un usuario NADADOR FUE CONVOCADO<br>";
					  $content .= "Nadador: ".$row_p2['nad_nombre']." ".$row_p2['nad_apellido']."<br>";
					  $content .= "Email: ".$email."<br>";
					  $content .= "Mensaje: ".$mensaje."<br>";*/
                                                    
                                                    $content = "<table width=\"580\" style=\"background-color: #ffffff; margin: 0px auto;\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#274590\">
        <tr>
         <td valign=\"top\" align=\"center\"><img src=\"".BASE_PATH."/assets/img/logo-light.png\" alt=\"Club natacion Punta Arenas\" /></td>
        </tr>
        <tr>
         <td valign=\"top\" align=\"left\">
             <table width=\"580\" style=\"margin: 0px auto; border-collapse: collapse;\" cellpadding=\"0\" cellspacing=\"0\">
             <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />
              Apoderado:. ".$row_p2['apo_nombre']." ".$row_p2['apo_apellido']."<br><br>

El nadador: ".$row_p2['nad_nombre']." ".$row_p2['nad_apellido'].".<br>
Fue convocado por el entrenador para participar en la competencia: ".$row_p2['comp_nombre']." ha realizarse en ".$row_p2['lugar']." desde el ".Funciones::fechaMostrar($row_p2['desde'])." hasta el ".Funciones::fechaMostrar($row_p2['hasta']).".<br>
Por favor ingresar el sistema y confirmar su participación:
<a href=\"".BASE_PATH."\">".BASE_PATH."</a>
<br><br> </font>
                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>

             <tr>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
               <td width=\"560\" align=\"left\" valign=\"top\"><font size=\"2\" color=\"#000000\" face=\"Arial, sans-serif\"><br /><br />

Muchas gracias.<br><br>

Cordialmente,<br><br>
Club de Natación Punta Arenas
<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
                </font>




                </td>
               <td width=\"15\" valign=\"top\" align=\"left\">&nbsp;</td>
             </tr>

             </table>
         </td>
        </tr>

        </table>";



				     $mail = new PHPMailer();



                                            $mail->IsSMTP();

                                            $mail->SMTPDebug = 1;
                                            // 0 = no output, 1 = errors and messages, 2 = messages only.


                                            /* Sustituye (ServidorDeCorreoSMTP)  por el host de tu servidor de correo SMTP*/
                                            $mail->Host = $mailhost;
                                            if (!empty($mailsecure)) {
                                            $mail->SMTPSecure = $mailsecure;
                                            }
                                            if (!empty($mailport)) {
                                            $mail->Port = $mailport;
}

					  $mail->From = $mailemail;
					  $mail->FromName = "Club Natacion Punta Arenas";
					  $mail->Subject = "Convocatoria Competencia";
					  $mail->AltBody = "cnpa";
					  $mail->MsgHTML($content);
					  //$mail->AddAddress('contacto@cursoDiabestDigital.com','Contacto CursoDiabestDigital');
						$mail->AddAddress($row_p2['apo_email'],$row_p2['apo_nombre']." ".$row_p2['apo_apellido']);

                                            //$mail->AddBCC('giannalia@gmail.com', 'test');
					  $mail->SMTPAuth = true;
					 $mail->Username = $maillogin;
					$mail->Password = $mailpass;
					$mail->CharSet = 'UTF-8';
					 $mail->Send();
                                         
                                         $dbm = Null;
                                         $dbm = Db::getInstance();
                                            $datam = array(
                                                'mail_apoderado' => '1'
                                            );
    	//$db->insert('com_proyectos', $data);
		   
                                        $dbm->update('com_competencias_convocados', $datam, 'nadador = :nadador AND competencia = :competencia', array(':nadador' => $nadador, ':competencia' => $competencia));
                   
                   
                                                }
                                          }
                                          
                                        }
        }
        
        // borrar datos
        
        public function elimAlojamiento($id) {
            $db = Db::getInstance();
            $db->delete('com_competencias_alojamiento', "competencia=:id" , array(':id' => $id)); 

        }
        public function elimBus($id){
            $db = Db::getInstance();
            $db->delete('com_competencias_bus', "competencia=:id" , array(':id' => $id));
            
            $db1 = Db::getInstance();
            $db1->delete('com_competencias_bus_acomp', "competencia=:id" , array(':id' => $id));
        }
        public function elimAsistentes($id){
            $db = Db::getInstance();
            $db->delete('com_competencias_asistentes', "competencia=:id" , array(':id' => $id));
        }
       
        public function elimCompCate($id){
            $db = Db::getInstance();
            $db->delete('com_competencias_categorias', "competencia=:id" , array(':id' => $id));
    
        }
        public function elimConvocados($id){
            $db = Db::getInstance();
            $db->delete('com_competencias_convocados', "competencia=:id" , array(':id' => $id));
    
        }
        
        public function elimDocu($id){
            $db = Db::getInstance();
            $db->delete('com_competencias_doc', "competencia=:id" , array(':id' => $id));
    
        }
        public function elimJornadas($id){
            $db = Db::getInstance();
            $db->delete('com_competencias_jornadas', "competencia=:id" , array(':id' => $id));
    
        }
        public function elimPruebas($id){
            
            $db = Db::getInstance();
            $sql = "DELETE com_competencias_pruebas.* from com_competencias_pruebas LEFT JOIN com_competencias_nad_pru ON com_competencias_pruebas.id = com_competencias_nad_pru.prueba"
                    . " LEFT JOIN com_competencias_pruebas_cat ON com_competencias_pruebas.id = com_competencias_pruebas_cat.prueba"
                    . " WHERE com_competencias_pruebas.competencia = :id";
            $bind = array(
                                    ':id' => $id
                                );
		        
		$db->run($sql, $bind);
            
           // $db = Db::getInstance();
           // $db->delete('com_competencias_pruebas', "competencia=:id" , array(':id' => $id));
    
        }
		
}