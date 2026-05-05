<!DOCTYPE html>
<html lang="en">

    <?php include('header.php'); ?>

    <body class="sidebar-light sidebar-expand navbar-brand-dark">
        <div id="wrapper" class="wrapper">
            <!-- HEADER & TOP NAVIGATION -->
            <?php include('cabeza.php'); ?>
            <!-- /.navbar -->
            <div class="content-wrapper">
                <!-- SIDEBAR -->
                <?php include('menu.php'); ?>
                <!-- /.site-sidebar -->
                <main class="main-wrapper clearfix">
                    <!-- Page Title Area -->
                    <div class="container-fluid">
                        <div class="row page-title clearfix">
                            <div class="page-title-left">
                                <h6 class="page-title-heading mr-0 mr-r-5">Configuración</h6>
                             
                            </div>
                            <!-- /.page-title-left -->
                            <div class="page-title-right d-none d-sm-inline-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="intro.php">Intro</a>
                                    </li>
                                    <li class="breadcrumb-item">Configuración</li>
                                    <li class="breadcrumb-item active"><a href="estatus.php">Estatus</a></li>
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
                                        <div class="row">
                                           
                                            <div class="col-md-12 text-right">
                                               
                                                <div id="buscador_div" class="oculto">
                                                    <form action="estatus_mod.php" method="get">
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label" for="l0">Estatus</label>
                                                            <div class="col-md-9">
                                                                <input class="form-control" id="estatus" name="estatus" placeholder="Estatus" type="text" value="<?php echo $estatus;?>">
                                                            </div>
                                                        </div>
                                                        
                                                         
                                                        <div class="form-actions btn-list">
                                                            <button class="btn btn-primary" type="submit">Buscar</button>
                                                        </div>
                                                    </form>
                                                </div>
                             
                                                 <div id="buscador_div1" class="jumbotron padding-formulario">
                                                    <form action="estatus_mod1.php" method="post" id="formestatu">
                                                         <h5 class="box-title texto-centro">Editar Estatus</h5>
                             						   <div class="row">
                            							
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-md-4 col-form-label" for="l0">Estatus *</label>
                                                                <div class="col-md-8">
                                                                    <input class="form-control" id="estatus" name="estatus" placeholder="Estatus" type="text"  value="<?php echo $data->row[0]['estatus'];?>"  required>
                                                                    <input id="id" name="id" type="hidden"  value="<?php echo $id;?>"  required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                         
                                                       
                                                    </div>
                                                     

                                                    <div class="form-actions btn-list">
                                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                                    </div>
                                                </form>
                                                
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="box-title">Estatus</h5>
                                        <p>Estatus: <?php  echo $tabla['total_results'] ?> <br> Pagina: <?php  echo $tabla['page']; ?> de <?php echo $tabla['total_pages'];  ?>
                                        </p>

                                        <table class="tablesaw color-table table-hover table tablesaw-stack table-striped tablesaw-row-zebra" data-tablesaw-mode="stack">
                                            <thead>
                                                <tr>
                                                   
                                                    <th>Id</th>
                                                    <th>Estatus</th>
                                                   
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($tabla['resultado'] as $Elem) { ?>
                                                    <tr>
                                                    
                                                    <td><?php echo $Elem['id']; ?></td>
                                                    <td><?php echo $Elem['estatus'];?></td>
                                                   <td>
                                   			 <a href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?id=<?php echo $Elem['id']; ?>" class="btn mini" title="Editar Estatus" alt="Editar Estatus"><i class="fas fa-pen"></i></a>
                                              <?php 
                                            /*if ($Elem['eliminado']=='0'){ ?>
                                             <a href="<?php echo BASE_PATH_CONTROL; ?>estatus_elim.php?id=<?php echo $Elem['id']; ?>" class="btn mini" title="Eliminar" alt="Eliminar" onClick="return confirm('Seguro de eliminar este Estatus?');"><i class="fa fa-fw fa-trash"></i></a>
                                            <?php }else{ ?>
                                              <a href="<?php echo BASE_PATH_CONTROL; ?>estatus_act.php?id=<?php echo $Elem['id']; ?>" class="btn mini" title="Activar" alt="Activar" onClick="return confirm('Seguro de activar este Estatus?');"><i class="fa fa-check"></i></a>
                                            <?php } */?>


                                                         </td>
                                                    </tr>
<?php } ?>

                                            </tbody>
                                        </table>


                                        <div class="row1">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <?php $contpag = 1; ?>
                                                    <?php
                                                    $pagemin = $tabla['page'] - 3;
                                                    $pagemax = $tabla['page'] + 3;
                                                    $PagAnt = $tabla['page'] - 1;
                                                    $PagSig = $tabla['page'] + 1;
                                                    ?>
                                                    <?php if ($tabla['page'] >= 1) { ?>
                                                        <li class="page-item"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?pagi=1&<?php echo $listvar ?>">&laquo;</a></li>

<?php } ?>
<?php if ($tabla['page'] > 1) { ?>

                                                        <li class="page-item"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?pagi=<?php echo $PagAnt; ?>&<?php echo $listvar ?>">&lt;</a></li>


                                                    <?php } ?>
                                                    <?php while ($contpag <= $tabla['total_pages']) {
                                                        ?>
    <?php if ($tabla['page'] == 1) { ?>
                                                            <li class="page-item<?php if ($contpag == $tabla['page']) { ?> active<?php } ?> <?php if ($contpag > 9) echo 'oculto'; ?>"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?pagi=<?php echo $contpag; ?>&<?php echo $listvar ?>"><?php echo $contpag; ?></a></li>

                                                            <?php
                                                            $contpag = $contpag + 1;
                                                        }
                                                        elseif ($tabla['page'] < 5) {
                                                            ?>
                                                            <li class="page-item<?php if ($contpag == $tabla['page']) { ?> active<?php } ?> <?php if ($contpag > 7) echo 'oculto'; ?>"  >
                                                                <a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?pagi=<?php echo $contpag; ?>&<?php echo $listvar ?>"><?php echo $contpag; ?></a>
                                                            </li>
                                                            <?php
                                                            $contpag = $contpag + 1;
                                                        } elseif ($tabla['page'] > $tabla['total_pages'] - 5) {
                                                            ?>
                                                            <li class="page-item<?php if ($contpag == $tabla['page']) { ?> active<?php } ?> <?php if ($contpag < $tabla['total_pages'] - 7) echo 'oculto'; ?>"  >
                                                                <a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?pagi=<?php echo $contpag; ?>&<?php echo $listvar ?>"><?php echo $contpag; ?></a>
                                                            </li>
        <?php $contpag = $contpag + 1;
    } else {
        ?>
                                                            <li class="page-item<?php if ($contpag == $tabla['page']) { ?> active<?php } ?> <?php if ($contpag < $pagemin || $contpag > $pagemax) echo 'oculto'; ?>"  >
                                                                <a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?pagi=<?php echo $contpag; ?>&<?php echo $listvar ?>"><?php echo $contpag; ?></a>
                                                            </li><?php
                                                    $contpag = $contpag + 1;
                                                }
                                            }
?>
                                                    <?php if ($tabla['page'] < $tabla['total_pages']) { ?>

                                                        <li class="page-item"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?pagi=<?php echo $PagSig; ?>&<?php echo $listvar ?>">&gt;</a></li>

<?php } ?>
<?php if ($tabla['page'] >= 1) { ?>
                                                        <li class="page-item"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>estatus_mod.php?pagi=<?php echo $tabla['total_pages']; ?>&<?php echo $listvar ?>">&raquo;</a>
                                                        </li>
<?php } ?>
                                                </ul>
                                            </nav>



                                        </div>


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
<?php include('footer.php'); ?>
        </div>
        <!--/ #wrapper -->
<?php include('cierre.php'); ?>
    </body>

</html>
