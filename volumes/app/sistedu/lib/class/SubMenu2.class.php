<?php
class SubMenu2
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
       $this->tabla = "com_submenus2";

    }




	public function getAllSubMenu2 ($menu,$submenu1,$idRolUser='')
	{

				$db = Db::getInstance();

					$sql = "SELECT distinct ".$this->tabla.".*
					FROM ".$this->tabla." ";

					if (!empty($idRolUser)) {
                        $sql .= " INNER JOIN com_roles_permisos on com_roles_permisos.rol in ($idRolUser) and
                           com_roles_permisos.menu=com_submenus2.menu and
                           com_roles_permisos.submenu1=com_submenus2.submenu1 and
                           com_roles_permisos.submenu2=com_submenus2.id and
                            com_roles_permisos.eliminado='0' ";
                        $bind = array(
                            //':rol' => $idRolUser
                        );
                        $sql .= " WHERE  ".$this->tabla.".eliminado='0'";
                    }else{
						$sql .= " WHERE ".$this->tabla.".id != :id and ".$this->tabla.".eliminado='0'";
	                         $bind = array(
	                                ':id' =>0
	                            );
					   }

                   if (!empty($menu)) {
                        $sql .= " AND ".$this->tabla.".menu = :menu";
                        $bind[":menu"] = $menu;
                    }

                     if (!empty($submenu1)) {
                        $sql .= " AND ".$this->tabla.".submenu1 = :submenu1";
                        $bind[":submenu1"] = $submenu1;
                    }

					$sql .= " ORDER BY orden";


				$cont = $db->run($sql, $bind);
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






}//FIN
