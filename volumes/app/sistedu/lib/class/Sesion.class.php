<?php
class Sesion
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
    public $userr = array();

	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_plan_sesion";
		
	}

   
	public function getAllTable($id)
	{
	   
        $db = Db::getInstance();

		$bind = array(
			':id' => $id,
		);
		$consulta = "SELECT a.id,a.id_tsesion,a.fecha, a.nombre, a.descripcion,a.id_mc,a.id_entrenador,a.vol,b.nombre  AS nombre_en, c.nombre as nombre_tipo,c.id as id_tipo
		              FROM com_plan_sesion as a
					  inner join com_users b ON b.id= a.id_entrenador 
					  INNER JOIN com_plan_tiposesion AS c ON a.id_tsesion=c.id 
					  AND b.id =:id
					  ORDER BY c.nombre";
        $tabladata = $db->fetchAll($consulta, $bind);
		
		//$tabladata= $this->userr['nombre'];

         return $tabladata;
	
	}
	public function getAllTipo()
	{
	   
        $db = Db::getInstance();
		$bind = array(
			':id' => '0'
		);
		$consulta = "SELECT * from com_plan_tiposesion";
        $tabladata = $db->fetchAll($consulta, $bind);
		
		$this->row =  $tabladata;
		//$tabladata= $this->userr['nombre'];

         return $tabladata;
	
	}

	public function getAsistencias($id)
	{
	   
        $db = Db::getInstance();
		$bind = array(
			':id' => $id
		);
		$consulta = "	SELECT a.id,b.nombre,b.apellido FROM com_plan_asistencia AS a
		                INNER JOIN com_users AS b ON a.id_atleta=b.id
		                WHERE 1=1
		                AND id_sesion= :id
						ORDER BY b.apellido";
		$consulta = "SELECT a.id,b.nombre,b.apellido,a.asistencia FROM com_plan_asistencia AS a
			INNER JOIN com_plan_sesion_grupo AS d ON d.id=a.id_sesion
			INNER JOIN com_users AS b ON a.id_atleta=b.id
			WHERE 1=1
			AND d.id_sesion=:id
			ORDER BY b.apellido";
						
        $row_p = $db->fetchAll($consulta, $bind);
		
		$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);

         return $row_p;
	
	}
	public function getAsistenciasR($id)
	{
	   
        $db = Db::getInstance();
		$bind = array(
			':id' => $id,
		);
		
		$consulta = "SELECT a.rut ,a.nombre, e.grupo ,e.id , 
		SUM( CASE WHEN b.asistencia = 'Y' THEN 1 ELSE 0 END) AS asistencias , 
		SUM( CASE WHEN b.asistencia = 'N' THEN 1 ELSE 0 END) AS inasistencias, 
		SUM( CASE WHEN b.asistencia = 'J' THEN 1 ELSE 0 END) AS justificado ,
		COUNT(*) AS total_registros, 
		SUM( CASE WHEN b.asistencia = 'Y' THEN d.vol ELSE 0 END) AS metroscumplidos , 
		SUM( CASE WHEN b.asistencia != 'Y' THEN d.vol ELSE 0 END) AS metrosfaltantes ,
		SUM(d.vol) AS metrostotal
		FROM   com_users AS a 
	    INNER JOIN  com_plan_asistencia AS b ON a.id =b.id_atleta
	    INNER JOIN com_plan_sesion_grupo AS c ON c.id=b.id_sesion
	    INNER JOIN com_plan_sesion AS d ON d.id= c.id_sesion
	    INNER JOIN com_grupos AS e ON e.id=c.id_grupo 
	    WHERE 1=1
	    
		AND d.id_entrenador=:id
	    GROUP BY a.id";
						
        $row_p = $db->fetchAll($consulta, $bind);
		
		//$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);

         return $row_p;
	
	}
	public function getAsistenciasRD($id,$fechadesde,$fechahasta)
	{
	   
        $db = Db::getInstance();
		$bind = array(
			':id' => $id,
			':fechadesde' => $fechadesde,
			':fechahasta' => $fechahasta,
		);
		
		$consulta = "SELECT a.rut ,a.nombre, e.grupo ,e.id , 
		SUM( CASE WHEN b.asistencia = 'Y' THEN 1 ELSE 0 END) AS asistencias , 
		SUM( CASE WHEN b.asistencia = 'N' THEN 1 ELSE 0 END) AS inasistencias, 
		SUM( CASE WHEN b.asistencia = 'J' THEN 1 ELSE 0 END) AS justificado ,
		COUNT(*) AS total_registros, 
		SUM( CASE WHEN b.asistencia = 'Y' THEN d.vol ELSE 0 END) AS metroscumplidos , 
		SUM( CASE WHEN b.asistencia != 'Y' THEN d.vol ELSE 0 END) AS metrosfaltantes ,
		SUM(d.vol) AS metrostotal
		FROM   com_users AS a 
	    INNER JOIN  com_plan_asistencia AS b ON a.id =b.id_atleta
	    INNER JOIN com_plan_sesion_grupo AS c ON c.id=b.id_sesion
	    INNER JOIN com_plan_sesion AS d ON d.id= c.id_sesion
	    INNER JOIN com_grupos AS e ON e.id=c.id_grupo 
	    WHERE 1=1
	    AND d.fecha BETWEEN :fechadesde AND :fechahasta
		AND d.id_entrenador=:id
	    GROUP BY a.id";
						
        $row_p = $db->fetchAll($consulta, $bind);
		
		//$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);

         return $row_p;
	
	}
	public function getAsistio($id,$valor)
	{
	   
        $db = Db::getInstance();
		
		$data = array(
			'asistencia' => $valor,
			
			
		);
       $db->update('com_plan_asistencia',$data, 'id = :id', array(':id' => $id));
						
       // $row_p = $db->fetchAll($consulta, $bind);
		
		//$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
		$row_p='update con exito';
		$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p;
	
	}

	public function getSesionG($id)
	{
		$db = Db::getInstance();
		$sql = "SELECT a.grupo,a.entrenador,a.tipo_grupo,b.id AS id_sg,b.id_sesion AS id_sesion,b.id_grupo AS id_grupo  FROM com_grupos a INNER JOIN com_plan_sesion_grupo b ON a.id = b.id_grupo
		         INNER JOIN com_plan_sesion c on b.id_sesion = c.id
		         WHERE c.id = :id  ORDER BY a.grupo";

$sql = "SELECT a.grupo,a.entrenador,a.tipo_grupo,b.id AS id_sg,b.id_sesion AS id_sesion,b.id_grupo AS id_grupo ,d.nombre as nom_ent,e.tipo_grupo as nom_tg
FROM com_grupos a INNER JOIN com_plan_sesion_grupo b ON a.id = b.id_grupo
				INNER JOIN com_plan_sesion c on b.id_sesion = c.id
				INNER JOIN com_users AS d ON a.entrenador= d.id
				INNER JOIN com_tipo_grupo AS e ON a.tipo_grupo = e.id
				WHERE c.id = :id   ORDER BY a.grupo";
						$bind = array(
							':id' => $id
						);
		$row_p = $db->fetchAll($sql, $bind);
		
		$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
		return $row_p ;
	
	}
       //function getGS funcion que asigna un grupo a sesion-----------
	   public function getGS($id_grupo,$id_sesion)
	   {
		  $infodata=array();
		   $db = Db::getInstance();

           $existe= $this->getBuscarGS($id_grupo,$id_sesion);
           $infodata['existe']=$existe;
		 if ($existe == 0) {
			
		 
		   $data = array(
			   'id_sesion' => $id_sesion,
			   'id_grupo' => $id_grupo,
			   'status' => '1',
			 
			   
		   );
		   $db->insert('com_plan_sesion_grupo', $data);
   
		   $this->id = $db->lastInsertId();
		   $bind = array(
			   ':id' => $this->id
		   );
   
		   $sql = "SELECT * FROM com_plan_sesion_grupo WHERE id = :id LIMIT 1";
		   $row_p = $db->fetchAll($sql, $bind);
		   $infodata['rows'] = $row_p;
		   
		} else {
		          
			$infodata['rows'] = '';
		}
		$row_p = json_encode($infodata, JSON_UNESCAPED_UNICODE);
			return $row_p ;
	   
	   } //end function getGS  --------------------------------------------

	   //function getBuscarGS funcion que asigna un grupo a sesion-----------
	   public function getBuscarGS($id_grupo,$id_sesion)
	   {
		   $db = Db::getInstance();
           $sql = "SELECT * FROM com_plan_sesion_grupo WHERE id_sesion = $id_sesion and id_grupo = $id_grupo ";
		   $data = array(
			   ':id_sesion' => $id_sesion,
			   ':id_grupo' => $id_grupo,
			 
		   );
		   $sql .= " LIMIT 1";

		

		   $cont = $db->run($sql, $bind);
		  // if ($cont == 0) {
			//$row_p = "0";
		   //} else {
			//$row_p = "1";
		  // };

		  
		   
		   //$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
			return $cont ;
	   
	   } //end function getBuscarGS  --------------------------------------------


     //function add
     public function add($id_tsesion,$nombre,$descripcion,$fecha,$id_entrenador,$id_macrociclo,$vol)
	{
        $db = Db::getInstance();

		$data = array(
            'id_tsesion' => $id_tsesion,
			'nombre' => $nombre,
			'descripcion' => $descripcion,
			'fecha' => $fecha,
			'id_entrenador' => $id_entrenador,
			'id_mc' => $id_macrociclo,
			'vol' => $vol,
			
		);
		$db->insert($this->tabla, $data);

		$this->id = $db->lastInsertId();
        $bind = array(
			':id' => $this->id
		);

	    $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
		$row_p = $db->fetchAll($sql, $bind);
		
		$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p ;
	
	} //end function add --------------------------------------------

	 //function update ----------------------------------------------

	public function update($id,$id_tsesion,$nombre,$descripcion,$fecha,$id_entrenador,$id_macrociclo,$vol)
	{
        $db = Db::getInstance();

		$data = array(
            'id_tsesion' => $id_tsesion,
			'nombre' => $nombre,
			'descripcion' => $descripcion,
			'fecha' => $fecha,
			'id_entrenador' => $id_entrenador,
			'id_mc' => $id_macrociclo,
			'vol' => $vol,
			
		);
		$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		
		$bind = array(
			':id' => $id
		);

	    $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
		$row_p = $db->fetchAll($sql, $bind);
		
		$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p ;
	
	} //end function update ------------------------------------

	 //function delete -----------------------------------------

	 public function delete($id)
	 {
		 $db = Db::getInstance();
 
		 $data = array(
			 'id' => $id,
			 
			 
		 );
		 $db->delete($this->tabla, $data, 'id = :id', array(':id' => $id));
		 $row_p='Eliminado con exito';
		 
		 $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
		  return $row_p ;
	 
	 } //end function delete -----------------------------------------
	  //function delete_gs -----------------------------------------
	  
	  public function delete_gs($id)
	  {
		  $db = Db::getInstance();
  
		  $data = array(
			  'id' => $id,
			  
			  
		  );
		  $db->delete('com_plan_sesion_grupo', $data, 'id = :id', array(':id' => $id));
		  $row_p='Eliminado con exito';
		  
		  $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
		   return $row_p ;
	  
	  } //end function delete_gs -----------------------------------------


	







	


	




}
