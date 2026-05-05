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
                        <h5 class="box-title">Agregar nuevo usuario</h5>
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
                        <form method="post" action="usuarios_mod1.php" id="formU">
                            <input type="hidden" name="id" value="<?php echo $nad->row[0]['id'];?>">            
                                        <div class="form-group">
                                            <label class="form-control-label">Rut</label>
                                            <input class="form-control" id="rut" name="rut" placeholder="Rut" type="text" required="true" value="<?php echo getPuntosRut($nad->row[0]['rut']);?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Nombres</label>
                                            <input class="form-control" id="nombre" name="nombre" placeholder="Nombre" type="text" required="true" value="<?php echo $nad->row[0]['nombre'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Apellidos</label>                                            
                                                <input class="form-control" id="apellido" name="apellido" placeholder="Apellidos" type="text" required="true" value="<?php echo $nad->row[0]['apellido'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Género</label>                                            
                                            <select class="form-control" id="genero" name="genero" required="true">
                                                    <option value="">Seleccionar</option>
                                                    <option value="1"<?php if ($nad->row[0]['genero'] == 1) { ?> selected<?php } ?>>Femenino</option>
                                                    <option value="2"<?php if ($nad->row[0]['genero'] == 2) { ?> selected<?php } ?>>Masculino</option>
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Email</label>                                            
                                                <input class="form-control" id="email" name="email" placeholder="Email" type="text" required="true" value="<?php echo $nad->row[0]['email'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Teléfono</label>                                            
                                                <input type="text" id="telefono" name="telefono" class="form-control mb-0" data-masked-input="+56 9-99999999" placeholder="XXX-X-XXXXXXXX" maxlength="14" value="<?php echo $nad->row[0]['telefono'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Dirección</label>                                            
                                                <input class="form-control" id="direccion" name="direccion" placeholder="Dirección" type="text" required="true" value="<?php echo $nad->row[0]['direccion'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Fecha de nacimiento</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker" name="fecnac" id="fecnac" value="<?php echo $nad->row[0]['fecnac'];?>" required>
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
                                            <label class="form-control-label" for="l0">Notas</label>                                            
                                                <textarea class="form-control" id="notas" name="notas" rows="3"><?php echo $nad->row[0]['notas'];?></textarea>
                                        </div>
                            
                                         <div  <?php if ($authj->rowff['sysadmin']!=1) { ?> 
                                                    class="form-group oculto" 
                                                <?php }else{ ?> 
                                                    class="form-group"   <?php }?>>
                                            <label class="form-control-label">Club</label>
                                            <select name="club" id="club" class="form-control" required>
                                                <option value="">Seleccionar</option>
                                                <?php  foreach ($club->row as $Club) { ?>
                                                <option value="<?php echo $Club['id']?>" <?php if ($nad->row[0]['club']==$Club['id']) { ?> selected<?php } ?> ><?php echo $Club['club']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <h5 class="box-title mr-b-0">Roles</h5>
                                            <p class="text-muted">Seleccione los roles del usuario</p>  
                                                <div class="checkbox checkbox-rounded checkbox-primary">
                                                    <label>
                                                        <input type="checkbox" name="nadador" value="1"<?php if ($nad->row[0]['nadador']==1) { ?> checked<?php } ?>> <span class="label-text">Nadador</span>
                                                    </label>
                                                </div>
                                            
                                                <div class="checkbox checkbox-rounded checkbox-primary">
                                                    <label>
                                                        <input type="checkbox" name="admin" value="1"<?php if ($nad->row[0]['admin']==1) { ?> checked<?php } ?>> <span class="label-text">Admin</span>
                                                    </label>
                                                </div>
                                                <!-- /.checkbox -->
                                                <div class="checkbox checkbox-rounded checkbox-primary">
                                                    <label>
                                                        <input type="checkbox" name="entrenador" value="1"<?php if ($nad->row[0]['entrenador']==1) { ?> checked<?php } ?>> <span class="label-text">Entrenador</span>
                                                    </label>
                                                </div>
                                                <!-- /.checkbox -->
                                                <div class="checkbox checkbox-rounded checkbox-primary">
                                                    <label>
                                                        <input type="checkbox" name="tesorero" value="1"<?php if ($nad->row[0]['tesorero']==1) { ?> checked<?php } ?>> <span class="label-text">Tesorero</span>
                                                    </label>
                                                </div>
                                                <!-- /.checkbox -->
                                                <?php if ($authj->rowff['sysadmin']==1) { ?> 
                                                <div class="checkbox checkbox-rounded checkbox-primary">
                                                    <label>
                                                        <input type="checkbox" name="sysadmin" value="1"<?php if ($nad->row[0]['sysadmin']==1) { ?> checked<?php } ?>> <span class="label-text">Sysadmin</span>
                                                    </label>
                                                </div>
                                              <?php } ?>
                                                <!-- /.checkbox -->
                                                <div class="checkbox checkbox-rounded checkbox-primary">
                                                    <label>
                                                        <input type="checkbox" name="apoderado" id="apoderado" value="1"<?php if ($nad->row[0]['apoderado']==1) { ?> checked<?php } ?>> <span class="label-text">Apoderado</span>
                                                    </label>
                                                </div>
                                            </div>
                                        <div class="form-group<?php if ($nad->row[0]['apoderado']==1) { ?><?php } else { ?> oculto<?php } ?>" id="nadadores">
                                            <h5 class="box-title mr-b-0">Nadadores del apoderado</h5>
                                            <p class="text-muted">Nadador(es) debe(n) estar previamente creado(s) en el sistema</p>
                                            <div id="nadadores_group0">
                                                <?php 
                                                $conta = 0;
                                                //print_r($nad->representados);
                                                if (!empty($nad->representados)) { 
                                                
                                                    foreach ($nad->representados as $Nadador) {
                                                        $conta++; ?>
                                                <div id="row_pro_<?php echo $conta;?>" class="e_nadador_1 row">
                                                    <div class="col-md-3 col-sm-5">
                                                        <div class="checkbox checkbox-rounded checkbox-primary">
                                                    <label>
                                                        <input type="checkbox" class="a_elim" id="a_elim_<?php echo $conta?>" name="a_elim_<?php echo $conta?>" value="<?php echo $Nadador['id']?>"><span class="label-text"> Elim</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 col-sm-7">
                                                        <label class="form-control-label">Rut Nadador</label>
                                                        <input class="form-control rut_nadador" rel="1" id="e_rut_nadador_1" name="e_rut_nadador_1" placeholder="Rut nadador" type="text" value="<?php echo getPuntosRut($Nadador['rut']);?>" readonly="true">
                                                    </div>
                                                    <div id="e_nombre_nadador_1"><?php echo $Nadador['nombre']." ".$Nadador['apellido'];?></div>
                                                </div>
                                                <hr>
                                                    <?php 
                                                    }                                                    
                                                    } ?>
                                            </div>
                                            
                                            <div id="nadadores_group">
                                            </div>
                                            <input type="hidden" id="a_cant_nad" name="a_cant_nad" value="<?php echo ($conta)?>">
                                            <input type="hidden" id="cant_nad" name="cant_nad" value="0">
                                            <button class="btn btn-primary btn-rounded ripple" id="add_nadador" type="button"><i class="material-icons list-icon">star</i>  <span>Añadir nadador</span>
                                        </button>
                                        </div>
                            
                                        <div class="form-actions btn-list">
                                            <button class="btn btn-primary" type="submit">Enviar</button>
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