<?php
class Notas
{
	public $id;
	public $titulo;
	public $imagen;
	public $tabla;
    public $tabla2;

	public $estado;
	public $row;
    public $rowm;

	public $pag = 1;
	public $limit = 1000;
	public $orden = "";
	public $tiporden = "";
	public $total_pages;
	
	public $img_ppl;
	
	public $cnt_img_ppl;
	
	private $interfaz;


    public function __construct($interfaz=0)
    {
       $this->interfaz = $interfaz;
       $this->tabla = "calificaciones_old";
      // $this->tabla2 = "com_marcas_det";
       $this->tabla_temp = "com_resultados_temp";
	
    }
	

	
	public function getAllTable ( $paginado = 1,$id,$admin,$opciones = array())
	{
		      
				$db = Db::getInstance();
		        
                if($admin==1)
				{
					$sql = "SELECT a.* FROM ".$this->tabla."  as a  where 1=1";

				}else
				{
					$sql = "SELECT a.* FROM ".$this->tabla." as a  where a.id_estudiante = :id";
					$bind = array(
						':id' => $id
						);
				}
				
				if (!empty($opciones['matricula'])) {
					$sql .= " AND " . "a.matricula = :matricula";
					$bind[":matricula"] = $opciones['matricula'];
				}
				if (!empty($opciones['email'])) {
					$sql .= " AND " . "a.email = :email";
					$bind[":email"] = $opciones['email'];
				}
				
			

				

				/*	if (!empty($opciones['matricula'])) {
						$sql .= " and matricula ='". $opciones['matricula']."'";
						$bind[":matricula"] = $opciones['matricula'];
					}*/
					
					if (empty($this->orden)) {
						$orden = "a.Matricula, " . "a .nombre";
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
						$total_pages = ceil($total_results / $this->limit);
						$this->total_pages = $total_pages;
			
			
						$starting_limit = ($this->pag - 1) * $this->limit;
			
			
			
						$sql .= " ORDER BY " . $orden . $tiporden . " LIMIT " . $starting_limit . "," . $this->limit;
					} else {
						$sql .= " ORDER BY " . $orden . $tiporden;
					}

               //      echo $sql; die();
					$cont = $db->run($sql, $bind);
					
					if ($cont == 0) {
						$row_p = "";
					} else {
			
						$db1 = Db::getInstance();
						$row_p = $db1->fetchAll($sql, $bind);
						$conty = 0;
						foreach ($row_p as $row_p1) {
							$conty++;
						}
						$this->row = $row_p;
					}


				//	$db1 = Db::getInstance();
				//	$row_p = $db1->fetchAll($sql, $bind);
	
				//	$this->row = $row_p;
                    return $row_p;
				
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

//

		public function getDatos_nota($id)
			{
						$db = Db::getInstance();
						$sql = "SELECT * FROM ".$this->tabla." WHERE id = :id ";
						
						$bind = array(
						':id' => $id
						);
						
					
							//echo "encontró";
							
							
							$row_p = $db->fetchRow($sql, $bind);

							$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
						
							//$this->row = $row_p;
							return $row_p;
				
						
			}

        
        
	 //function update ----------------------------------------------

	public function update_registro($id_nota,$email,$matricula,$nombre,$apaterno,$amaterno,$periodo,$tetramestre,$nivel,$asignatura,$calificacion,$catedratico)
	{
        $db = Db::getInstance();

		$data = array(
            'email' => $email,
			'matricula' => $matricula,
			'nombre' => $nombre,
			'apaterno' => $apaterno,
			'amaterno' => $amaterno,
			'periodo' => $periodo,
			'tetramestre' => $tetramestre,
			'nivel' => $nivel,
			'asignatura' => $asignatura,
			'calificacionfinal' => $calificacion,
			'catedratico' => $catedratico,
			
		);
		$db->update('calificaciones_old', $data, 'id = :id', array(':id' => $id_nota));
	//	$db->update('com_plan_asistencia',$data, 'id = :id', array(':id' => $id));
		
		$bind = array(
			':id' => $id_nota
		);

	    $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id ";
		$row_p = $db->fetchRow($sql, $bind);
		
		$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p ;
	
	} //end function update ------------------------------------
	
	   //function add
	   public function add($email,$matricula,$nombre,$apaterno,$amaterno,$periodo,$tetramestre,$nivel,$asignatura,$calificacion,$catedratico)
	   {
		   $db = Db::getInstance();

		   $marcatemporal = date('Y-m-d h:i:s');

		   $sql = " SELECT c.* FROM com_usuario c WHERE c.email = :email ";
		   $bind = array(
			   ':email' => $email,
			 
		   );
		  

		

		   $cont = $db->run($sql, $bind);

		   if ($cont > 0) {

			$row_p = $db->fetchRow($sql, $bind);
			$id_estudiante = $row_p['id'];
             

		   } else {
			$data = array(
				'nombre' => $nombre,
				'apellido' => $apaterno.' '.$amaterno,
				'email' => $email,
				'rut' => $email,
				'pass' => sha1(md5(trim($matricula))),
				'clave' => $matricula,
				'estudiante' => '1',
				
			);
			$db->insert('com_usuario', $data);
   
			$this->id = $db->lastInsertId();
			$bind = array(
				':id' => $this->id
			);

			$id_estudiante = $this->id;
		
		   };

   
		   $data = array(
			
			'marcatemporal' => $marcatemporal,
            'email' => $email,
			'matricula' => $matricula,
			'nombre' => $nombre,
			'apaterno' => $apaterno,
			'amaterno' => $amaterno,
			'periodo' => $periodo,
			'tetramestre' => $tetramestre,
			'nivel' => $nivel,
			'asignatura' => $asignatura,
			'calificacionfinal' => $calificacion,
			'catedratico' => $catedratico,
			'id_estudiante'=>$id_estudiante,
		     );
		   $db->insert('calificaciones_old', $data);
   
		   $this->id = $db->lastInsertId();
		   $bind = array(
			   ':id' => $this->id
		   );
   
		   $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
		   $row_p = $db->fetchRow($sql, $bind);
		   
		   $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
			return $row_p ;
	   
	   } //end function add --------------------------------------------

	   public function delete($id)
	   {
		   $db = Db::getInstance();
   
		
		   $db->delete($this->tabla,'id = :id', array(':id' => $id));
		   $row_p='Eliminado con exito';
		   
		   $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
			return $row_p ;
	   
	   } 
	public function getDatos_notas_excel($id_user, $admin)
	{
		      
				//$db = Db::getInstance();
		     
				//$db = Db::getInstance();
		        
                if($admin==1)
				{
					$sql = "SELECT a.* FROM ".$this->tabla."  as a  order by a.matricula desc ";
				}else
				{
					$sql = "SELECT a.* FROM ".$this->tabla." as a  where a.id_estudiante = :id order by a.matricula desc";
				}
				
    				$bind = array(
        			':id' => $id_user,
                    
    				);
					
				
			
		        
			
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
                    $this->row = $row_p;
                   // $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);

                  //  return $row_p;
				
				 
				
	}
		
}