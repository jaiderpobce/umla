<?php
class Marcas
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
       $this->tabla = "com_marcas";
       $this->tabla2 = "com_marcas_det";
       $this->tabla_temp = "com_resultados_temp";
	
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
		
    //function add
     public function add($tipo,$nombre,$piscina)
     {
         $db = Db::getInstance();
 
         $data = array(
            'tipo' => $tipo,
            'nombre' => $nombre,
            'piscina' => $piscina
      
         );

         $db->insert($this->tabla, $data);
 
         $this->id = $db->lastInsertId();
         $bind = array(
             ':id' => $this->id
         );
 
         $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
         $row_p = $db->fetchRow($sql, $bind);
         
         $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
          return $row_p ;
     
     } //end function add --------------------------------------------

     //function add_det
     public function add_det($id_marca,$genero,$piscina,$edad_desde,$edad_hasta,$prueba,$tiempo,$atleta,$fecha,$ubicacion,$ano_nac,$relevo)
     {
         $db = Db::getInstance();
 
 
         $data = array(
            'id_marca' => $id_marca,
            'genero' => $genero,
            'piscina' => $piscina,
            'edad_desde' => $edad_desde,
            'edad_hasta' => $edad_hasta,
            'prueba'=>$prueba,
            'tiempo' => $tiempo,
            'atleta' =>$atleta,
            'fecha' => $fecha,
            'ubicacion' => $ubicacion,
            'ano_nac'=>$ano_nac,
            'relevo'=>$relevo
      
         );

         $db->insert($this->tabla2, $data);
 
         $this->id = $db->lastInsertId();
         $bind = array(
             ':id' => $this->id
         );
 
         $sql = "SELECT * FROM " . $this->tabla2 . " WHERE id = :id LIMIT 1";
         $row_p = $db->fetchRow($sql, $bind);
         
         $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p ;
     
     } //end function add_det --------------------------------------------


     //function add_det2-----------------------------------------------
     public function add_det2($id_marca,$genero,$estilo,$edad_desde,$edad_hasta,$prueba,$tiempo,$atleta,$fecha,$ubicacion,$ano_nac)
     {
         $db = Db::getInstance();

        
        $tiempo=Funciones::convertiraMS($tiempo);


 
         $data = array(
            'id_marca' =>  $id_marca,
            'genero' => $genero,
            'estilo' => $estilo,
          
            
            'edad_desde' => $edad_desde,
            'edad_hasta' => $edad_hasta,
            'prueba'=>$prueba,
            'tiempo' => $tiempo,
            'atleta' =>$atleta,
            'fecha' => $fecha,
            'ubicacion' => $ubicacion,
            'ano_nac'=>$ano_nac,
            
      
         );

         $db->insert($this->tabla2, $data);
         $this->id = $db->lastInsertId();
        
         //$sql = "SELECT * FROM " . $this->tabla2 . " WHERE id = :id LIMIT 1";
         
         $sql = " SELECT a.*,b.nombre as nom_tipo,d.id AS id_det,d.id_marca,d.edad_desde,d.edad_hasta,d.genero,d.prueba,d.tiempo,d.estilo,d.atleta,d.fecha,d.ubicacion,d.ano_nac,c.nombre AS nom_prueba FROM com_marcas as a 
         INNER JOIN com_tipo_marcas as b on a.tipo =b.id
         INNER JOIN com_marcas_det as d ON a.id = d.id_marca
         INNER JOIN com_pruebas AS c ON c.id= d.prueba
         WHERE 1=1
         AND d.id= :id";

         $bind = array(
         ':id' => $this->id,
         );

         $row_p = $db->fetchRow($sql, $bind);

       

         $row_p['tiempo']=Funciones::convertiraSEG($row_p['tiempo']);
         
         $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p ;
     
     } //end function add_det2 --------------------------------------------


       


     // busqueda para editar ----------------------------------------------
        public function find_det2($id)
        {
          $db = Db::getInstance();
                   
                   $sql = " SELECT a.*,b.nombre as nom_tipo,d.id AS id_det,d.id_marca,d.edad_desde,d.edad_hasta,d.genero,d.prueba,d.tiempo,d.estilo,d.atleta,d.fecha,d.ubicacion,d.ano_nac,c.nombre AS nom_prueba FROM com_marcas as a 
                    INNER JOIN com_tipo_marcas as b on a.tipo =b.id
                    INNER JOIN com_marcas_det as d ON a.id = d.id_marca
                    INNER JOIN com_pruebas AS c ON c.id= d.prueba
                    WHERE 1=1
                    AND d.id= :id";

                    $bind = array(
                    ':id' => $id,
                    );

                    $row_p = $db->fetchRow($sql, $bind);

                

                    $row_p['tiempo']=Funciones::convertiraSEG($row_p['tiempo']);
                    
                    $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
                    return $row_p ;
         }
     // end busqueda ------------------------------------------------------

       // buscar detalle de marca-----------------------------------------
       public function fiend_det($id_marca)
       {
                 $db = Db::getInstance();
 
                 $sql = "SELECT * FROM ".$this->tabla2." WHERE id_marca = :id_marca  LIMIT 1";
    			 $bind = array(
                            'id_marca' => $id_marca,
                           
    			   );

				
		        
				$cont = $db->run($sql, $bind);
                return $cont;
         }
       // end detalle de marca--------------------------------------------
      //function get_det
     public function get_det($id_marca)
     {
         $db = Db::getInstance();
 
     
         $bind = array(
             ':id' => $id_marca
         );
 
         $sql = "SELECT * FROM " . $this->tabla2 . " WHERE id_marca = ".$id_marca ;
         $row_p2 = $db->fetchRow($sql, $bind);

         $this->rowm = $row_p2;
         //$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
        // echo 'prueba = '.  $row_p2 ['prueba']; die();
         return $row_p2 ;
     
     } //end function get_det --------------------------------------------


     	 //function update ----------------------------------------------

	public function update($id,$tipo,$nombre,$piscina)
	{
        $db = Db::getInstance();

		$data = array(
            'tipo' => $tipo,
			'nombre' => $nombre,
            'piscina' => $piscina,
		
			
		);
		$db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		
		$bind = array(
			':id' => $id
		);

	    $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
		$row_p = $db->fetchRow($sql, $bind);
		
		$row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p ;
	
	} //end function update ------------------------------------


     //function update_det ----------------------------------------------

	public function update_det($id,$id_marca,$genero,$piscina,$edad_desde,$edad_hasta,$prueba,$tiempo,$atleta,$fecha,$ubicacion,$ano_nac,$relevo)
	{
        $db = Db::getInstance();
        $data = array(
            'id_marca' => $id_marca,
            'genero' => $genero,
            'piscina' => $piscina,
            'edad_desde' => $edad_desde,
            'edad_hasta' => $edad_hasta,
            'prueba'=>$prueba,
            'tiempo' => $tiempo,
            'atleta' =>$atleta,
            'fecha' => $fecha,
            'ubicacion' => $ubicacion,
            'ano_nac'=>$ano_nac,
            'relevo'=>$relevo
      
         );
		$db->update($this->tabla2, $data, 'id = :id', array(':id' => $id));
		
		$bind = array(
			':id' => $id
		);

     

        $sql = "SELECT * FROM " . $this->tabla2 . " WHERE id = :id LIMIT 1";
        
        $row_p = $db->fetchRow($sql, $bind);
        
        $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p ;
	
	} //end function update_det ------------------------------------


   // 

      //function update_det2 ----------------------------------------------

	public function update_det2($id_det,$id_marca,$genero,$estilo,$edad_desde,$edad_hasta,$prueba,$tiempo,$atleta,$fecha,$ubicacion,$ano_nac)
	{
        $db = Db::getInstance();

        $tiempo=Funciones::convertiraMS($tiempo);
        $data = array(
            //'id_marca' => $id_marca,
            'genero' => $genero,
            
            'edad_desde' => $edad_desde,
            'edad_hasta' => $edad_hasta,
            'prueba'=>$prueba,
            'tiempo' => $tiempo,
            'atleta' =>$atleta,
            'fecha' => $fecha,
            'ubicacion' => $ubicacion,
            'ano_nac'=>$ano_nac,
           
      
         );
		$db->update($this->tabla2, $data, 'id = :id', array(':id' => $id_det));
		
		$bind = array(
			':id' => $id_det
		);

     

        $sql = " SELECT a.*,b.nombre as nom_tipo,d.id AS id_det,d.id_marca,d.edad_desde,d.edad_hasta,d.genero,d.prueba,d.tiempo,d.estilo,d.atleta,d.fecha,d.ubicacion,d.ano_nac,c.nombre AS nom_prueba FROM com_marcas as a 
         INNER JOIN com_tipo_marcas as b on a.tipo =b.id
         INNER JOIN com_marcas_det as d ON a.id = d.id_marca
         INNER JOIN com_pruebas AS c ON c.id= d.prueba
         WHERE 1=1
         AND d.id= :id";

         $bind = array(
         ':id' => $id_det,
         );

         $row_p = $db->fetchRow($sql, $bind);

       

         $row_p['tiempo']=Funciones::convertiraSEG($row_p['tiempo']);
         
         $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
         return $row_p ;
	
	} //end function update_det ------------------------------------

     //function delete -----------------------------------------
     public function actualizartiempo() {
        

        $db = Db::getInstance();
		$bind = array(
			':id' => '95'
		);
		//$consulta = "SELECT * from com_tipo_marcas";
      //  $tabladata = $db->fetchAll($consulta, $bind);

        $sql = "  SELECT * FROM com_marcas_det WHERE 1=1
              AND id < :id";

        $tabladata = $db->fetchAll($sql, $bind);
         
        //$tiempo22=Funciones::convertiraMS( $tabladata['tiempo']);
         
        foreach ($tabladata as $dato) {

            $tiempo22=Funciones::convertiraMS($dato['tiempo']);
       
            $data = array(
                'tiempo' => $tiempo22,
            
            );

         
           $db->update($this->tabla2, $data, 'id = :id', array(':id' =>$dato['id']));
         
        } 
        
        $row_p = json_encode($tiempo22, JSON_UNESCAPED_UNICODE);
        return $row_p ;

     }

	 public function delete($id)
	 {
		 $db = Db::getInstance();
 
		 $data = array(
			 ':id' => $id,
			 
			 
		 );
		 $db->delete($this->tabla, 'id = :id', array(':id' => $id));
		 $row_p='Eliminado con exito';
		 
		 $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
		  return $row_p ;
	 
	 } //end function delete -----------------------------------------

        //function delete det2-----------------------------------------

	 public function delete_det2($id)
	 {
		 $db = Db::getInstance();
 
		 $data = array(
			 ':id' => $id,
			 
			 
		 );
		 $db->delete($this->tabla2, 'id = :id', array(':id' => $id));
		 $row_p='Eliminado con exito';
		 
		 $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
		  return $row_p ;
	 
	 } //end function delete det2-----------------------------------------

	public function agregar ($tipo,$nombre)  {
            
         
		//	$tiempo0 = Funciones::convertiraMS($tiempo);
			$db = Db::getInstance();
			$data = array(
                            'tipo' => $tipo,
                            'nombre' => $nombre
                           
                      
                        );
                        $db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();
		
		//header("Location: nadadores.php?add=ok");
	
		
    }

    public function agregarAu ($nadador,$competencia,$prueba,$prueba_id,$fecha,$tiempo,$piscina,$lugar=0,$final=0,$totnadpru=0,$id_origen=0, $exh=0, $puntos=0, $ns=0,  $dq=0)  {
            
        if (empty($nadador)) {
       //header("Location: nadadores.php");
     
        }  else {
           
        //$orden = $this->getOrden();
        
        $db = Db::getInstance();
        $data = array(
                        'nadador' => $nadador,
                        'competencia' => $competencia,
                        'prueba' => $prueba,
                        'prueba_id'=> $prueba_id,
                        'fecha' => $fecha,
                        'tiempo' => $tiempo,
                        'piscina' => $piscina,
                        'lugar' => $lugar,
                        'totnadpru' => $totnadpru,
                        'final' => $final,
                        'id_origen' => $id_origen,
                        'exh' => $exh,
                        'puntos' => $puntos,
                        'dq' => $dq,
                        'ns' => $ns
                    );
                    $db->insert($this->tabla, $data);
        $this->id = $db->lastInsertId();
    
    //header("Location: nadadores.php?add=ok");
    
   }
    
}
    
    public function agregarTemp ($nadador,$competencia,$prueba,$prueba_id,$fecha,$tiempo,$piscina,$lugar=0,$final=0,$totnadpru=0,$id_origen=0)  {
            
            if (empty($nadador)) {
		   //header("Location: nadadores.php");
                return "err1";
	     
            } else if (empty($tiempo)) {
		   //header("Location: nadadores_marca.php?id=".$nadador);
                return "err2";
            } else {
               
            //$orden = $this->getOrden();
                
                $db0 = null;
		$db0 = Db::getInstance();
		     
			$sql0 = "SELECT * FROM ".$this->tabla_temp." WHERE nadador = :nadador AND competencia = :competencia AND prueba = :prueba AND prueba_id = :prueba_id LIMIT 1";
    			$bind0 = array(
                            'nadador' => $nadador,
                            'competencia' => $competencia,
                            'prueba' => $prueba,
                            'prueba_id'=> $prueba_id
    				);

				
		        
				$cont = $db0->run($sql0, $bind0);
                                $tiempo0 = Funciones::convertiraMS($tiempo);
                                //echo "cont";
                                $data = array(
                                        'nadador' => $nadador,
                                        'competencia' => $competencia,
                                        'prueba' => $prueba,
                                        'prueba_id'=> $prueba_id,
                                        'fecha' => $fecha,
                                        'tiempo' => $tiempo0,
                                        'piscina' => $piscina,
                                        'lugar' => $lugar,
                                        'totnadpru' => $totnadpru,
                                        'final' => $final,
                                        'id_origen' => $id_origen
                                    );
                                
				if ($cont == 0) {
                                    $tiempo0 = Funciones::convertiraMS($tiempo);
                                    $db = null;
                                    $db = Db::getInstance();
                                    
                                    $db->insert($this->tabla_temp, $data);
                                    //$this->id = $db->lastInsertId();
                                } else {
                                   /* $db5 = null;
					$db5 = Db::getInstance();
					$row_a5 = $db5->fetchAll($sql, $bind);
					$id_resp = $row_a5[0]['id'];*/

					$db6 = null;
					$db6 = Db::getInstance();
						
    					//$db->insert('com_alumnos_diapos', $data);
    					$db6->update($this->tabla_temp, $data, 'nadador = :nadador AND competencia = :competencia AND prueba = :prueba AND prueba_id = :prueba_id', array(':nadador' => $nadador, ':competencia' => $competencia, ':prueba' => $prueba, ':prueba_id' => $prueba_id));

                                }
			
		
		//header("Location: nadadores.php?add=ok");
                        return "ok";
		
	   }
		
    }
    
    
    static function getOneTemp ($nadador,$competencia,$prueba,$prueba_id)  {
            
           
               
            //$orden = $this->getOrden();
                
                $db0 = null;
		$db0 = Db::getInstance();
		     
			$sql0 = "SELECT * FROM com_resultados_temp WHERE nadador = :nadador AND competencia = :competencia AND prueba = :prueba AND prueba_id = :prueba_id LIMIT 1";
    			$bind0 = array(
                            'nadador' => $nadador,
                            'competencia' => $competencia,
                            'prueba' => $prueba,
                            'prueba_id'=> $prueba_id
    				);

				
		        
				$cont = $db0->run($sql0, $bind0);
                                
                                //echo "cont";
                               
                                
				if ($cont == 0) {
                                   
                                } else {
                                    $db5 = null;
					$db5 = Db::getInstance();
					$row_a5 = $db5->fetchAll($sql0, $bind0);
					return $row_a5[0];

					
                                }
			
		
		//header("Location: nadadores.php?add=ok");
                        //return "ok";
		
	   
		
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
    
    public function actTableCompeZip ($id)
    {
	   
		
			$db = Db::getInstance();
			$data = array(
                        'usado' => '1'
                        );
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('Resultado', $data, 'ResultadoId = :id', array(':id' => $id));
		   
		//header("Location: usuarios.php");
	   
		
    }

    public function actTableCompetidorZip ($id)
    {
	   
		
			$db = Db::getInstance();
			$data = array(
                        'usado' => '1'
                        );
    	//$db->insert('com_proyectos', $data);
		   
		   $db->update('Competidor', $data, 'CompetidorId = :id', array(':id' => $id));
		   
		//header("Location: usuarios.php");
	   
		
    }


    public function getAllTipo()
	{
	   
        $db = Db::getInstance();
		$bind = array(
			':id' => '0'
		);
		$consulta = "SELECT * from com_tipo_marcas";
        $tabladata = $db->fetchAll($consulta, $bind);
		
		$this->row =  $tabladata;
		//$tabladata= $this->userr['nombre'];

         return $tabladata;
	
	}

	

	
	public function getAllTable ()
	{
		      
				$db = Db::getInstance();
		     
				$sql = "SELECT a.*,b.nombre as nom_tipo FROM com_marcas as a inner join com_tipo_marcas as b on a.tipo =b.id ";
    				$bind = array(
        			':id' => ''
    				);
					
		
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
	
					$this->row = $row_p;
                    return $row_p;
				
	}


    public function getAllTable2 ($id2)
	{
		      
				$db = Db::getInstance();
		     
				$sql = " SELECT a.*,b.nombre as nom_tipo,d.id AS id_det,d.id_marca,d.edad_desde,d.edad_hasta,d.genero,d.prueba,d.tiempo,d.estilo,d.atleta,d.fecha,d.ubicacion,d.ano_nac,c.nombre AS nom_prueba FROM com_marcas as a 
                INNER JOIN com_tipo_marcas as b on a.tipo =b.id
                INNER JOIN com_marcas_det as d ON a.id = d.id_marca
                INNER JOIN com_pruebas AS c ON c.id= d.prueba
                WHERE 1=1
                AND d.id_marca = :id";
                

    				$bind = array(
        			':id' => $id2,
    				);
					
		
					//$db1 = Db::getInstance();

					$row_p = $db->fetchAll($sql, $bind);

                    foreach ($row_p as &$registro) {

                        $registro['tiempo'] = Funciones::convertiraSEG($registro['tiempo']);
                    }

                  //  $row_p['tiempo']=Funciones::convertiraSEG($row_p['tiempo']);

                   // $row_p = json_encode($row_p, JSON_UNESCAPED_UNICODE);
	
				//	$this->row = $row_p;
                    return $row_p;
				
	}

    public function getAllPases ($resultado, $nadador)
	{
		      
				$db = Db::getInstance();
		     
				$sql = "SELECT ".$this->tabla.".*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre, Parciales.Numero AS NumeroParcial, Parciales.Tiempo AS TiempoParcial FROM ".$this->tabla
                                        ." LEFT JOIN com_pruebas ON ".$this->tabla.".prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON ".$this->tabla.".competencia = com_competencias.id "
                                        ." LEFT JOIN Resultado ON Resultado.ResultadoId = ".$this->tabla.".id_origen "
                                        ." LEFT JOIN Parciales ON Resultado.ResultadoId = Parciales.ResultadoId "
                                        . "WHERE ".$this->tabla.".nadador=:id AND ".$this->tabla.".dq=0 AND ".$this->tabla.".tiempo > 0 AND  ".$this->tabla.".id = :resultado ORDER BY Parciales.Numero";
    				$bind = array(
        			':id' => $nadador,
                    ':resultado' => $resultado
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

    
        
        static function getMarcaPruNad($prueba, $nadador, $criterio, $piscina, $tipo_piscina, $tiempo_limite = 0, $invalida = 0) {
            
            if ($tiempo_limite > 0) {
                $fecha = date('Y-m-d');
                $nuevafecha = strtotime ( '-'.$tiempo_limite.' month' , strtotime ( $fecha ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                
            }
            if ($tipo_piscina == 1) {
                
            
            $db = Db::getInstance();
		     
				$sql = "SELECT com_resultados.*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM com_resultados"
                                        ." LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON com_resultados.competencia = com_competencias.id "
                                        . "WHERE com_resultados.nadador=:id AND com_resultados.prueba = :prueba AND com_resultados.piscina = :piscina AND com_resultados.dq=0 AND com_resultados.tiempo > 0";
                                
                                $bind = array(
                                    ':id' => $nadador,
                                    ':prueba' => $prueba,
                                    ':piscina' => $piscina
    				);
                                if ($invalida == 1) {
                                    $sql .= " AND com_competencias.invalida < :invalida";
                                    $bind[':invalida'] = $invalida;
                                }
                                
                                if ($criterio == 'mejor') {
                                    if ($tiempo_limite > 0) {
                                     $sql .= " AND com_resultados.fecha >= :fecha";  
                                      $bind[':fecha'] = $nuevafecha;
                                    }
                                    $sql .= " ORDER BY com_resultados.tiempo LIMIT 10";
                                } else {
                                    $sql .= " ORDER BY com_resultados.fecha DESC LIMIT 10";
                                }
                                
                                
				
				
		        
				$cont = $db->run($sql, $bind);
                                }
                                
                                if ($cont == 0) {
                                        $db = Null; 
					$db = Db::getInstance();
		     
                                        $sql = "SELECT com_resultados.*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM com_resultados"
                                                ." LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                                                ." LEFT JOIN com_competencias ON com_resultados.competencia = com_competencias.id "
                                                . "WHERE com_resultados.nadador=:id AND com_resultados.prueba = :prueba AND com_resultados.dq = 0";
                                        
                                        unset($bind);

                                        $bind = array(
                                            ':id' => $nadador,
                                            ':prueba' => $prueba
                                        );

                                        if ($invalida == 1) {
                                            $sql .= " AND com_competencias.invalida < :invalida";
                                            $bind[':invalida'] = $invalida;
                                        }
                                        
                                       if ($criterio == 'mejor') {
                                            if ($tiempo_limite > 0) {
                                             $sql .= " AND com_resultados.fecha >= :fecha";  
                                              $bind[':fecha'] = $nuevafecha;
                                            }
                                            $sql .= " ORDER BY com_resultados.tiempo LIMIT 10";
                                        } else {
                                            $sql .= " ORDER BY com_resultados.fecha DESC LIMIT 10";
                                        }
                                        
                                        




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
        
        static function getMarcaPruNadCom($prueba, $nadador, $criterio, $competencia) {
            
            
            $db = Db::getInstance();
		     
				$sql = "SELECT com_resultados_temp.*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM com_resultados_temp"
                                        ." LEFT JOIN com_pruebas ON com_resultados_temp.prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON com_resultados_temp.competencia = com_competencias.id "
                                        . "WHERE com_resultados_temp.nadador=:id AND com_resultados_temp.prueba = :prueba AND com_resultados_temp.competencia = :competencia AND com_resultados_temp.tiempo > 0";
                                
                                $bind = array(
                                    ':id' => $nadador,
                                    ':prueba' => $prueba,
                                    ':competencia' => $competencia
    				);
                                
                                    $sql .= " ORDER BY com_resultados_temp.tiempo LIMIT 5";
                               
                                
				
				
		        
				$cont = $db->run($sql, $bind);
                                
                                if ($cont == 0) {
                                        $db = Null; 
					$db = Db::getInstance();
		     
                                        
                                        
                                       
                                        return "";

                                        

				}
                                
                                
				 else {
					
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



	
        static function getMejorTiempo($prueba, $nadador, $competencia = 0, $piscina = 0, $quitar = 0, $fecha = 0, $invalidas=0,$tipofecha=0) {
            
            $db = Db::getInstance();
		     
				$sql = "SELECT com_resultados.*, com_pruebas.id AS prueba, com_pruebas.nombre AS nombre_pru, com_competencias.nombre FROM com_resultados"
                                        ." LEFT JOIN com_pruebas ON com_resultados.prueba = com_pruebas.id "
                                        ." LEFT JOIN com_competencias ON com_resultados.competencia = com_competencias.id "
                                        . "WHERE com_resultados.tiempo>0 AND com_resultados.nadador=:id AND com_resultados.prueba = :prueba";
                                if ($invalidas == 1) {
                                    $sql .= " AND com_competencias.invalida=0";
                                }
                                        
                                $bind = array(
                                    ':id' => $nadador,
                                    ':prueba' => $prueba
    				);
                                /*echo "quitar".$quitar."<br>";
                                echo "tipofecha".$tipofecha."<br>";*/
                                if ($quitar == 0) {
                                    
                                    $sql .= "  AND com_resultados.competencia = :competencia";
                                    $bind[':competencia'] =  $competencia;
                                } else if ($fecha != 0) {
                                              
                                     if ($tipofecha=='1' ) {
                                        $sql .= " AND com_resultados.fecha < :fecha AND com_resultados.competencia <> :competencia";
                                        $bind[':competencia'] =  $competencia;  
                                    } else {
                                        $sql .= " AND com_resultados.fecha >= :fecha";
                                    }
                                    
                                    $bind[':fecha'] =  $fecha;
                                } else {
                                   
                                    $fecha_actual = date("Y-m-d");//resto 1 día
                                    $fecha_tope = date("Y-m-d",strtotime($fecha_actual."- 6 months"));
                                    $sql .= " AND com_resultados.competencia <> :competencia AND com_resultados.fecha >= :fecha";
                                    $bind[':fecha'] =  $fecha_tope;
                                    $bind[':competencia'] =  $competencia;
                                    
                                }
                                
                                if ($piscina != 0) {
                                    $sql .= "  AND com_resultados.piscina = :piscina";
                                    $bind['piscina'] =  $piscina;
                                }
                                
                                                                      
                                        
                                    $sql .= " ORDER BY com_resultados.dq, com_resultados.tiempo LIMIT 1";
                                
                                
					
				/*echo $sql."<br>";
                                print_r($bind);
                                echo "<br><br>";*/
				
		        
				$cont = $db->run($sql, $bind);
                                
                                if ($cont == 0) {
                                       // echo "no encontro nada";

				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 $conty = 0;
				   foreach($row_p as $row_p1) {
					  $conty++;				
					}
                                       // print_r($row_p);
					return $row_p;
				}
            
            
            
        }
        static function getGanadorPrueba($id_origen) {
            
            $db = Db::getInstance();
		     
				$sql = "SELECT sys_Competidor.EventoId FROM sys_Competidor "
                                        . "WHERE sys_Competidor.CompetidorId=:id_origen";
                             
                                    $sql .= " LIMIT 1";
                                
                                
                                $bind = array(
                                    ':id_origen' => $id_origen
    				);
					
				
				
		        
				$cont = $db->run($sql, $bind);
                                
                                if ($cont == 0) {
                                        

				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 
                                        $sql3 = "SELECT sys_Competidor.TiempoFinal FROM sys_Competidor "
                                        . "WHERE sys_Competidor.EventoId=:id_evento AND Posicion = 1";
                             
                                        $sql3 .= " LIMIT 1";


                                        $bind3 = array(
                                            ':id_evento' => $row_p[0]['EventoId']
                                        );




                                        $cont3 = $db->run($sql3, $bind3);

                                        if ($cont3 == 0) {


                                        } else {

                                                $db13 = Db::getInstance();
                                                $row_p3 = $db13->fetchAll($sql3, $bind3);
                                           

                                                return $row_p3[0]['TiempoFinal'];
                                        }
					//return $row_p;
				}
            
            
        }
        
        static function getGanadorPruebaZip($id_origen) {
            
            $db = Db::getInstance();
		     
				$sql = "SELECT Competencia.CompetenciaId FROM Competencia "
                                         ." LEFT JOIN Resultado ON Resultado.CompetenciaId = Competencia.CompetenciaId "
                                        . "WHERE Resultado.ResultadoId=:id_origen";
                             
                                    $sql .= " LIMIT 1";
                                
                                
                                $bind = array(
                                    ':id_origen' => $id_origen
    				);
					
				
				/*echo $sql;
                                print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
                                
                                if ($cont == 0) {
                                        

				} else {
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);
					 
                                        $sql3 = "SELECT Resultado.TiempoFinal FROM Resultado "
                                        . "WHERE Resultado.CompetenciaId=:id_evento AND Resultado.Posicion = 1";
                             
                                        $sql3 .= " LIMIT 1";


                                        $bind3 = array(
                                            ':id_evento' => $row_p[0]['CompetenciaId']
                                        );




                                        $cont3 = $db->run($sql3, $bind3);

                                        if ($cont3 == 0) {


                                        } else {

                                                $db13 = Db::getInstance();
                                                $row_p3 = $db13->fetchAll($sql3, $bind3);
                                           

                                                return $row_p3[0]['TiempoFinal'];
                                        }
					//return $row_p;
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