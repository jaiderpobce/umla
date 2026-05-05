        <aside class="site-sidebar scrollbar-enabled" data-suppress-scroll-x="true">
            <!-- User Details -->
          <div class="side-user">
                <figure class="side-user-bg" style="background-image: url(assets/demo/user-image-cropped.jpg)">
                    <img src="assets/demo/user-image-cropped.jpg" alt="" class="d-none">
                </figure>
                <div class="col-sm-12 text-center p-0 clearfix">
                    
                    <!-- /.d-inline-block -->
                   
                </div>
                <!-- /.col-sm-12 -->
            </div>
            <!-- /.side-user -->
            <!-- Sidebar Menu -->
            <nav class="sidebar-nav">
                <ul class="nav in side-menu">
                  
                    
                    <li class="menu-item-has-children<?php if ($_menu == 'intro') { ?> active<?php } ?>"><a href="<?php echo BASE_PATH_CONTROL; ?>intro.php"><i class="fas fa-home">&nbsp;&nbsp;&nbsp;&nbsp;</i> <span class="hide-menu">Intro</span></a>
                       
                    </li>
               
					
                <?php if ( $authj->rowff22['admin'] == '1') { ?>

                   

                    
                    <li class="menu-item-has-children<?php if ($_menu == 'archivos') { ?> active<?php } ?>"><a href="javascript:void(0);"><i class="fas fa-sun">&nbsp;&nbsp;&nbsp;&nbsp;</i> <span class="hide-menu">Configuración</span></a>
                        <ul class="list-unstyled sub-menu">
                                                     
                            <li style=" list-style-type: none !important; "><a href="archivo_upload.php"><i class="fas fa-file-upload">&nbsp;&nbsp;&nbsp;&nbsp;</i> <span class="hide-menu">Archivo Masivo</span></a> </li>
                            <li style=" list-style-type: none !important; "><a href="archivo_upload.php"><i class="fas fa-cloud-upload-alt">&nbsp;&nbsp;&nbsp;&nbsp;</i> <span class="hide-menu">Archivo Corto</span></a> </li>
                            <li><a href="notas_maestro.php"><i class="fas fa-bars">&nbsp;&nbsp;&nbsp;&nbsp;</i>Listar Registros</a> </li>
                        </ul>
                    </li>
                  
                    <?php } ?>
               
                
                 
                   
                    <li class="menu-item-has-children<?php if ($_menu == 'notas') { ?> active<?php } ?>"><a href="javascript:void(0);"><i class="fas fa-pen-square">&nbsp;&nbsp;&nbsp;&nbsp;</i> <span class="hide-menu">Notas</span></a>
                        <ul class="list-unstyled sub-menu">
                             <!--<li><a href="entrenadores_add.php">Agregar Entrenador</a>
                            </li>-->                            
                            <li><a href="consulta_notas_maestro.php"><i class="fas fa-bars">&nbsp;&nbsp;&nbsp;&nbsp;</i>Listar</a> </li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children<?php if ($_menu == 'reportes') { ?> active<?php } ?>"><a href="javascript:void(0);"><i class="fas fa-print">&nbsp;&nbsp;&nbsp;&nbsp;</i> <span class="hide-menu">REPORTES</span></a>
                        <ul class="list-unstyled sub-menu">
                             <!--<li><a href="entrenadores_add.php">Agregar Entrenador</a>
                            </li>-->                            
                            <li><a href="consulta_notas_maestro.php">Listar</a> </li>
                        </ul>
                    </li>
                    
                    
                   
                </ul>
				<!--<p style="text-align:center"><img class="logo-expand" alt="" src="<?php echo BASE_PATH_CONTROL; ?>assets/img/logo-dark4.png?v=3.6"></p>-->
                <!-- /.side-menu -->
            </nav>
            <!-- /.sidebar-nav -->
        </aside>