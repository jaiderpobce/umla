 <aside class="site-sidebar scrollbar-enabled" data-suppress-scroll-x="true">
    <!-- User Details -->

    <!-- /.side-user -->
    <!-- Sidebar Menu -->
    <nav class="sidebar-nav">
        <ul class="nav in side-menu">
            <li class="menu-item-has-children<?php if ($_page=='intro') { ?> current-page<?php } ?>">
                <a href="<?php echo BASE_PATH_CONTROL; ?>intro.php">
                    <i class="list-icon material-icons">home</i>
                    <span class="hide-menu">Intro</span>
                </a>
            </li>
            <?php
            //echo $idRolUser;
            foreach ($tabla1 as $Elem) {
                 $menuid=$Elem['id'];

                 if($Elem['link']!=''){
             ?>

                 <li class="menu-item-has-children<?php if ($_page==$Elem['menu']) { ?> current-page<?php } ?>">
                    <a href="<?php echo BASE_PATH_CONTROL; echo $Elem['link'];?>">
                        <i class="<?php  echo $Elem['icono'];?>"></i>
                        <span class="hide-menu"> <?php  echo $Elem['etiqueta'];?></span>
                    </a>
                 </li>

           <?php
                }else{
            ?>
              <li class="menu-item-has-children<?php if ($_menu == $Elem['menu']) { ?> active<?php } ?>">
                    <a href="javascript:void(0);">

                        <i class="<?php  echo $Elem['icono'];?>"><?php  echo $Elem['etiqueta_icono'];?></i>
                        <span class="hide-menu"><?php  echo $Elem['etiqueta'];?></span>
                    </a>
                     <ul class="list-unstyled sub-menu">
                    <?php
                     $tabla2=$submenu1->getAllSubMenu1($menuid,$idRolUserdef);
                    foreach ($tabla2 as $Elem2) {
                         $submenu1id=$Elem2['id'];
                         if($Elem2['link']!=''){
                     ?>
                        <li>
                            <a href="<?php  echo $Elem2['link'];?>">
                                <?php  echo $Elem2['etiqueta'];?>
                            </a>
                        </li>
                         <?php
                        } else {
                            ?>
                             <li class="menu-item-has-children active">
                                <a href="javascript:void(0);"><?php  echo $Elem2['etiqueta'];?></a>
                                <ul class="list-unstyled sub-menu">

                                    <?php
                                     $tabla3=$submenu2->getAllSubMenu2($menuid,$submenu1id,$idRolUserdef);
                                    foreach ($tabla3 as $Elem3) {

                                     ?>
                                        <li><a href="<?php  echo $Elem3['link'];?>">
                                            <?php  echo $Elem3['etiqueta'];?></a></li>


                                    <?php
                                    }
                                      ?>
                               </ul>
                               </li>
                        <?php
                        }
                        ?>



                    <?php
                    }
                    ?>


                     </ul>
                </li>

            <?php
                }
            }

            ?>



        </ul>
        <!-- /.side-menu -->
    </nav>
    <!-- /.sidebar-nav -->
</aside>
