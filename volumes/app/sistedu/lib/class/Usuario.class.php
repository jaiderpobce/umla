<?php
class Usuario
{
    public $id;
    public $titulo;
    public $imagen;
    public $tabla;

    public $estado;
    public $row;

    public $pag = 1;
    public $limit = 25;
    public $orden = "";
    public $tiporden = "";
    public $total_pages;
    public $usuario;

    public $img_ppl;

    public $cnt_img_ppl;

    private $interfaz;


    public function __construct($interfaz = 0)
    {
        $this->interfaz = $interfaz;
        $this->tabla = "com_users";
    }



    public function agregar($rut, $nombre, $apellido, $email, $roles, $datosN = array())
    {
        $rut = str_replace(".", "", $rut);
        $rut_pass = explode("-", $rut);
        $pass = sha1(md5(trim($rut_pass[0])));
        if (empty($nombre) or empty($rut)) {
            header("Location: usuarios.php?err=1");
        } else {
            $elrow = $this->getOneByRutExt($rut);

            if (empty($elrow)) {
                $telf = str_replace("-", "", $datosN['telefono']);
                $telf = str_replace(" ", "", $telf);
                //$pass = uniqid();
                $db = Db::getInstance();
                $data = array(
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'email' => $email,
                    'rut' => $rut,
                    'pass' => $pass,
                    'genero' => $datosN['genero'],
                    'fecnac' => $datosN['fecnac'],
                    'direccion' => $datosN['direccion'],
                    'telefono' => $telf,
                    'nivel' => '4',
                    'nadador' => $roles['nadador'],
                    'entrenador' => $roles['entrenador'],
                    'sysadmin' => $roles['sysadmin'],
                    'tesorero' => $roles['tesorero'],
                    'apoderado' => $roles['apoderado'],
                    'admin' => $roles['admin'],
                    'fecin' => date('Y-m-d H:i:s'),
                    'notas' => $datosN['notas'],
                    'externo' => $datosN['externo'],
                    'club' => $datosN['club'],
                    'pais' => $datosN['pais'],
                    'region' => $datosN['region'],
                    'ciudad' => $datosN['ciudad']
                );
                if ($roles['nadador'] == '1') {

                    $data['colegio'] = $datosN['colegio'];
                    $data['licencia'] = $datosN['licencia'];
                    $data['grupo'] = $datosN['grupo'];
                }

                $db->insert($this->tabla, $data);
                $this->id = $db->lastInsertId();

                if ($roles['nadador'] == '1') {
                    // $this->asignarCategoria($this->id);
                }
            } else {
                header("Location: usuarios.php?err=2");
            }
            //header("Location: usuarios_up.php?id=".$this->id);
            // header("Location: usuarios.php");
        }
    }


    public function agregarPre($rut, $nombre, $apellido, $email, $roles, $datosN = array())
    {
        $rut = str_replace(".", "", $rut);
        $rut_pass = explode("-", $rut);
        $pass = sha1(md5(trim($rut_pass[0])));
        if (empty($nombre) or empty($rut)) {
            header("Location: usuarios.php?err=1");
        } else {
            $elrow = $this->getOneByRutExt($rut);

            if (empty($elrow)) {
                $telf = str_replace("-", "", $datosN['telefono']);
                $telf = str_replace(" ", "", $telf);
                //$pass = uniqid();
                $db = Db::getInstance();
                $data = array(
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'email' => $email,
                    'rut' => $rut,
                    'pass' => $pass,
                    'genero' => $datosN['genero'],
                    'fecnac' => $datosN['fecnac'],
                    'direccion' => $datosN['direccion'],
                    'telefono' => $telf,
                    'nivel' => '4',
                    'nadador' => $roles['nadador'],
                    'entrenador' => $roles['entrenador'],
                    'sysadmin' => $roles['sysadmin'],
                    'tesorero' => $roles['tesorero'],
                    'apoderado' => $roles['apoderado'],
                    'admin' => $roles['admin'],
                    'fecin' => date('Y-m-d H:i:s'),
                    'notas' => $datosN['notas'],
                    'externo' => $datosN['externo'],
                    'club' => $datosN['club'],
                    'pais' => $datosN['pais'],
                    'region' => $datosN['region'],
                    'ciudad' => $datosN['ciudad']
                );
                if ($roles['nadador'] == '1') {

                    $data['colegio'] = $datosN['colegio'];
                    $data['licencia'] = $datosN['licencia'];
                    $data['grupo'] = $datosN['grupo'];
                }

                $db->insert('com_users_preinsert', $data);
                $this->id = $db->lastInsertId();

                /*if ($roles['nadador'] == '1') {
                        $this->asignarCategoria($this->id);
                }*/
            } else {
                header("Location: usuarios.php?err=2");
            }
            //header("Location: usuarios_up.php?id=".$this->id);
            // header("Location: usuarios.php");
        }
    }



