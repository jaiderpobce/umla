<?php
class Region
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
       $this->tabla = "com_regiones";
	
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
		
	public function agregar ($pais)
    {
	   if (empty($club)) {
		   header("Location: paises.php?err=1");
	   } else {
               
            //$orden = $this->getOrden();
			
			$db = Db::getInstance();
			$data = array(
                            'pais' => $pais
                        );
            $db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();
		
		header("Location: paises.php?add=ok");
		
	   }
		
    }
	
	
	
	public function modificar ($id,$pais)
    {
	   if (empty($id)) {
		   header("Location: club.php");
	   }
		else if (empty($club)) {
		   header("Location: paises_mod.php?id=".$id);
	   } else {
			
			$db = Db::getInstance();
			$data = array(
			    'pais' => $pais,
        		   
		);
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		   
		header("Location: paises.php");
	   }
		
    }


	
   
	
	public function getAll ()
	{
		      
				$db = Db::getInstance();
		     
					$sql = "SELECT * FROM ".$this->tabla."  ";
    				
					

                    	$sql .= " WHERE id>:id ";
                        $bind[":id"] = '0';
                 

				    
				
					$sql .= " ORDER BY pais"; 
		        
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
