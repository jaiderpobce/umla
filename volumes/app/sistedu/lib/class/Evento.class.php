<?php
class Categoria
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
       $this->tabla = "com_categorias";
	
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
		
	public function agregar ($categoria,$federacion,$desde,$hasta)
    {
	   if (empty($categoria) or empty($federacion)) {
		   header("Location: categorias.php?err=1");
	   } else {
               
            //$orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            'categoria' => $categoria,
                            'federacion' => $federacion,
                            'desde' => $desde,
                            'hasta' => $hasta
                        );
                        $db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();
                        $this->asignarNadadores($this->id,$desde,$hasta,$federacion);
		
		
		
	   }
		
    }
	
	
	
	public function modificar ($id,$categoria,$federacion,$desde,$hasta)
    {
	   if (empty($id)) {
		   header("Location: categorias.php");
	   }
		 if (empty($categoria) or empty($federacion)) {
		   header("Location: categorias_mod.php?id=".$id);
	   } else {
		
			$db = Db::getInstance();
			$data = array(
        	'categoria' => $categoria,
                            'federacion' => $federacion,
                            'desde' => $desde,
                            'hasta' => $hasta
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		   
		header("Location: categorias.php");
	   }
		
    }


	

	
	public function getAll ($federacion = 0)
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT ".$this->tabla.".*, com_federaciones.federacion AS fede_nombre FROM ".$this->tabla." LEFT JOIN com_federaciones ON ".$this->tabla.".federacion = com_federaciones.id WHERE ";
                                        
                                        if ($federacion== 0) {
                                            $sql .= $this->tabla.".id>:id ";
                                            $bind = array(
                                                ':id' => '0'
                                            );
                                        } else {
                                            $sql .= $this->tabla.".federacion=:federacion ";
                                            $bind = array(
                                                ':federacion' => $federacion
                                            );
                                        }
                                        
                                        $sql .= " ORDER BY com_federaciones.federacion, ".$this->tabla.".desde, ".$this->tabla.".hasta";
    				
					
				
		        
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
        
        public function getAllComp ($federacion, $competencia)
	{		      
				$db = Db::getInstance();		     
					$sql = "SELECT ".$this->tabla.".*, com_federaciones.federacion AS fede_nombre, com_competencias_categorias.id AS ca_comp_id FROM ".$this->tabla." "
                                                . "LEFT JOIN com_federaciones ON ".$this->tabla.".federacion = com_federaciones.id "
                                                . "LEFT JOIN com_competencias_categorias ON ".$this->tabla.".id = com_competencias_categorias.categoria "
                                                . "WHERE com_competencias_categorias.competencia = :competencia AND ";                                        
                                        if ($federacion== 0) {
                                            $sql .= $this->tabla.".id>:id ";
                                            $bind = array(
                                                ':id' => '0',
                                                ':competencia' => $competencia
                                            );
                                        } else {
                                            $sql .= $this->tabla.".federacion=:federacion ";
                                            $bind = array(
                                                ':federacion' => $federacion,
                                                ':competencia' => $competencia
                                            );
                                        }
                                        
                                        $sql .= " ORDER BY com_federaciones.federacion, ".$this->tabla.".desde, ".$this->tabla.".hasta";
    				
					
				
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					
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
        
        public function asignarCategoria($user,$edad) {
            
                $db = Db::getInstance();
		     
		$sql = "SELECT * FROM ".$this->tabla." WHERE desde<=:edad AND hasta>=:edad ";                        
                    $bind = array(
                        ':edad' => $edad                                
                    );
                    
                    $cont = $db->run($sql, $bind);
                    $db0 = Null;
                    $db0 = Db::getInstance();	
       
			$db0->delete('com_categorias_users', "user=:user" , array(':user' => $user)); 	
                        
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
                                            $db2 = Null;
                                            $db2 = Db::getInstance();
                                            $data2 = array(
                                                'user' => $user,
                                                'categoria' => $row_p1['id'],
                                                'federacion' => $row_p1['federacion']
                                            );
                                            $db2->insert('com_categorias_users', $data2);
                                       
					}
					
				}
                                        
                                        
                                       		
    				
            
        }
        
        public function asignarNadadores($categoria,$desde, $hasta,$federacion) {
            
                $desdeY = date('Y')-$desde;
                $hastaY = date('Y')-$hasta;
                
                $desdeF = $desdeY."-12-31";
                $hastaF = $hastaY."-01-01";
            
                $db = Db::getInstance();
		     
		$sql = "SELECT * FROM com_users WHERE fecnac BETWEEN :hastaF AND :desdeF ";                        
                    $bind = array(
                        ':desdeF' => $desdeF ,
                        ':hastaF' => $hastaF                                
                    );
                    
                    /*echo $sql;
                    print_r($bind);*/
                    
                    $cont = $db->run($sql, $bind);
                    $db0 = Null;
                    $db0 = Db::getInstance();	
       
			$db0->delete('com_categorias_users', "categoria=:categoria" , array(':categoria' => $categoria)); 	
                        
				if ($cont == 0) {
					$row_p = "";
				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
                                       
                                            $db2 = Null;
                                            $db2 = Db::getInstance();
                                            $data2 = array(
                                                'user' => $row_p1['id'],
                                                'categoria' => $categoria,
                                                'federacion' => $federacion
                                            );
                                            $db2->insert('com_categorias_users', $data2);
                                       
					}
					
				}
                                        
                                        
                                       		
    				
            
        }


        static function getCatPruebas($prueba) {
            // obtiene las categorias de una prueba
            $db2 = Null;
                                        $db2 = Db::getInstance();
                                        $sql2 = "SELECT com_categorias.categoria, com_competencias_categorias.desde, com_competencias_categorias.hasta FROM com_competencias_pruebas_cat "
                                                . "LEFT JOIN com_competencias_categorias ON com_competencias_categorias.id = com_competencias_pruebas_cat.categoria "
                                                . "LEFT JOIN com_categorias ON com_competencias_categorias.categoria = com_categorias.id "
                                                . "WHERE com_competencias_pruebas_cat.prueba = :prueba ORDER BY com_competencias_categorias.desde";
                                        $bind2 = array(
                                            ':prueba' => $prueba
                                        );

                                        $cont = $db2->run($sql2, $bind2);
                                        if ($cont == 0) {
                                                $row_p = "";
                                                return "";
                                        } else {
                                                //echo "encontró";
                                                $db1 = Null;
                                                $db1 = Db::getInstance();
                                                $row_p1 = $db1->fetchAll($sql2, $bind2);
                                                
                                                return $row_p1;

                                                //$this->row[0]['pruebas'] = $row_p1;
                                        }
        }
        
        static function getCateNadador ($ano, $federacion, $competencia){
            $edad = date('Y')-$ano;
            //echo $edad;
            $db = Db::getInstance();
            
			$sql = "SELECT com_categorias.*, com_competencias_categorias.id AS ca_comp_id FROM com_categorias "
                                . "LEFT JOIN com_competencias_categorias ON com_competencias_categorias.categoria = com_categorias.id "
                                . "WHERE com_categorias.desde <= :ano AND com_categorias.hasta >= :ano AND com_categorias.federacion = :federacion AND com_competencias_categorias.competencia = :competencia LIMIT 1";
    			$bind = array(
        		':ano' => $edad,
                        ':federacion' => $federacion,
                        ':competencia' => $competencia
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					//$this->row = $row_p;
                                        return $row_p;
				}
            
            
        } 
        
        static function getCateNadadorGen ($nadador){
            $edad = date('Y')-$ano;
            //echo $edad;
            $db = Db::getInstance();
            
			$sql = "SELECT com_categorias.*, com_federaciones.federacion AS fede_nombre FROM com_categorias "
                                . "INNER JOIN com_categorias_users ON com_categorias_users.categoria = com_categorias.id "
                                . "LEFT JOIN com_federaciones ON com_categorias_users.federacion = com_federaciones.id "
                                . "WHERE com_categorias_users.user = :nadador";
    			$bind = array(
        		':nadador' => $nadador
    			);
                        
                        /*echo $sql;
                        print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					$row_p = "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					//$this->row = $row_p;
                                        return $row_p;
				}
            
            
        } 
        
        static function getCateCompetencia ($id){
            
            $db = Db::getInstance();
            
			$sql = "SELECT com_categorias.*, com_competencias_categorias.id AS ca_comp_id FROM com_categorias "
                                . "LEFT JOIN com_competencias_categorias ON com_competencias_categorias.categoria = com_categorias.id "
                                . "WHERE com_competencias_categorias.id = :id";
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
				  
					//$this->row = $row_p;
                                        return $row_p;
				}
            
            
        } 
	
	
	
	
		
}