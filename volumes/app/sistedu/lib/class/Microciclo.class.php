<?php
class Microciclo
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


	public function __construct($interfaz = 0)
	{
		$this->interfaz = $interfaz;
		$this->tabla = "com_plan_microciclo";
	}

   
	public function getAllTable()
	{
        $db = Db::getInstance();
		$consulta = "SELECT id, nombre, descripcion,f_desde,f_hasta,id_macrociclo,vol FROM com_plan_microciclo";
        $tabladata = $db->fetchAll($consulta, $bind);
		

         return $tabladata;
	
	}
     //function add
     public function add($nombre,$descripcion,$f_desde,$f_hasta,$id_macrociclo,$vol)
	{
        $db = Db::getInstance();

		$data = array(
			'nombre' => $nombre,
			'descripcion' => $descripcion,
			'f_desde' => $f_desde,
			'f_hasta' => $f_hasta,
			'id_macrociclo' => $id_macrociclo,
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

	public function update($id,$nombre,$descripcion,$f_desde,$f_hasta,$id_macrociclo,$vol)
	{
        $db = Db::getInstance();

		$data = array(
			'nombre' => $nombre,
			'descripcion' => $descripcion,
			'f_desde' => $f_desde,
			'f_hasta' => $f_hasta,
			'id_macrociclo' => $id_macrociclo,
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


	







	


	




}
