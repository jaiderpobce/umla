<?php
class Estatu
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
       $this->tabla = "com_estatus";
	
    }
	
    

	
	public function getAll ($estatus)
	{
		      
		$db = Db::getInstance();

		$sql = "SELECT * FROM ".$this->tabla."  ";

		if (!empty($estatus)) {
		$sql .= " WHERE id in (".$estatus.") ";
		//$bind[":id"] = $tipo_grupo;
		}else{

		$sql .= " WHERE id>:id ";
		$bind[":id"] = '0';
		}

		$sql .= " ORDER BY id"; 

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
	
	
	
	
	public function getAllTable ($paginado=1,  $tipoLimit='', $opciones = array(),$estatus='',$page,$orden,$limit)
    {
              
			

			$db = Db::getInstance();
		     
		    $sql = "SELECT * FROM ".$this->tabla."  ";
    				
		    if (!empty($estatus)) {
                        $sql .= " WHERE id=:id ";
                        $bind[":id"] = $estatus;
                    }else{

                    	$sql .= " WHERE id>:id ";
                        $bind[":id"] = '0';
                    }


			

			if (!empty($opciones['estatus'])) {
				$estatus = $opciones['estatus'];
				$estatus = str_replace(", ", ",", $estatus);
				$estatus = str_replace(",", " ", $estatus);
				$estatuss = explode(" ", $estatus);
				$concatenador = "AND ";
				$conti = 1;

				foreach($estatuss as $word){

					$sql.= " ".$concatenador;

					$sql .= " (estatus LIKE :estatus_".$conti." )";
					$bind[":estatus_".$conti] = "%$word%";
					$conti ++;
				}

			}

			
			

			$arrayresult=array();
			if (empty($this->orden)) {
			$orden = $this->tabla.".estatus";
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
		
	public function agregar ($estatu,$idUser)
    {
	   if (empty($estatu)) {
		   header("Location: estatus.php?err=1");
	   } else {
               
            //$orden = $this->getOrden();
			 $rut = str_replace(".", "", $rut);
			$db = Db::getInstance();
			$data = array(
                          
                            'estatus' => $estatu,
		
 			    'fecha_cre' => date('Y-m-d h:i:s'),
                            'user_cre' => $idUser,
                        );
            $db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();
		
		
	   }
		
    }
	
	
	
	public function modificar ($id,$estatu,$idUser)
    {
	   if (empty($id)) {
		   header("Location: estatus.php");
	   }
		else if (empty($estatu)) {
		   header("Location: estatus_mod.php?id=".$id);
	   } else {
			 
			$db = Db::getInstance();
			$data = array(
			   
        		    'estatus' => $estatu,
			    
 			    'fecha_mod' => date('Y-m-d h:i:s'),
                            'user_mod' => $idUser,
		);
    	
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		   
		
	   }
		
    }

    public function eliminar ($id,$idUser)
    {
	   if (empty($id)) {
		   header("Location: estatus.php");
	   }
		else {
			 
			$db = Db::getInstance();
			$data = array(
			   'eliminado' => '1',
			   'fecha_mod' => date('Y-m-d h:i:s'),
               'user_mod' => $idUser,
		);
    	
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		   
		
	   }
		
    }


    public function activar ($id,$idUser)
    {
	   if (empty($id)) {
		   header("Location: estatus.php");
	   }
		else {
			 
			$db = Db::getInstance();
			$data = array(
			   'eliminado' => '0',
			   'fecha_mod' => date('Y-m-d h:i:s'),
               'user_mod' => $idUser,
		);
    	
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		   
		
	   }
		
    }

	
	
	
		
}
