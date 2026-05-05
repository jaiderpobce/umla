<!DOCTYPE html>
<html lang="en">

<?php include('header.php');?>

<body class="sidebar-light sidebar-expand navbar-brand-dark">
    <div id="wrapper" class="wrapper">
        <!-- HEADER & TOP NAVIGATION -->
        <?php include('cabeza.php');?>
    <!-- /.navbar -->
    <div class="content-wrapper">
        <!-- SIDEBAR -->
        <?php include('menu.php');?>
        <!-- /.site-sidebar -->
        <main class="main-wrapper clearfix">
            <!-- Page Title Area -->
            <div class="container-fluid">
                <div class="row page-title clearfix">
                    <div class="page-title-left">
                        <h6 class="page-title-heading mr-0 mr-r-5">Configuraciones</h6>
                        <p class="page-title-description mr-0 d-none d-md-inline-block">Usuarios</p>
                    </div>
                    <!-- /.page-title-left -->
                    <div class="page-title-right d-none d-sm-inline-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Intro</a>
                            </li>
                            <li class="breadcrumb-item active">Usuarios</li>
                        </ol>
                    </div>
                    <!-- /.page-title-right -->
                </div>
                <!-- /.page-title -->
            </div>
            <!-- /.container-fluid -->
            <!-- =================================== -->
            <!-- Different data widgets ============ -->
            <!-- =================================== -->
            <div class="container-fluid">
                <div class="widget-list row">
                    

                  
                    <div class="col-md-12 widget-holder">
                            <div class="widget-bg">
                                <div class="widget-body">
                                    <h5 class="box-title">Usuarios</h5>
                                    
                                    <table class="tablesaw color-table table-hover table tablesaw-stack table-striped tablesaw-row-zebra" data-tablesaw-mode="stack">
                                        <thead>
                                            <tr>
                                                <th>Rut</th>
                                                <th>Apellido</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Roles</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php  foreach ($users->row as $Elem) { ?>
                                            <tr>
                                                <td><?php echo getPuntosRut($Elem['rut']);?></td>
                                                <td><?php echo $Elem['apellido'];?></td>
                                                <td><?php echo $Elem['nombre'];?></td>
                                                <td><?php echo $Elem['email'];?></td>
                                           
                                                <td><?php if  ($Elem['nadador'] == '1'){ 
                                                                echo "Nadador<br>";
                                                            }
                                                            if  ($Elem['entrenador'] == 1){ 
                                                                echo "Entrenador<br>";
                                                            }
                                                            if  ($Elem['tesorero'] == 1){ 
                                                                echo "Tesorero<br>";
                                                            }
                                                            if  ($Elem['admin'] == 1){ 
                                                                echo "Admin<br>";
                                                            } 
                                                            if  ($Elem['sysadmin'] == 1){ 
                                                                echo "Sysadmin<br>";
                                                            }
                                                            
                                                            if  ($Elem['apoderado'] == 1){ 
                                                                echo "Apoderado<br>";
                                                            }?></td>
                                                <td>
                                                    <a href="<?php echo BASE_PATH_CONTROL; ?>usuarios_mod.php?id=<?php echo $Elem['id']; ?>" class="btn mini" title="Editar User" alt="Editar User"><i class="fas fa-user-edit"></i></a>
                                                    <a href="<?php echo BASE_PATH_CONTROL; ?>usuarios_elim.php?id=<?php echo $Elem['id']; ?>" class="btn mini" title="Eliminar" alt="Eliminar" onClick="return confirm('Seguro de eliminar este usuario?');"><i class="fa fa-fw fa-trash"></i></a></td>
                                            </tr>
                                        <?php } ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.widget-body -->
                            </div>
                    </div>
                 
                   
                   
                    <!-- /.widget-holder -->
                </div>
                <!-- /.widget-list -->
            </div>
            <!-- /.container-fluid -->
        </main>
        
        <!-- /.main-wrappper -->
        <!-- RIGHT SIDEBAR -->
     
        <!-- CHAT PANEL -->
       
        <!-- /.chat-panel -->
    </div>
    <!-- /.content-wrapper -->
    <!-- FOOTER -->
    <?php include('footer.php');?>
    </div>
    <!--/ #wrapper -->
    <?php include('cierre.php');?>
</body>

</html>