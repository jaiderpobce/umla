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
                        <h6 class="page-title-heading mr-0 mr-r-5">Mis Datos</h6>
                        <p class="page-title-description mr-0 d-none d-md-inline-block">Mis datos</p>
                    </div>
                    <!-- /.page-title-left -->
                    <div class="page-title-right d-none d-sm-inline-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Intro</a>
                            </li>
                            <li class="breadcrumb-item active">Informacion Personal</li>
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
                        <h5 class="box-title">Mis datos personales</h5>
                        <?php if (!empty($err)) { ?>
                        <div class="alert alert-icon alert-danger border-danger alert-dismissible fade show"
                                    role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button> <i class="material-icons list-icon">not_interested</i>  <strong>Error!</strong> 
                                        <?php if ($err == 1) { ?>
                Password actual incorrecto. 
                <?php } else if ($err == 2) { ?>
                Confirmación de nuevo password no coincide.
                <?php } ?>
                        </div>
                        <?php } ?>
                        <?php if ($act == 'OK') { ?>
               <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Actualizado!</h4>
                Sus datos han sido actualizados correctamente.
              </div>
              <?php } ?>
                        <form method="post" action="misdatos_pass1.php" id="formU">
                            <input type="hidden" name="id" value="<?php echo $nad->row[0]['id'];?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="widget-user-profile">
                                        <figure class="profile-wall-img">
                                            <img src="assets/demo/user-widget-bg.jpg" alt="User Wall">
                                        </figure>
                                        <div class="profile-body">
                                            <figure class="profile-user-avatar thumb-md" id="foto_perfil">
                                                <?php include('foto_perfil.php');?>
                                            </figure>
                                            <h6 class="h3 profile-user-name"><?php echo $nad->row[0]['nombre']." ".$nad->row[0]['apellido'];?></h6><small class="profile-user-address"><?php echo $roles;?></small>
                                            <hr class="profile-seperator">
                                            
                                            <!-- /.profile-user-description -->
                                          
                                        </div>
                                </div>
                            </div>
                            <!-- /.modal -->
                                   
                                    <!-- /.modal -->
                        
                            <div class="col-md-8">
                                <div class="form-group">
                  <label for="pass1">Nuevo password. (complete solo si desea cambiar el password)</label>
                  <input type="password" class="form-control" id="pass1" name="pass1" placeholder="Nuevo password">
                </div>
                <div class="form-group">
                  <label for="pass2">Repetir Nuevo password.</label>
                  <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Reescribir Nuevo password">
                </div>
                
                <div class="form-group">
                  <label for="pass">Password Actual</label>
                  <input type="password" class="form-control" id="pass" name="pass" placeholder="Password actual" required>
                </div>
                                
                                <div class="form-actions btn-list">
                                            <button class="btn btn-primary" type="submit">Enviar</button>
                                        </div>
                            </div>
                        </div>
                                        
                        
                                        
                                        
                                        
                            
                            
                                       
                            
                                        
                            
                                        
                                        <!-- /.form-group -->
                                        
                                        <!-- /.form-group -->
                                        
                                        <!-- /.form-group -->
                                    </form>
                    </div>
                  
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