        <aside class="site-sidebar scrollbar-enabled" data-suppress-scroll-x="true">
            <!-- User Details -->
          
            <!-- /.side-user -->
            <!-- Sidebar Menu -->
            <nav class="sidebar-nav">
                <ul class="nav in side-menu">
                    <li class="menu-item-has-children<?php if ($_page=='intro') { ?> current-page<?php } ?>"><a href="<?php echo BASE_PATH_CONTROL; ?>intro.php"><i class="list-icon material-icons">home</i> <span class="hide-menu">Intro</span></a>
                        
                    </li>
                    <li class="menu-item-has-children<?php if ($_menu == 'nadadores') { ?> active<?php } ?>"><a href="javascript:void(0);"><i class="list-icon fas fa-swimmer"></i> <span class="hide-menu"> Nadadores <!--<span class="badge bg-primary">6</span>--></span></a>
                        <ul class="list-unstyled sub-menu">
                            <?php if ($authj->rowff['admin'] == 1 || $authj->rowff['entrenador'] == 1 || $authj->rowff['sysadmin'] == 1) { ?>
                            <li><a href="nadadores_add.php">Agregar Nadador</a>
                            </li>
                            <li><a href="nadadores.php">Ver Nadadores</a></li>
                            <!--<li><a href="nadadores_reportes.php">Reportes</a></li>-->
                            <?php } ?>
                            <?php if ($authj->rowff['sysadmin'] == 1) { ?>
                            <li><a href="nadadores_add_o.php">Agr Nadador Otra asociacion</a>
                            </li>
                            <li><a href="nadadores_o.php">Nadadores otras asociaciones</a></li>
                            <?php } ?>  
                            <?php if ($authj->rowff['apoderado'] == 1) { ?>
                            <li><a href="misnadadores.php">Ver Mis Nadadores</a></li>
                            <?php }?>
                            
                        </ul>
                    </li>
                    <li class="menu-item-has-children<?php if ($_menu == 'competencias') { ?> active<?php } ?>"><a href="javascript:void(0);"><i class="list-icon fas fa-medal"></i> <span class="hide-menu">Competencias</span></a>
                        <ul class="list-unstyled sub-menu">
                            <?php if ($authj->rowff['admin'] == 1 || $authj->rowff['entrenador'] == 1 || $authj->rowff['admin'] == 1 || $authj->rowff['sysadmin'] == 1) { ?>
                            <li><a href="competencias_add.php">Agregar Competencia</a>
                            </li>
                            <?php } ?>
                            <li><a href="competencias.php">Ver Competencias</a></li>
                            <?php if ($authj->rowff['admin'] == 1 || $authj->rowff['entrenador'] == 1 || $authj->rowff['admin'] == 1 || $authj->rowff['sysadmin'] == 1) { ?>
                            <li><a href="competencias_reportes.php">Reportes</a></li>
                            
                            <?php } ?>
                            
                        </ul>
                    </li>



                    <li class="menu-item-has-children<?php if ($_menu == 'vldz') { ?> active<?php } ?>"><a href="javascript:void(0);"><i class="list-icon fas fa-toolbox"></i> <span class="hide-menu">Ayudante Valdés</span></a>
                        <ul class="list-unstyled sub-menu">
                            <?php if ($authj->rowff['admin'] == 1 || $authj->rowff['entrenador'] == 1 || $authj->rowff['admin'] == 1 || $authj->rowff['sysadmin'] == 1) { ?>
                            <li><a href="vldz_alemana.php">Tabla Alemana</a></li>
                            <li><a href="vldz_pronostico.php">Pronóstico</a></li>
                            <li><a href="vldz_ritmo.php">Ritmos Lactacido</a></li>
                            <li><a href="vldz_tmps.php">Convertidor de tiempos</a></li>
                            <?php } ?>
                        </ul>
                    </li>



                     <?php if ($authj->rowff['admin'] == 1 || $authj->rowff['entrenador'] == 1 || $authj->rowff['admin'] == 1 || $authj->rowff['sysadmin'] == 1) { ?>
                    
                    <li class="menu-item-has-children<?php if ($_page=='simulador') { ?> current-page<?php } ?>"><a href="<?php echo BASE_PATH_CONTROL; ?>simulador.php"><i class="list-icon fas fa-binoculars"></i> <span class="hide-menu">Simulador</span></a></li>     
                         
                         <?php } ?>

                 <?php if ($authj->rowff['apoderado'] == 1 || $authj->rowff['tesorero'] == 1 || $authj->rowff['admin'] == 1 || $authj->rowff['sysadmin'] == 1) { ?>
                      <li class="menu-item-has-children<?php if ($_menu == 'tesoreria') { ?> active<?php } ?>"><a href="javascript:void(0);"><i class="list-icon fas fa-dollar-sign"></i> <span class="hide-menu"> Tesoreria </span></a>
                    <ul class="list-unstyled sub-menu">
                   <?php if ($authj->rowff['admin'] == 1 || $authj->rowff['tesorero'] == 1 ||  $authj->rowff['sysadmin'] == 1) { ?>
                 
                    <li><a href="tesoreria_cuotas.php">Cuotas</a></li>
                    <li><a href="tesoreria_cuotas_resumen.php">Resumen</a></li>
                     <li><a href="tesoreria_pagos.php">Pagos</a></li>
                   
                    <?php } ?>
                   
                    <?php if ($authj->rowff['apoderado'] == 1) { ?>
                    <li><a href="tesoreria_cuotas_misdeudas.php">Mis Deudas</a></li>
                    <li><a href="tesoreria_mispagos.php">Mis Pagos</a></li>
                    <?php }?>
                            
                        </ul>
                    </li>
                 <?php } ?>
                         
                    <?php if ($authj->rowff['tesorero'] == 1 || $authj->rowff['entrenador'] == 1 || $authj->rowff['admin'] == 1 || $authj->rowff['sysadmin'] == 1) { ?>
                    <li class="menu-item-has-children<?php if ($_menu == 'config') { ?> active<?php } ?>"><a href="javascript:void(0);"><i class="list-icon  material-icons">settings</i> <span class="hide-menu">Configuraciones</span></a>
                        <ul class="list-unstyled sub-menu">
                           

                            <?php if ($authj->rowff['tesorero'] == 1 || $authj->rowff['entrenador'] == 1 || $authj->rowff['admin'] == 1 ||  $authj->rowff['sysadmin'] == 1  ) { ?>
                 
                        
                             <li><a href="grupos.php">Grupos</a>
                   
                            <?php } ?>

                            <?php if ($authj->rowff['entrenador'] == 1 || $authj->rowff['admin'] == 1 ||  $authj->rowff['sysadmin'] == 1  ) { ?>
                           
                            <li><a href="colegios.php">Colegios</a></li>
                            <li><a href="categorias.php">Categorias</a>
                            </li>
                            <li><a href="federaciones.php">Federaciones</a>
                            </li>
                            <li><a href="pruebas.php">Pruebas</a>
                            </li>
			                
                            <li class="menu-item-has-children active"><a href="javascript:void(0);">Usuarios</a>
                                <ul class="list-unstyled sub-menu<?php if ($_page == 'usuarios' or $_page == 'usuarios_add') { ?> active<?php } ?>">
                                    <li><a href="usuarios_add.php">Agregar Usuario</a></li>
                                    <li><a href="usuarios.php">Ver Usuarios</a></li>
                                </ul>
                            </li>
                                <?php } ?>
                           
                        </ul>
                    </li>
                    <?php } ?>

                    


                     
                    
                   
                </ul>
                <!-- /.side-menu -->
            </nav>
            <!-- /.sidebar-nav -->
        </aside>
