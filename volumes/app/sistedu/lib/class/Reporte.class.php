<?php
class Reporte
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
       $this->tabla = "com_reportes";
	
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
		
	public function agregar ($clave, $nadador, $fecha, $user)  {
            
            if (empty($clave)) {
		   //header("Location: nadadores.php");           
            } else {               
            //$orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            'clave' => $clave,
                            'nadador' => $nadador,
                            'fecha' => $fecha,
                            'user' => $user
                        );
                        $db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();
		
		//header("Location: nadadores.php?add=ok");
		
	   }
		
    }
    
    public function agregarGrafico ($clave, $nadador, $imagen, $prueba)  {
            
            if (empty($clave)) {
		   //header("Location: nadadores.php");           
            } else {               
            //$orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            'clave' => $clave,
                            'nadador' => $nadador,
                            'fecha' => $fecha
                        );
                        $db->insert('com_reportes_graf', $data);
			$this->idg = $db->lastInsertId();
		
		//header("Location: nadadores.php?add=ok");
		
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

    public function actTableCompe ($id)
    {
	   
		
			$db = Db::getInstance();
			$data = array(
                        'usado' => '1'
                        );
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('sys_Competidor', $data, 'CompetidorId = :id', array(':id' => $id));
		   
		//header("Location: usuarios.php");
	   
		
    }
	

	
	public function getAll ($nadador)
	{
		      
				$db = Db::getInstance();
		     
				$sql = "SELECT ".$this->tabla.".*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM ".$this->tabla
                                        ." LEFT JOIN com_pruebas ON ".$this->tabla.".prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON ".$this->tabla.".competencia = com_competencias.id "
                                        . "WHERE ".$this->tabla.".nadador=:id ORDER BY com_pruebas.orden, ".$this->tabla.".fecha DESC, ".$this->tabla.".final";
    				$bind = array(
        			':id' => $nadador
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
        
        static function getMarcaPruNad($prueba, $nadador, $criterio, $piscina) {
            
            $db = Db::getInstance();
		     
				$sql = "SELECT com_resultados.*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM com_resultados"
                                        ." LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON com_resultados.competencia = com_competencias.id "
                                        . "WHERE com_resultados.nadador=:id AND com_resultados.prueba = :prueba AND com_resultados.piscina = :piscina";
                                if ($criterio == 'mejor') {
                                    $sql .= " ORDER BY com_resultados.tiempo LIMIT 5";
                                } else {
                                    $sql .= " ORDER BY com_resultados.fecha DESC LIMIT 5";
                                }
                                
                                $bind = array(
                                    ':id' => $nadador,
                                    ':prueba' => $prueba,
                                    ':piscina' => $piscina
    				);
					
				
				
		        
				$cont = $db->run($sql, $bind);
                                
                                if ($cont == 0) {
                                        $db = Null; 
					$db = Db::getInstance();
		     
                                        $sql = "SELECT com_resultados.*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM com_resultados"
                                                ." LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                                                ." LEFT JOIN com_competencias ON com_resultados.competencia = com_competencias.id "
                                                . "WHERE com_resultados.nadador=:id AND com_resultados.prueba = :prueba";
                                        if ($criterio == 'mejor') {
                                            $sql .= " ORDER BY com_resultados.tiempo LIMIT 5";
                                        } else {
                                            $sql .= " ORDER BY com_resultados.fecha DESC LIMIT 5";
                                        }
                                        
                                        unset($bind);

                                        $bind = array(
                                            ':id' => $nadador,
                                            ':prueba' => $prueba
                                        );




                                        $cont = $db->run($sql, $bind);

				}
                                
                                
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



	
        static function getMejorTiempo($prueba, $nadador, $competencia) {
            
            $db = Db::getInstance();
		     
				$sql = "SELECT com_resultados.*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM com_resultados"
                                        ." LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON com_resultados.competencia = com_competencias.id "
                                        . "WHERE com_resultados.nadador=:id AND com_resultados.prueba = :prueba AND com_resultados.competencia = :competencia";
                             
                                    $sql .= " ORDER BY com_resultados.tiempo LIMIT 1";
                                
                                
                                $bind = array(
                                    ':id' => $nadador,
                                    ':prueba' => $prueba,
                                    ':competencia' => $competencia
    				);
					
				
				
		        
				$cont = $db->run($sql, $bind);
                                
                                if ($cont == 0) {
                                        

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
        static function getTotNadPru($prueba, $nadador, $competencia) {
            
            $db = Db::getInstance();
		     
				$sql = "SELECT com_resultados.totnadpru FROM com_resultados"
                                        ." LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON com_resultados.competencia = com_competencias.id "
                                        . "WHERE com_resultados.nadador=:id AND com_resultados.prueba = :prueba AND com_resultados.competencia = :competencia";
                             
                                    $sql .= " ORDER BY com_resultados.totnadpru DESC LIMIT 1";
                                
                                
                                $bind = array(
                                    ':id' => $nadador,
                                    ':prueba' => $prueba,
                                    ':competencia' => $competencia
    				);
					
				
				
		        
				$cont = $db->run($sql, $bind);
                                
                                if ($cont == 0) {
                                        

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
        
        static function getPosicion($prueba, $nadador, $competencia) {
            
            $db = Db::getInstance();
		     
				$sql = "SELECT com_resultados.*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM com_resultados"
                                        ." LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON com_resultados.competencia = com_competencias.id "
                                        . "WHERE com_resultados.nadador=:id AND com_resultados.prueba = :prueba AND com_resultados.competencia = :competencia";
                             
                                    $sql .= " ORDER BY com_resultados.final DESC LIMIT 1";
                                
                                
                                $bind = array(
                                    ':id' => $nadador,
                                    ':prueba' => $prueba,
                                    ':competencia' => $competencia
    				);
					
				
				
		        
				$cont = $db->run($sql, $bind);
                                
                                if ($cont == 0) {
                                        

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
	
	
		
}