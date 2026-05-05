<?php    /*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
        $tipoGrupoUser = "";
        $clubUsusario= "";

        $idTipoGrupoUser = "";
        $idClubUser= "";
        $idRolUser= "";
        $idRolUserSubmenu= ""; //die();

        // echo "datosvroles";

         if ($authj->rowff['sysadmin']==1) {
           
             $tipoGrupo = "";
             $clubUsusario= "";

             $idTipoGrupoUser = "";
             $idClubUser= "";
             $idRolUser.= "";
             $idRolUserSubmenu= "";

        }else{

           

          if ($authj->rowff['nadador']==1) {
               $tipoGrupo = "1";
               $clubUsusario= $authj->rowff['club'];

               $idTipoGrupoUser = "";
               $idClubUser= $authj->rowff['club'];
               $idRolUser= "6";
               $idRolUserSubmenu.= "6,";


           }

            if ($authj->rowff['apoderado']==1) {
               $tipoGrupo = "";
               $clubUsusario= $authj->rowff['club'];

               $idTipoGrupoUser = "";
               $idClubUser= $authj->rowff['club'];
               $idRolUser= "5";
               $idRolUserSubmenu.= "5,";
           }

           if ($authj->rowff['tesorero']==1) {
               $tipoGrupo = "2";
               $clubUsusario= $authj->rowff['club'];

               $idTipoGrupoUser = "2";
               $idClubUser= $authj->rowff['club'];
               $idRolUser= "4";
               $idRolUserSubmenu.= "4,";
           }


           if ($authj->rowff['entrenador']==1) {

         
               $tipoGrupo = "1";
               $clubUsusario= $authj->rowff['club'];

               $idTipoGrupoUser = "1";
               $idClubUser= $authj->rowff['club'];
               $idRolUser.= "3";
               $idRolUserSubmenu.= "3,";
           }

           if ($authj->rowff['admin']==1) {

              $tipoGrupo = "";
              $clubUsusario= $authj->rowff['club'];

               $idTipoGrupoUser = "";
               $idClubUser= $authj->rowff['club'];
               $idRolUser.= "2";
               $idRolUserSubmenu.= "2,";


           }

           $clubid=$authj->rowff['club'];
           $club = New Club();
           $club->getOne($clubid);

        }

      $idRolUserdef=  chop($idRolUserSubmenu,",");

      $menu = New Menu();
      $tabla1=$menu->getAllMenu($idRolUserdef);


      $submenu1 = New SubMenu1();
      $submenu2 = New SubMenu2();

      


?>