    public function modificar($id, $rut, $nombre, $apellido, $email, $roles, $datosN = array())
    {
        if (empty($id)) {
            header("Location: usuarios.php");
        } else {
            $rut = str_replace(".", "", $rut);
            $telf = str_replace("-", "", $datosN['telefono']);
            $telf = str_replace(" ", "", $telf);

            $db = Db::getInstance();
            if ($datosN['origen'] == 'misdatos') {
                $data = array(
                    'email' => $email,
                    'direccion' => $datosN['direccion'],
                    'telefono' => $telf
                );
            } else {
                if (empty($nombre) or empty($apellido) or empty($rut)) {
                    header("Location: usuarios_mod.php?id=" . $id);
                    die();
                } else {

                    $data = array(
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'email' => $email,
                        'rut' => $rut,
                        'genero' => $datosN['genero'],
                        'fecnac' => $datosN['fecnac'],
                        'direccion' => $datosN['direccion'],
                        'telefono' => $telf,
                        'entrenador' => $roles['entrenador'],
                        'sysadmin' => $roles['sysadmin'],
                        'tesorero' => $roles['tesorero'],
                        'apoderado' => $roles['apoderado'],
                        'admin' => $roles['admin'],
                        'notas' => $datosN['notas'],
                        'club' => $datosN['club']
                    );
                    if ($roles['nadador'] == '1') {
                        $data['licencia'] = $datosN['licencia'];
                        $data['grupo'] = $datosN['grupo'];
                    }
                }
            }

            if ($roles['nadador'] == '1') {

                $data['colegio'] = $datosN['colegio'];
            }

            //print_r($data);
            //$db->insert('com_proyectos', $data);

            $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

            if ($roles['nadador'] == '1') {
                //  $this->asignarCategoria($id);
            }


            //header("Location: usuarios.php");
        }
    }


    public function modificarPass()
    {
        if (empty($this->id)) {
            header("Location: usuarios.php");
        } else if (empty($this->pass)) {
            header("Location: usuarios_mod.php?id=" . $this->id);
        } else {

            $db = Db::getInstance();
            $data = array(
                'pass' => $this->pass
            );
            //$db->insert('com_proyectos', $data);

            $db->update($this->tabla, $data, 'id = :id', array(':id' => $this->id));

            header("Location: usuarios.php");
        }
    }

    public function cambiarEstado($id, $st, $idUser = '')
    {
        if (empty($id)) {
            header("Location: nadadores.php");
        } else {

            $db = Db::getInstance();
            if ($st == '1') {
                $data = array(
                    'estado' => $st,
                    'fecha_sup' => date('Y-m-d h:i:s'),
                    'user_sup' => $idUser
                );
            } else	if ($st == '0') {
                $data = array(
                    'estado' => $st,
                    'fecha_act' => date('Y-m-d h:i:s'),
                    'user_act' => $idUser
                );
            } else {
                $data = array(
                    'estado' => $st
                );
            }


            $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));

