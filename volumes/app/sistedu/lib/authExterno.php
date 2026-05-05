<?php

 		$authj = new Authorizacion();
               // echo "cookie: ".$_COOKIE["admin_idm"];
                $authj->loginN = $_COOKIE["admin_idg"];
                $authj->claveN = $_COOKIE["claveN"];
		        $authj->authExterno();