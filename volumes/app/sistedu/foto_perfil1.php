<?php    /*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

        require_once 'lib/autoloader.class.php';
	require_once 'lib/init.class.php';
        

	require_once 'lib/auth.php';
        
        
        
        if (!empty($authj->rowff['imagen'])) { ?>
                <img src="<?php $baseUrl?>uploads/p_perfil_<?php echo $authj->rowff['id'];?>_<?php echo $authj->rowff['imagen'];?>.jpg" class="rounded-circle" alt="User Wall">
                <?php } else { ?>
                <img src="assets/demo/users/fotoperfil.jpg" class="rounded-circle" alt="dfgdg"  title="dfsd">
      <?php
                    
                }
 


        ?>