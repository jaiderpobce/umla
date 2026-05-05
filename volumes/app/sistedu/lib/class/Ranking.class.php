<?php
class Ranking
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
       $this->tabla = "com_ranking";
	
    }
	
    

		
	public function agregar ($banco,$idUser)
    {
	   if (empty($banco)) {
		   header("Location: bancos.php?err=1");
	   } else {
               
            //$orden = $this->getOrden();
			 $rut = str_replace(".", "", $rut);
			$db = Db::getInstance();
			$data = array(
                          
                            'banco' => $banco,
		
 			    'fecha_cre' => date('Y-m-d h:i:s'),
                            'user_cre' => $idUser,
                        );
            $db->insert($this->tabla, $data);
			$this->id = $db->lastInsertId();
		
		
	   }
		
    }
	
	
	
	public function modificar ($id,$banco,$idUser)
    {
	   if (empty($id)) {
		   header("Location: bancos.php");
	   }
		else if (empty($banco)) {
		   header("Location: bancos_mod.php?id=".$id);
	   } else {
			 
			$db = Db::getInstance();
			$data = array(
			   
        		    'banco' => $banco,
			    
 			    'fecha_mod' => date('Y-m-d h:i:s'),
                            'user_mod' => $idUser,
		);
    	
		   $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
		   
		
	   }
		
    }

    public function eliminar ($id,$idUser)
    {
	   if (empty($id)) {
		   header("Location: bancos.php");
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

    public function getOne ($id)
	{
				$db = Db::getInstance();
				$sql = "SELECT * FROM ".$this->tabla." WHERE id = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
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


    public function getCompetenciaByEventoId($id)
        {
                $db = Db::getInstance();
				$sql = "SELECT * FROM Evento WHERE EventoId = :id";
    			$bind = array(
        		':id' => $id
    			);

              /*  echo $sql;
                print_r($bind);*/
		        
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

function getPruebas ($ranking) {

    $db2 = Null;
    $db2 = Db::getInstance();
   /* $sql2 = "SELECT Competencia.* FROM Competencia "
            . "INNER JOIN Evento ON Evento.EventoId = Competencia.EventoId "
            . "INNER JOIN com_ranking_competencias ON Evento.EventoId = com_ranking_competencias.competencia "
            . "WHERE com_ranking_competencias.ranking = :ranking AND Competencia.esRelevo = 0 GROUP BY Competencia.Sexo, Competencia.EdadMinima, Competencia.EdadMaxima, Competencia.Modalidad, Competencia.CompetenciaId ORDER BY Competencia.Sexo, Competencia.EdadMinima, Competencia.EdadMaxima, Competencia.Modalidad";
    $bind2 = array(
            ':ranking' => $ranking
    );
    */

    $sql2 = "SELECT com_pruebas.*, com_ranking_categorias.edad_desde, com_ranking_categorias.edad_hasta FROM com_pruebas "
            . "INNER JOIN com_ranking_pruebas ON com_pruebas.cod_meet = com_ranking_pruebas.prueba "
            . "INNER JOIN com_ranking_categorias ON com_ranking_categorias.ranking = com_ranking_pruebas.ranking "
            . "INNER JOIN com_ranking_competencias ON com_ranking_categorias.ranking = com_ranking_competencias.id "
            . "WHERE com_ranking_competencias.ranking = :ranking ORDER BY com_ranking_pruebas.distancia, com_ranking_pruebas.estilo";
    $bind2 = array(
            ':ranking' => $ranking
    );
    //echo $sql2;

    $cont = $db2->run($sql2, $bind2);
    if ($cont == 0) {
            $row_p = "";
            $this->row = $row_p;
    } else {
            // echo "encontró";
            $db1 = Null;
            $db1 = Db::getInstance();
            $row_p1 = $db1->fetchAll($sql2, $bind2);

            $this->row = $row_p1;
    }

}

function getRanking ($ranking, $fecha_desde, $fecha_hasta, $genero, $prueba) {

    $db2 = Null;
    $db2 = Db::getInstance();

    $sql2 = "SELECT Resultado.TiempoFinal, Competencia.*, Competidor.*, Evento.Nombre, Club.Nombre AS ClubNombre FROM Resultado "
            . "INNER JOIN Competencia ON Competencia.CompetenciaId = Resultado.CompetenciaId "
            . "INNER JOIN Competidor ON Competidor.CompetidorId = Resultado.CompetidorId "
            . "INNER JOIN Evento ON Competencia.EventoId = Evento.EventoId "
            . "INNER JOIN Club ON Competidor.ClubId = Club.ClubId "
            . "INNER JOIN com_ranking_competencias ON Evento.EventoId = com_ranking_competencias.competencia "
            . "WHERE com_ranking_competencias.ranking = :ranking AND Competencia.esRelevo = 0 AND Competencia.Modalidad = :prueba AND Competidor.FechaNacimiento < :fecha_desde AND Competidor.FechaNacimiento >= :fecha_hasta AND Competidor.Genero = :genero AND Resultado.Estado = :estado GROUP BY Resultado.ResultadoId ORDER BY Resultado.TiempoFinal";
    
            
    $bind2 = array(
            ':ranking' => $ranking,
            ':prueba' => $prueba,
            ':genero' => $genero,
            ':fecha_desde' => $fecha_desde,
            ':fecha_hasta' => $fecha_hasta,
            ':estado' => 'OK'
    );
   
    /*echo $sql2;
    print_r($bind2);*/

    $cont = $db2->run($sql2, $bind2);
    if ($cont == 0) {
            $row_p = "";
            return $row_p;
    } else {
            // echo "encontró";
            $db1 = Null;
            $db1 = Db::getInstance();
            $row_p1 = $db1->fetchAll($sql2, $bind2);

            return $row_p1;
    }

}

public function getEventoEstadAll ($ano = 0) {

    $db = Db::getInstance();
				$sql = "SELECT est_Evento.*, Evento.*, YEAR(Evento.FechaDesde) AS AnoFecha FROM est_Evento "
                . "INNER JOIN Evento ON est_Evento.EventoId = Evento.EventoId "
                . "WHERE Evento.EventoId > :id AND est_Evento.publico = 0";

    			$bind = array(
        		    ':id' => 0
    			);

                if ($ano != 0) {
                    $sql .= " AND YEAR(Evento.FechaDesde) = :ano ";
                    $bind['ano'] = $ano;                    
                }

                $sql .= " ORDER BY Evento.FechaDesde DESC";

                /*echo $sql;
                print_r($bind);*/
		        
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

 
public function getPruebasEventoAll ($evento) {

    $db = Db::getInstance();
				$sql = "SELECT est_Competencia.*, Competencia.* FROM est_Competencia "
                . "INNER JOIN Competencia ON est_Competencia.CompetenciaId = Competencia.CompetenciaId "
                . "WHERE Competencia.EventoId = :id ";

    			$bind = array(
        		    ':id' => $evento
    			);

                

                $sql .= " ORDER BY Competencia.Numero";

                /*echo $sql;
                print_r($bind);*/
		        
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

public function getClubesEventoAll ($evento) {

    $db = Db::getInstance();
				$sql = "SELECT est_Club.*, Club.* FROM est_Club "
                . "LEFT JOIN Club ON est_Club.ClubId = Club.ClubId "
                . "WHERE Club.EventoId = :id ";

    			$bind = array(
        		    ':id' => $evento
    			);

                

                $sql .= " ORDER BY Club.Nombre";

                /*echo $sql;
                print_r($bind);*/
		        
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

public function getClubesEventoOne ($evento, $club) {

    $db = Db::getInstance();
				$sql = "SELECT est_Club.*, Club.* FROM est_Club "
                . "INNER JOIN Club ON est_Club.ClubId = Club.ClubId "
                . "WHERE Club.EventoId = :id AND Club.ClubId = :club";

    			$bind = array(
        		    ':id' => $evento,
                    ':club' => $club
    			);

                

                $sql .= " ORDER BY Club.Nombre";

                /*echo $sql;
                print_r($bind);*/
		        
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


public function getEvento ($id) {

    $db = Db::getInstance();
				$sql = "SELECT * FROM Evento WHERE EventoId = :id LIMIT 1";
    			$bind = array(
        		':id' => $id
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


public function getClubes ($id) {

    $db = Db::getInstance();
				$sql = "SELECT * FROM Club WHERE EventoId = :id";
    			$bind = array(
        		':id' => $id
    			);
               /* echo $sql;
                print_r($bind);*/
		        
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

public function getCompetencias ($id) {

    $db = Db::getInstance();
				$sql = "SELECT * FROM Competencia WHERE EventoId = :id";
    			$bind = array(
        		':id' => $id
    			);

              /*  echo $sql;
                print_r($bind);*/
		        
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

public function getCompetenciasOne ($evento, $id) {

    $db = Db::getInstance();
				$sql = "SELECT Competencia.*, est_Competencia.* FROM Competencia LEFT JOIN est_Competencia ON est_Competencia.CompetenciaId = Competencia.CompetenciaId WHERE Competencia.EventoId = :evento AND Competencia.CompetenciaId = :id";
    			$bind = array(
        		':evento' => $evento,
                ':id' => $id
    			);

               /* echo $sql;
                print_r($bind);*/
		        
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


public function contarCompetidoresEvento ($evento, $genero = '', $club = '') {

    $db = Db::getInstance();
    $sql = "SELECT Competidor.*, est_Competidor.*, Club.Nombre AS NombreClub FROM Competidor "
    . "INNER JOIN Club ON Competidor.ClubId = Club.ClubId "
    . "LEFT JOIN est_Competidor ON est_Competidor.CompetidorId = Competidor.CompetidorId "
    . "WHERE Competidor.EventoId = :evento ";
    $bind = array(
    ':evento' => $evento
    );

                if (!empty($genero)) {
                    $sql .= " AND Competidor.Genero = :genero";
    			    $bind[':genero'] = $genero;

                }

                if (!empty($club)) {
                    $sql .= " AND Competidor.ClubId = :club";
    			    $bind[':club'] = $club;

                }

                $sql .= " ORDER BY Competidor.Apellidos, Competidor.Nombres";

               /* echo $sql;
                print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				//return $cont;

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

public function contarDQEvento ($evento, $club='') {

    $db = Db::getInstance();
				$sql = "SELECT Resultado.Estado, Competidor.Nombres, Competidor.Apellidos, Competencia.Modalidad, Competencia.Sexo, Competencia.EdadMinima, Competencia.EdadMaxima, Descalificacion.DqDescripcion, Club.Nombre AS NombreClub FROM Resultado "
                . "INNER JOIN Competencia ON  Competencia.CompetenciaId = Resultado.CompetenciaId "
                . "INNER JOIN Evento ON Competencia.EventoId = Evento.EventoId "
                . "INNER JOIN Competidor ON Resultado.CompetidorId = Competidor.CompetidorId "
                . "INNER JOIN Club ON Competidor.ClubId = Club.ClubId "
                . "LEFT JOIN Descalificacion ON Resultado.ResultadoId = Descalificacion.ResultadoId "
                . " WHERE Evento.EventoId = :evento AND Resultado.Estado = 'Descalificado'";

    			$bind = array(
        		':evento' => $evento
    			);

                
                if (!empty($club)) {
                    $sql .= " AND Competidor.ClubId = :club";
    			    $bind[':club'] = $club;

                }
                

                /*echo $sql;
                print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
                if ($cont == 0) {
                    $row_p = array();
					return $row_p;
					//echo "NO encontró";
				} else {
					//echo "encontró";
					
					$db1 = Db::getInstance();
					$row_p = $db1->fetchAll($sql, $bind);

                   // print_r($row_p);
				  
					return $row_p;


				}
}


public function contarPruebasNadador ($evento, $nadador) {

    $db = Db::getInstance();
				$sql = "SELECT Resultado.*, Competidor.Nombres, Competidor.Apellidos, Competencia.Numero, Competencia.Modalidad, Competencia.Sexo, Competencia.EdadMinima, Competencia.EdadMaxima, Club.Nombre AS NombreClub FROM Resultado "
                . "INNER JOIN Competencia ON  Competencia.CompetenciaId = Resultado.CompetenciaId "
                . "INNER JOIN Evento ON Competencia.EventoId = Evento.EventoId "
                . "INNER JOIN Competidor ON Resultado.CompetidorId = Competidor.CompetidorId "
                . "INNER JOIN Club ON Competidor.ClubId = Club.ClubId "
                . "LEFT JOIN Descalificacion ON Resultado.ResultadoId = Descalificacion.ResultadoId "
                . " WHERE Evento.EventoId = :evento AND Competidor.CompetidorId = :CompetidorId ORDER BY Competencia.Numero, Resultado.EsFinal";

    			$bind = array(
        		':evento' => $evento,
                ':CompetidorId' => $nadador
    			);

                
                
                

                /*echo $sql;
                print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				//return $cont;
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


public function contarPruebasUnicasNadador ($evento, $nadador) {

    $db = Db::getInstance();
				$sql = "SELECT Competencia.CompetenciaId FROM Resultado "
                . "INNER JOIN Competencia ON  Competencia.CompetenciaId = Resultado.CompetenciaId "
                . "INNER JOIN Evento ON Competencia.EventoId = Evento.EventoId "
                . "INNER JOIN Competidor ON Resultado.CompetidorId = Competidor.CompetidorId "
                . "LEFT JOIN Descalificacion ON Resultado.ResultadoId = Descalificacion.ResultadoId "
                . " WHERE Evento.EventoId = :evento AND Competidor.CompetidorId = :CompetidorId GROUP BY Competencia.CompetenciaId ORDER BY Competencia.Numero";

    			$bind = array(
        		':evento' => $evento,
                ':CompetidorId' => $nadador
    			);

                
                
                

                /*echo $sql;
                print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				//return $cont;
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


/*

public function contarMMNCClub ($evento, $club='') {

    $db = Db::getInstance();
				$sql = "SELECT ResultadoId FROM Resultado  "
                . "INNER JOIN Competencia ON  Competencia.CompetenciaId = Resultado.CompetenciaId "
                . "INNER JOIN Evento ON Competencia.EventoId = Evento.EventoId "
                . "INNER JOIN com_competencias ON com_competencias.id = Evento.competencia "
                . "INNER JOIN com_competencias_pruebas ON com_competencias.id = com_competencias_pruebas.competencia "
                . "INNER JOIN com_pruebas ON com_competencias_pruebas.prueba = com_pruebas.id AND Competencia.Modalidad = com_pruebas.cod_meet AND com_competencias_pruebas.edad_desde = Competencia.EdadMinima  AND com_competencias_pruebas.edad_hasta = Competencia.EdadMaxima AND com_competencias_pruebas.genero"
                . "INNER JOIN Competidor ON Resultado.CompetidorId = Competidor.CompetidorId "
                . " WHERE Evento.EventoId = :evento ";

    			$bind = array(
        		':evento' => $evento
    			);

                
                if (!empty($club)) {
                    $sql .= " AND Competidor.ClubId = :club";
    			    $bind[':club'] = $club;

                }
                

		        
				$cont = $db->run($sql, $bind);
				return $cont;
}

*/


public function actualizarDatosEvento ($EventoId, $datos) {
    $db = Db::getInstance();
               

                // $db->insert('com_marcas_tiemp', $data);
                //$prueba_id = $db->lastInsertId();

                $db->save('est_Evento', $datos, "EventoId=:EventoId", array('EventoId' => $EventoId));

    
} 

public function actualizarDatosEventoClub ($EventoId, $ClubId, $datos) {
    $db = Db::getInstance();
               

                // $db->insert('com_marcas_tiemp', $data);
                //$prueba_id = $db->lastInsertId();

                $db->save('est_Club', $datos, "EventoId=:EventoId AND ClubId = :ClubId", array('EventoId' => $EventoId, 'ClubId' => $ClubId));

    
} 

public function actualizarDatosCompetencia ($EventoId, $CompetenciaId, $datos) {
    $db = Db::getInstance();
               

                // $db->insert('com_marcas_tiemp', $data);
                //$prueba_id = $db->lastInsertId();

                $db->save('est_Competencia', $datos, "EventoId=:EventoId AND CompetenciaId = :CompetenciaId", array('EventoId' => $EventoId, 'CompetenciaId' => $CompetenciaId));

    
} 

public function actualizarDatosCompetidor ($EventoId, $CompetidorId, $datos) {
    $db = Db::getInstance();
               

                // $db->insert('com_marcas_tiemp', $data);
                //$prueba_id = $db->lastInsertId();

                $db->save('est_Competidor', $datos, "EventoId=:EventoId AND CompetidorId = :CompetidorId", array('EventoId' => $EventoId, 'CompetidorId' => $CompetidorId));

    
} 


public function contarPruebasEventoClub ($id,$club) {

    $db = Db::getInstance();
				$sql = "SELECT Competencia.*, Competidor.*, Resultado.* FROM Competencia "
                . "INNER JOIN Resultado ON Resultado.CompetenciaId = Competencia.CompetenciaId "
                . "INNER JOIN Competidor ON Competidor.CompetidorId = Resultado.CompetidorId "
                ." WHERE Competidor.ClubId = :club AND Competencia.EventoId = :evento GROUP BY Competidor.CompetidorId, Competencia.CompetenciaId, Resultado.ResultadoId";
    			$bind = array(
        		':evento' => $id,
                ':club' => $club,

    			);

              /*  echo $sql;
                print_r($bind);*/
		        
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

public function getMMPrueba($competencia, $cod_meet, $genero, $edad_desde, $edad_hasta, $relevo=0) {

    if ($genero == 'F') {
        $genero1 = 1;

    } else {
        $genero1 = 2;

    }

    $db = Db::getInstance();
    $sql = "SELECT com_competencias_pruebas.* FROM com_competencias_pruebas "
    . "INNER JOIN com_pruebas ON com_competencias_pruebas.prueba = com_pruebas.id "
    . " WHERE com_competencias_pruebas.edad_desde = :edad_desde AND com_competencias_pruebas.edad_hasta = :edad_hasta  AND com_pruebas.cod_meet = :cod_meet  AND com_competencias_pruebas.genero = :genero AND com_competencias_pruebas.competencia = :competencia AND com_pruebas.relevo = :relevo ";

    $bind = array(
        ':edad_desde' => $edad_desde,
        ':edad_hasta' => $edad_hasta,
        ':cod_meet' => $cod_meet,
        ':genero' => $genero1,
        ':competencia' => $competencia,
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


public function contarCompetidoresPrueba ($prueba, $final) {

                $db = Db::getInstance();
				$sql = "SELECT Resultado.*, Competidor.*, Club.Nombre AS NombreClub FROM Resultado "
                . "INNER JOIN Competencia ON Competencia.CompetenciaId = Resultado.CompetenciaId "
                . "INNER JOIN Competidor ON Competidor.CompetidorId = Resultado.CompetidorId "
                . "INNER JOIN Club ON Competidor.ClubId = Club.ClubId "
                . "WHERE Competencia.CompetenciaId = :CompetenciaId AND Resultado.EsFinal = :EsFinal AND Resultado.Estado <> 'Ausente' ORDER BY Resultado.Estado, Resultado.TiempoFinal";
    			$bind = array(
        		':CompetenciaId' => $prueba,
                ':EsFinal' => $final
    			);

               

               

               /* echo $sql;
                print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				//return $cont;
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


public function contarMMNCPrueba ($prueba, $mm, $club = 0) {

    $db = Db::getInstance();
    $sql = "SELECT Resultado.*, Competidor.Nombres AS CompNombres, Competidor.Apellidos AS CompApellidos, Competencia.CompetenciaId, Competencia.Modalidad, Competencia.Sexo, Competencia.EdadMinima, Competencia.EdadMaxima, Competencia.Numero, Club.Nombre AS NombreClub FROM Resultado "
    . "INNER JOIN Competencia ON Competencia.CompetenciaId = Resultado.CompetenciaId "
    . "INNER JOIN Competidor ON Competidor.CompetidorId = Resultado.CompetidorId "
    . "INNER JOIN Club ON Competidor.ClubId = Club.ClubId "
    . "WHERE Competencia.CompetenciaId = :CompetenciaId AND Resultado.TiempoFinal > :mm AND Resultado.Estado = 'OK' AND :mm >0";
    $bind = array(
    ':CompetenciaId' => $prueba,
    ':mm' => $mm
    );
    if ($club != 0) {
        $sql .= " AND Competidor.ClubId = :ClubId";
        $bind[':ClubId'] = $club;
    }

   

   

   /* echo $sql;
    print_r($bind);*/
    
    $cont = $db->run($sql, $bind);
    //return $cont;
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


public function contarDQPrueba ($prueba) {

    $db = Db::getInstance();
    $sql = "SELECT Resultado.Estado, Competidor.Nombres, Competidor.Apellidos, Competencia.Modalidad, Competencia.Sexo, Competencia.EdadMinima, Competencia.EdadMaxima, Descalificacion.DqDescripcion, Club.Nombre AS NombreClub  FROM Resultado "
    . "INNER JOIN Competencia ON Competencia.CompetenciaId = Resultado.CompetenciaId "
    . "INNER JOIN Competidor ON Resultado.CompetidorId = Competidor.CompetidorId "
    . "INNER JOIN Club ON Competidor.ClubId = Club.ClubId "
    . "LEFT JOIN Descalificacion ON Resultado.ResultadoId = Descalificacion.ResultadoId "
    . "WHERE Competencia.CompetenciaId = :CompetenciaId AND Resultado.Estado = :estado";
    $bind = array(
    ':CompetenciaId' => $prueba,
    ':estado' => 'Descalificado'
    );

   /* echo $sql;
    print_r($bind);*/
    
    $cont = $db->run($sql, $bind);
    //return $cont;
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

/*
static function limpiarArrayResultados ($arrayP) {

}*/

static function CalcularPromedio($arrayP) {
    $contador = 0;
    $sumatoria = 0;
    $promedio = 0;
    foreach($arrayP as $valor){
        if ($valor['Estado']=='OK' && $valor['TiempoFinal']>0) {
            $sumatoria = $sumatoria+$valor['TiempoFinal'];
            $contador++;
        }        
    }
    if ($sumatoria > 0 && $contador > 0) {
        $promedio = $sumatoria / $contador;
    }

    return round($promedio, 2);
   
}

static function CalcularMediana($arrayP) {
    $contador = 0;
    $median = 0;
    $nuevoArray = array();
    foreach($arrayP as $valor){
        if ($valor['Estado']=='OK' && $valor['TiempoFinal']>0) {
            $nuevoArray[$contador] = $valor['TiempoFinal'];
            //$sumatoria = $valor['TiempoFinal'];
            $contador++;
        }        
    }
    
    $count = count($nuevoArray);
    $middleval = floor(($count-1)/2);
    if($count % 2) {
    $median = $nuevoArray[$middleval];
    } else {
    $low = $nuevoArray[$middleval];
    $high = $nuevoArray[$middleval+1];
    $median = (($low+$high)/2);
    }
    return round($median, 2);
   
}

static function LimpiarArrayResultados($arrayP) {
    $contador = 0;
   
    $nuevoArray = array();
    foreach($arrayP as $valor){
        if ($valor['Estado']=='OK' && $valor['TiempoFinal']>0) {
            $nuevoArray[$contador] = $valor;
            //$sumatoria = $valor['TiempoFinal'];
            $contador++;
        }        
    }
    
    
    return $nuevoArray;
   
}


public function getStatsCompetidoresEvento ($evento, $genero = '', $club = '') {

    $db = Db::getInstance();
				$sql = "SELECT Competidor.*, "
                . "(SELECT COUNT(*) FROM Resultado  WHERE Resultado.CompetidorId = Competidor.CompetidorId) AS totpruebas, "
                . "(SELECT COUNT(*) FROM Resultado  WHERE Resultado.CompetidorId = Competidor.CompetidorId AND Resultado.EsFinal = 1) AS totfinales, "
                . "(SELECT COUNT(*) FROM Resultado  WHERE Resultado.CompetidorId = Competidor.CompetidorId AND Resultado.Estado = 'Descalificado') AS totdq, "
                . "(SELECT COUNT(*) FROM Resultado INNER JOIN est_Competencia ON est_Competencia.CompetenciaId = Resultado.CompetenciaId AND Resultado.TiempoFinal > est_Competencia.mm "
                . " WHERE Resultado.Estado = 'OK' AND est_Competencia.mm > 0 AND Resultado.CompetidorId = Competidor.CompetidorId) AS totmm "
                . "FROM Competidor WHERE Competidor.EventoId = :evento ";
    			$bind = array(
        		':evento' => $evento
    			); 

                if (!empty($genero)) {
                    $sql .= " AND Competidor.Genero = :genero";
    			    $bind[':genero'] = $genero;

                }

                if (!empty($club)) {
                    $sql .= " AND Competidor.ClubId = :club";
    			    $bind[':club'] = $club;

                }

                $sql .= " GROUP BY Competidor.CompetidorId ORDER BY Competidor.Apellidos, Competidor.Nombres";

               /* echo $sql;
                print_r($bind);*/
		        
				$cont = $db->run($sql, $bind);
				//return $cont;

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

// estadisticas por club 




		
}//FIN
