<?php
class Federacion
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
       $this->tabla = "com_federaciones";
	
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
		
	public function agregar ($federacion)
    {
	   if (empty($federacion)) {
		   header("Location: federaciones.php?err=1");
	   } else {
               
            //$orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            'federacion' => $federacion
                        );
            $db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();
		
		header("Location: federaciones.php?add=ok");
		
	   }
		
    }
	
	
	
	public function modificar ($id, $federacion)
    {
	   if (empty($id)) {
		   header("Location: federaciones.php");
	   }
		else if (empty($colegio)) {
		   header("Location: federaciones_mod.php?id=".$id);
	   } else {
		
			$db = Db::getInstance();
			$data = array(
        	'federacion' => $federacion
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		   
		header("Location: federaciones.php");
	   }
		
    }


	

	
	public function getAll ()
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM ".$this->tabla." WHERE id>:id ORDER BY federacion";
    				$bind = array(
        			':id' => '0'
    				);
					
				
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



	
	
	
	
		
}