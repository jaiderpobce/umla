<?php

 		$authj = new Authorizacion();
               // echo "cookie: ".$_COOKIE["admin_idm"];
                $authj->login = $_COOKIE["admin_idm"];
                $authj->clave = $_COOKIE["clave"];
		$authj->auth();
               // $authj->rowff['id']; die(); 