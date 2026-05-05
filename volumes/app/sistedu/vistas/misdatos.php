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
                                        Algún campo está vacio.
                                        <?php } else if ($err == 2) { ?>
                                        El rut ya está en uso como usuario. Puede cambiar los roles del usuario.
                                        <?php }  ?>
                        </div>
                        <?php } ?>
                        <form method="post" action="misdatos1.php" id="formU">
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
                                            <div class="mb-5"><a data-toggle="modal" data-target=".bs-modal-lg-primary" class="btn btn-outline-primary btn-rounded btn-lg px-5 border-thick text-uppercase mr-2 mr-0-rtl ml-2-rtl fw-700 fs-11 heading-font-family">Cambiar foto</a>  
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <!-- /.modal -->
                                    <div class="modal modal-primary fade bs-modal-lg-primary" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true" style="display: none">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header text-inverse">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h5 class="modal-title" id="myLargeModalLabel2">Cambiar foto de perfil</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="formulario">
                                                        <!-- /.box-header -->
                                                        <!-- form start -->
                                                              <div id="dropzone" class="dropzone"></div>
                                                   </div>
                                                </div>
                                                <div class="modal-footer"> 
                                                    <button type="button" class="btn btn-danger btn-rounded ripple text-left" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                        
                            <div class="col-md-8">
                                <div class="form-group">
                                            <label class="form-control-label">Rut</label>
                                            <input class="form-control" id="rut" name="rut" placeholder="Rut" type="text" required="true" value="<?php echo getPuntosRut($nad->row[0]['rut']);?>" readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Nombres</label>
                                            <input class="form-control" id="nombre" name="nombre" placeholder="Nombre" type="text" required="true" value="<?php echo $nad->row[0]['nombre'];?>" readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Apellidos</label>                                            
                                                <input class="form-control" id="apellido" name="apellido" placeholder="Apellidos" type="text" required="true" value="<?php echo $nad->row[0]['apellido'];?>" readonly="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Género</label>                                            
                                            <select class="form-control" id="genero" name="genero" required="true" disabled="">
                                                    <option value="">Seleccionar</option>
                                                    <option value="1"<?php if ($nad->row[0]['genero'] == 1) { ?> selected<?php } ?>>Femenino</option>
                                                    <option value="2"<?php if ($nad->row[0]['genero'] == 2) { ?> selected<?php } ?>>Masculino</option>
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Email</label>                                            
                                                <input class="form-control" id="email" name="email" placeholder="Email" type="email" required="true" value="<?php echo $nad->row[0]['email'];?>">
                                        </div>
                                        <?php if ($nad->row[0]['nadador']== 1) { ?>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">No. Licencia Federacion</label>                                            
                                                <input class="form-control" id="licencia" name="licencia" placeholder="No. licencia" type="text" value="<?php echo $nad->row[0]['licencia'];?>" readonly="">
                                        </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label class="form-control-label">Fecha de nacimiento</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker" name="fecnac" id="fecnac" value="<?php echo $nad->row[0]['fecnac'];?>" disabled="">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="list-icon material-icons">date_range</i>
                                                    </div>
                                                    <!-- /.input-group-text -->
                                                </div>
                                                <!-- /.input-group-append -->
                                            </div>
                                            <!-- /.input-group -->
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Teléfono</label>                                            
                                                <input type="text" id="telefono" name="telefono" class="form-control mb-0" data-masked-input="+56 9-99999999" placeholder="XXX-X-XXXXXXXX" maxlength="14" value="<?php echo $nad->row[0]['telefono'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Dirección</label>                                            
                                                <input class="form-control" id="direccion" name="direccion" placeholder="Dirección" type="text" required="true" value="<?php echo $nad->row[0]['direccion'];?>">
                                        </div>
                                        <?php if ($nad->row[0]['nadador'] == 1) { ?>
                                        <div class="form-group">
                                            <label class="form-control-label">Grupo</label>
                                            <select name="grupo" id="grupo" class="form-control" required readonly="">
                                                <option value="">Seleccionar</option>
                                                <?php  foreach ($gru->row as $Grup) { ?>
                                                <option value="<?php echo $Grup['id']?>"<?php if ($nad->row[0]['grupo'] == $Grup['id']) { ?> selected<?php } ?>><?php echo $Grup['grupo']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                            
                                        <div class="form-group">
                                            <label class="form-control-label">Colegio</label>
                                            <select name="colegio" id="colegio" class="form-control" required>
                                                <option value="">Seleccionar</option>
                                                <?php  foreach ($col->row as $Cole) { ?>
                                                <option value="<?php echo $Cole['id']?>"<?php if ($nad->row[0]['colegio'] == $Cole['id']) { ?> selected<?php } ?>><?php echo $Cole['colegio']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php } ?>
                                
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