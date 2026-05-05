<?php
class Prueba
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
       $this->tabla = "com_pruebas";
	
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
		
	public function agregar ($distancia, $estilo, $nombre)
    {
	   if (empty($nombre)) {
		   header("Location: pruebas.php");
	   } else {
               
               $orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            'distancia' => $distancia,
                            'estilo' => $estilo,
                            'nombre' => $nombre,
                            'orden' => $orden
                        );
                $db->insert($this->tabla, $data);
		$this->id = $db->lastInsertId();
		
		//header("Location: usuarios_up.php?id=".$this->id);
		
	   }
		
    }
	
	
	
	public function modificarFactor ()
    {
	   
                        $db = Null;
			$db = Db::getInstance();
			$data = array(
                        'factor2' => '2.00'
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'distancia = :distancia or distancia = :distancia1 or distancia = :distancia2', array(':distancia' => '25',':distancia1' => '50',':distancia2' => '100'));
		   
                   
                   
                    $db = Null;
			$db = Db::getInstance();
			$data = array(
                        'factor2' => '1.75'
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'distancia = :distancia or distancia = :distancia1', array(':distancia' => '200',':distancia1' => '400'));
		   
                   
                   $db = Null;
			$db = Db::getInstance();
			$data = array(
                        'factor2' => '1.50'
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'distancia = :distancia or distancia = :distancia1', array(':distancia' => '800',':distancia1' => '1500'));
		   
                   
                   
		//header("Location: usuarios.php");
	  
		
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


	

	
	public function getAll ($estilo = '', $conver=0)
	{
		      
				$db = Db::getInstance();
		     
				$sql = "SELECT * FROM ".$this->tabla."";
    				$bind = array();
                                if (!empty($estilo)) {
                                    $sql .= " WHERE estilo = :estilo";
                                    $bind[':estilo'] = $estilo;

                                    if ($conver==1) {
                                    	$sql .= " AND convF > 0";                                   
                                	} 
                                }
                                
                                $sql .= " ORDER BY  orden";

                               // echo $sql;
					
				
				/*$total_results = $db->run($sql, $bind);
					$total_pages = ceil($total_results/$this->limit);
					$this->total_pages = $total_pages;


					$starting_limit = ($this->pag-1)*$this->limit;
    				
    				if (empty($this->orden)) {
    					$orden = $this->tabla.".nombre";
    				} else {
    					$orden = $this->orden;
    				}
    				

    				if ($this->tiporden == 'desc') {
    					$tiporden = " desc";
    				} else {
    					$tiporden = "";
    				}

    				$sql .= " ORDER BY ".$orden.$tiporden." LIMIT ".$starting_limit.",". $this->limit; 

                                */
		        
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
        
        static function getByValores($estilo, $distancia) {
            
            $db = Db::getInstance();
				$sql = "SELECT * FROM com_pruebas WHERE distancia = :distancia AND estilo = :estilo LIMIT 1";
    			$bind = array(
                            ':estilo' => $estilo,
                            ':distancia' => $distancia
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					return $row_p;
				}
            
        } 

		static function getByValoresMeet($estilo, $distancia, $relevo = 'I') {

			if ($relevo == 'R') {
				$relevo = 1;
			} else {
				$relevo = 0;
			}

			$cod_meet = $distancia.$estilo;
            
            $db = Db::getInstance();
				$sql = "SELECT * FROM com_pruebas WHERE cod_meet = :cod_meet AND relevo = :relevo LIMIT 1";
    			$bind = array(
                            ':cod_meet' => $cod_meet,
                            ':relevo' => $relevo
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					return $row_p;
				}
            
        } 


		static function getByCodigoMeet($prueba, $relevo = 'I') {

			if ($relevo == 'R') {
				$relevo = 1;
			} else {
				$relevo = 0;
			}

			$cod_meet = $prueba;
            
            $db = Db::getInstance();
				$sql = "SELECT * FROM com_pruebas WHERE cod_meet = :cod_meet AND relevo = :relevo LIMIT 1";
    			$bind = array(
                            ':cod_meet' => $cod_meet,
                            ':relevo' => $relevo
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					return $row_p;
				}
            
        } 
        
        static function getRelevoRelacion($prueba) {
            
            $db = Db::getInstance();
				$sql = "SELECT com_pruebas.* FROM com_pruebas INNER JOIN com_pruebas_relacion ON  com_pruebas.id = com_pruebas_relacion.prueba WHERE com_pruebas_relacion.relevo = :prueba";
    			$bind = array(
                            ':prueba' => $prueba
    			);
		        
				$cont = $db->run($sql, $bind);
				if ($cont == 0) {
					return "";
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
				  
					return $row_p;
				}
            
        }



	
	
	
	
		
}