            //header("Location: usuarios.php");
        }
    }

    public function actualizarFoto($valor, $id)
    {

        $db = Db::getInstance();
        $data = array(
            'imagen' => $valor
        );


        $db->update($this->tabla, $data, 'id = :id', array(':id' => $id));
    }

    public function agregarApoderado($id, $rut)
    {
        $elrow = $this->getOneByRutExt($rut, 'nadador');
        if (!empty($elrow)) {

            $db = Null;
            $db = Db::getInstance();
            $sql = "SELECT * FROM com_apoderados WHERE apoderado = :apoderado AND nadador = :nadador LIMIT 1";
            $bind = array(
                ':apoderado' => $id,
                ':nadador' => $elrow[0]['id']
            );
            /*echo $sql."<br>";
                        print_r($bind);*/

            $cont = $db->run($sql, $bind);

            //echo "contador de apoderados /nadador:".$cont;
            if ($cont == 0) {
                $db1 = Null;
                $db1 = Db::getInstance();
                $data1 = array(
                    'apoderado' => $id,
                    'nadador' => $elrow[0]['id'],
                );


                $db1->insert('com_apoderados', $data1);
            } else {
                //echo "encontró, no hace nada";


            }
        }
    }
    public function deleteApoderado($id, $nadador)
    {
        // echo "<br>apoderado: ".$id." nadador:".$nadador;
        $db = Db::getInstance();
        $db->delete('com_apoderados', "apoderado=:id AND nadador=:nadador", array(':id' => $id, ':nadador' => $nadador));
    }


    public function getAll($paginado = 1, $tipo = 'todos', $tipoLimit = '', $externo = 0, $opciones = array(), $club = '', $isSysadmin = '')
    {

        $db = Db::getInstance();

        $sql = "SELECT " . $this->tabla . ".*,
                                    com_clubes.club AS Nclub,
																		case when  com_users.estado='1' then 'Suspendido' else 'Activo' end as estado_user
                                    FROM " . $this->tabla . "
                                    INNER JOIN com_clubes ON com_users.club = com_clubes.id ";
        if ($tipoLimit  == 'apoderado') {
            $sql .= "INNER JOIN com_apoderados ON " . $this->tabla . ".id = com_apoderados.nadador ";
            $sql .= "WHERE com_apoderados.apoderado = :apoderado";
            $bind = array(
                ':apoderado' => $this->usuario['id']
            );
        } else {
            $sql .= "WHERE " . $this->tabla . ".id > :id";
            $bind = array(
                ':id' => '0'
            );
        }

        if ($isSysadmin  == '') {
            $sql .= "  AND " . $this->tabla . ".estado=0";
        }
        //$bind[":externo"] = $externo;

        if (!empty($opciones['nombre'])) {
            $nombre = $opciones['nombre'];
            $nombre = str_replace(", ", ",", $nombre);
            $nombre = str_replace(",", " ", $nombre);
            $nombres = explode(" ", $nombre);
            $concatenador = "AND ";
            $conti = 1;

            foreach ($nombres as $word) {
                //if ($conti >1){
                $sql .= " " . $concatenador;
                //    }
                $sql .= " (nombre LIKE :nombre_" . $conti . " OR apellido LIKE :nombre_" . $conti . ")";
                $bind[":nombre_" . $conti] = "%$word%";
                $conti++;
            }
        }

        if (!empty($opciones['genero'])) {
            $sql .= " AND " . $this->tabla . ".genero = :genero";
            $bind[":genero"] = $opciones['genero'];
        }

        if (!empty($opciones['ano'])) {
            $sql .= " AND YEAR(" . $this->tabla . ".fecnac) = :ano";
            $bind[":ano"] = $opciones['ano'];
        }

        if (!empty($opciones['clublis'])) {
            $sql .= " AND " . $this->tabla . ".club = :club";
            $bind[":club"] = $opciones['clublis'];
        }

        if (!empty($club)) {
            $sql .= " AND " . $this->tabla . ".club = :club";
            $bind[":club"] = $club;
        }

        if ($tipo != 'todos' and !empty($tipo)) {
            $tipos = explode("-", $tipo);
            $countipo = count($tipos);
            $contador = 1;
            $sql .= " AND (";
            foreach ($tipos as $tipUser) {
                $sql .= $this->tabla . "." . $tipUser . " = :" . $tipUser;
                if ($contador < $countipo) {
                    $sql .= " or ";
                }
                $bind[":" . $tipUser] = '1';
                $contador++;
            }
            $sql .= ")";
        }

        if (empty($this->orden)) {
            $orden = $this->tabla . ".apellido, " . $this->tabla . ".nombre";
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
    }


    static function anoNadador($tipo)
    {
        if ($tipo == 'max') {
            $tipoOrden = " DESC";
        } else {
            $tipoOrden = "";
        }
        $db = Db::getInstance();
        $sql = "SELECT YEAR(com_users.fecnac) AS ano FROM com_users WHERE nadador = 1 ORDER BY fecnac" . $tipoOrden . " LIMIT 1";

        $cont = $db->run($sql);
        if ($cont == 0) {
            return "";
        } else {

            $db1 = Db::getInstance();
            $row_p = $db1->fetchAll($sql);
            $conty = 0;

            return $row_p[0]['ano'];
        }
    }

    public function getCoachAll()
    {

        $db = Db::getInstance();

        $sql = "SELECT * FROM " . $this->tabla . " WHERE entrenador = :id ORDER BY apellido, nombre";
        $bind = array(
            ':id' => '1'
        );






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
    }


    public function getOne($id)
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
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

    public function getGenero($id)
    {
        $db = Db::getInstance();
        $sql = "SELECT genero FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
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

            return $row_p[0]['genero'];
        }
    }

    public function getOneByRut($rut, $tipo = "")
    {
        $rut = str_replace(".", "", $rut);
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $this->tabla . " WHERE rut = :rut";
        $bind = array(
            ':rut' => $rut
        );
        if (!empty($tipo)) {
            $sql .= " AND " . $tipo . " = 1";
        }

        $sql .= " LIMIT 1";

        $cont = $db->run($sql, $bind);
        if ($cont == 0) {
            $row_p = "";
            $this->row = "";
            $this->check = 0;
        } else {

            $db1 = Db::getInstance();
            $row_p = $db1->fetchAll($sql, $bind);
            $this->check = 1;
            $this->row = $row_p;
        }
    }

    public function getOneByRutExt($rut, $tipo = "")
    {
        $rut = str_replace(".", "", $rut);

        if ($rut == '1111111-1') {
            return "";
        } else {
            $db = Db::getInstance();
            $sql = "SELECT * FROM " . $this->tabla . " WHERE rut = :rut";
            $bind = array(
                ':rut' => $rut
            );
            if (!empty($tipo)) {
                $sql .= " AND " . $tipo . " = 1";
            }

            $sql .= " LIMIT 1";

            $cont = $db->run($sql, $bind);
            if ($cont == 0) {
                $row_p = "";
                return "";
            } else {

                $db1 = Db::getInstance();
                $row_p = $db1->fetchAll($sql, $bind);
                //$this->check = 1;
                return $row_p;
            }
        }
    }

    static function getOneByName($nombres0, $concatenador, $club = 0, $genero = 0, $fecnac = 0)
    {

        if ($genero == 'M') {
            $genero = 2;
        } else if ($genero == 'F') {
            $genero = 1;
        }

        // echo "Nombre:".$nombresO."<br>";
        $nombre = str_replace(", ", ",", $nombres0);
        $nombre = str_replace(",", " ", $nombre);
        $nombres = explode(" ", $nombre);

        $bind = array(
            ':fecnac' => $fecnac,
            ':genero' => $genero,
            ':competencia' => $competencia,
            
                );

                $sql0 = "";
                $sql3 = "";


        $conti = 1;
                    foreach($nombres as $word){

                           // echo "<br>".$word."<br>";


                        if ($conti >1) {
                            $sql0.= " OR";
                            $sql3 .= " + ";
                        }

                        $sql3 .= "CASE WHEN com_users.nombre LIKE :nombre_".$conti."  THEN 1 ELSE 0 END + ";
                        $sql3 .= "CASE WHEN com_users.apellido LIKE :nombre_".$conti."  THEN 1 ELSE 0 END ";

                        $sql0 .= " (com_users.nombre LIKE :nombre_".$conti." OR com_users.apellido LIKE :nombre_".$conti.")";
                        $bind[":nombre_".$conti] = "%$word%";
                        $conti ++;

                    }

                    $sql3 .= " + CASE WHEN com_users.fecnac = :fecnac  THEN 1 ELSE 0 END ";

                    $sql3 .= " AS coincidencias ";


                    $db = Db::getInstance();
			        $sql = "SELECT com_users.*, ";

                        $sql = $sql . $sql3;
                        
                        $sql .= " FROM com_users "
                                . " WHERE (com_users.genero = :genero) AND (";


                                
                                $sql = $sql . $sql0;
				                      

                        $sql .= ") AND com_users.id > 0";

                        if ($club != 0) {
                            $sql .= " AND (com_users.club = :club)";
                            $bind[":club"] = $club;
                        }

                        if ($genero != 0) {
                            $sql .= " AND (com_users.genero = :genero)";
                            $bind[":genero"] = $genero;
                        }

                        if ($fecnac != 0) {
                            $anio = date("Y", strtotime($fecnac));
                            $sql .= " AND (YEAR(com_users.fecnac) = :anio)";
                            $bind[":anio"] = $anio;

                        }


                        $sql .= " ORDER BY coincidencias DESC";

                        




        /*
        $nombre = str_replace(", ", ",", $nombre);
        $nombre = str_replace(",", " ", $nombre);
        $nombres = explode(" ", $nombre);

        $db = Db::getInstance();
        $sql = "SELECT com_users.*, com_clubes.club AS NClub FROM com_users LEFT JOIN com_clubes ON com_clubes.id = com_users.club WHERE (com_users.nadador = :nadador) ";

        $bind = array(
            ':nadador' => 1
        );

        if ($genero != 0) {
            $sql .= " AND (com_users.genero = :genero)";
            $bind[":genero"] = $genero;
        }

        if ($club != 0) {
            $sql .= " AND (com_users.club = :club)";
            $bind[":club"] = $club;
        }

        if ($ano != 0) {

            //$sql .= " AND (YEAR(com_users.fecnac) = :ano)";
            //$bind[":ano"] = $ano;


        }


        $conti = 1;
        foreach ($nombres as $word) {


            //if ($conti >1){
            $sql .= " " . $concatenador;
            //}
            $sql .= " (com_users.nombre LIKE :nombre_" . $conti . " OR com_users.apellido LIKE :nombre_" . $conti . ")";
            $bind[":nombre_" . $conti] = "%$word%";
            $conti++;
        }

        */




       /* echo $sql;

        echo "<br><br>";
                        print_r($bind);*/
        $cont = $db->run($sql, $bind);
        if ($cont == 0) {
            $row_p = "";
            return "";
        } else {

            $db1 = Db::getInstance();
            $row_p = $db1->fetchAll($sql, $bind);
            return $row_p;
        }
    }

    static function getAllNad($externo = 0)
    {


        $db = Db::getInstance();
        $sql = "SELECT com_users.* FROM com_users WHERE com_users.nadador = :nadador AND com_users.externo=:externo ORDER BY com_users.apellido";
        $bind = array(
            ':nadador' => 1,
            ':externo' => $externo
        );


        /*echo "<br><br>";

		        echo $sql;
                        print_r($bind);*/
        $cont = $db->run($sql, $bind);
        if ($cont == 0) {
            $row_p = "";
            return "";
        } else {

            $db1 = Db::getInstance();
            $row_p = $db1->fetchAll($sql, $bind);
            return $row_p;
        }
    }

    public function checkemail($rut)
    {
        $rut = str_replace(".", "", $rut);
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $this->tabla . " WHERE rut = :rut LIMIT 1";
        $bind = array(
            ':rut' => $rut
        );

        $cont = $db->run($sql, $bind);
        if ($cont == 0) {
            return "true";
        } else {
            return "false";
        }
    }

    public function getInfo($user)
    {
        $sqlm = "SELECT EXTRACT(YEAR FROM fecnac) AS anonac FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
        $bindm = array(
            ':id' => $user
        );

        /* echo $sqlm;
                        print_r($bindm);*/

        $db2 = Null;
        $db2 = Db::getInstance();

        $cont = $db2->run($sqlm, $bindm);

        if ($cont == 0) {

            return "";
        } else {
            $db1 = Null;
            $db1 = Db::getInstance();
            $rowff1 = $db1->fetchAll($sqlm, $bindm);
            $anonac = $rowff1[0]['anonac'];
            $edad = date('Y') - $anonac;
            // echo $user." - ".$edad."<br>";

            $categ = new Categoria();
            $categ->asignarCategoria($user, $edad);
        }
    }

    public function getRepresentados($id)
    {

        $db = Db::getInstance();

        $sql = "SELECT " . $this->tabla . ".*
                FROM " . $this->tabla . " ";
        $sql .= "INNER JOIN com_apoderados ON " . $this->tabla . ".id = com_apoderados.nadador ";
        $sql .= "WHERE com_apoderados.apoderado = :apoderado AND " . $this->tabla . ".estado = 0";
        $bind = array(
            ':apoderado' => $id
        );




        if (empty($this->orden)) {
            $orden = $this->tabla . ".apellido, " . $this->tabla . ".nombre";
        } else {
            $orden = $this->orden;
        }


        if ($this->tiporden == 'desc') {
            $tiporden = " desc";
        } else {
            $tiporden = "";
        }

        $sql .= " ORDER BY " . $orden . $tiporden;



        $cont = $db->run($sql, $bind);
        if ($cont == 0) {
            // echo "No encontro";
            $row_p = "";
            // $this->representados = "";
        } else {
            //echo "SI encontro";
            $db1 = Db::getInstance();
            $row_p = $db1->fetchAll($sql, $bind);
            $conty = 0;

            $this->representados = $row_p;
        }
    }

    public function puedeEditar($apoderado, $id)
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM com_apoderados WHERE apoderado = :apoderado AND nadador = :nadador LIMIT 1";
        $bind = array(
            ':apoderado' => $apoderado,
            ':nadador' => $id
        );

        $cont = $db->run($sql, $bind);
        if ($cont == 0) {
            return 0;
        } else {
            return 1;
        }
    }


    public function getPruebasRes()
    {
        $db = Db::getInstance();

        $sql = "SELECT com_pruebas.* FROM com_pruebas LEFT JOIN com_resultados ON com_pruebas.id = com_resultados.prueba";

        $primer = 0;
        foreach ($this->row as $id) {


            if ($primer == 0) {
                $sql .= "  WHERE ";
            } else {
                $sql .= "  OR ";
            }
            $sql .= "com_resultados.nadador = :nadador" . $primer;

            $bind[':nadador' . $primer] = $id['id'];
            $primer++;
        }

        $sql .= " GROUP BY com_pruebas.id ORDER BY com_pruebas.orden";


        /*echo $sql;
                                print_r($bind);*/



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
            $this->row[0]['pruebasR'] = $row_p;
        }
    }


    public function getCompetenciasRes($piscina = 0)
    {
        $db = Db::getInstance();

        $sql = "SELECT com_competencias.* FROM com_competencias LEFT JOIN com_resultados ON com_competencias.id = com_resultados.competencia";

        if ($piscina != 0) {
            $sql .= "  WHERE (com_competencias.piscina = :piscina)";
            $bind[':piscina'] = $piscina;
          
        } 

        $primer = 0;
        foreach ($this->row as $id) {
            if ($primer == 0 && $piscina == 0) {
                $sql .= "  WHERE (";
            } else if ($primer == 0 && $piscina != 0) {
                $sql .= "  AND (";
            } else {
                $sql .= "  OR ";
            }
            $sql .= "com_resultados.nadador = :nadador" . $primer;

            $bind[':nadador' . $primer] = $id['id'];
            $primer++;
        }

        if ($primer > 0) {
            $sql .= ")";

        }

        $sql .= " GROUP BY com_resultados.competencia, com_resultados.fecha ORDER BY com_resultados.fecha";

        /*echo $sql;
          print_r($bind);*/

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
            $this->row[0]['competenciasR'] = $row_p;
        }
    }




    public function getCountRepresentados($apoderado)
    {

        $db2 = Null;
        $db2 = Db::getInstance();
        $sql2 = "select  count(nadador) as count_representados
                    from com_apoderados where apoderado=:apoderado";
        $bind2 = array(
            ':apoderado' => $apoderado
        );

        $cont = $db2->run($sql2, $bind2);
        if ($cont == 0) {
            $row_p = "";
            //echo "NO encontró";
        } else {
            //echo "encontró";
            $db1 = Null;
            $db1 = Db::getInstance();
            $row_p1 = $db1->fetchAll($sql2, $bind2);

            return $row_p1[0]['count_representados'];
        }
    }


    public function getApoderadosBilletera($id)
    {

        $db = Db::getInstance();

        $sql = "SELECT " . $this->tabla . ".*,
                        com_user_billetera.id as id_billetera,
                        com_user_billetera.monto_a_favor
                FROM " . $this->tabla . "
                INNER JOIN com_apoderados ON " . $this->tabla . ".id = com_apoderados.apoderado
                INNER JOIN com_user_billetera ON com_apoderados.apoderado = com_user_billetera.user ";
        $sql .= "WHERE com_apoderados.nadador = :nadador
                         AND " . $this->tabla . ".estado = 0";
        $bind = array(
            ':nadador' => $id
        );




        if (empty($this->orden)) {
            $orden = "com_user_billetera.monto_a_favor";
        } else {
            $orden = $this->orden;
        }


        if ($this->tiporden == 'desc') {
            $tiporden = " desc";
        } else {
            $tiporden = "";
        }

        $sql .= " ORDER BY " . $orden . $tiporden;




        $cont = $db->run($sql, $bind);
        if ($cont == 0) {
            // echo "No encontro";
            $row_p = "";
            // $this->representados = "";
        } else {
            //echo "SI encontro";
            $db1 = Db::getInstance();
            $row_p = $db1->fetchAll($sql, $bind);
            $conty = 0;

            $this->apoderados = $row_p;
        }
    }



    public function getUserBilletera($id)
    {

        $db = Db::getInstance();

        $sql = "SELECT " . $this->tabla . ".*,
                        com_user_billetera.id as id_billetera,
                        com_user_billetera.monto_a_favor
                FROM " . $this->tabla . "

                LEFT OUTER JOIN com_user_billetera ON " . $this->tabla . ".id = com_user_billetera.user ";
        $sql .= "WHERE  " . $this->tabla . ".id = :id
                         AND " . $this->tabla . ".estado = 0";
        $bind = array(
            ':id' => $id
        );




        if (empty($this->orden)) {
            $orden = "com_user_billetera.monto_a_favor";
        } else {
            $orden = $this->orden;
        }


        if ($this->tiporden == 'desc') {
            $tiporden = " desc";
        } else {
            $tiporden = "";
        }

        $sql .= " ORDER BY " . $orden . $tiporden;




        $cont = $db->run($sql, $bind);
        if ($cont == 0) {
            // echo "No encontro";
            $row_p = "";
            // $this->representados = "";
        } else {
            //echo "SI encontro";
            $db1 = Db::getInstance();
            $row_p = $db1->fetchAll($sql, $bind);
            $conty = 0;

            $this->usuarios = $row_p;
        }
    }
}
