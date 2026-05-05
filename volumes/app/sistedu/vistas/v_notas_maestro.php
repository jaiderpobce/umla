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
                                <h6 class="page-title-heading mr-0 mr-r-5">Listado de Registros de Archivo</h6>
                             
                            </div>
                            
                            <!-- /.page-title-left -->
                            <div class="page-title-right d-none d-sm-inline-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Intro</a>
                                    </li>
                                    <li class="breadcrumb-item">Archivos</li>
                                    <li class="breadcrumb-item active">Registros</li>
                                </ol>
                            </div>
                            <!-- /.page-title-right -->
                        </div>
                        <!-- /.page-title -->
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">            
                            
                            <button id="btnNuevo" type="button" class="btn btn-primary" data-toggle="modal"><i class="fas fa-plus-circle"></i></button>
                              
                            </div>    
                        </div>    
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
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8 text-right">
                                                <div><a href="notas_maestro.php?<?php echo $listvar ?>" class="btn btn-primary btn-rounded ripple" style="color:#fff"><i class="fas fa-download"></i> <span>&nbsp;Descargar Excel</span></a> <a id="bt_buscar" rel="oculto" class="btn btn-primary btn-rounded ripple" style="color:#fff"><i class="fas fa-eye"></i> <span>&nbsp;Buscar Registro</span></a></div>
                                                <div id="buscador_div" class="oculto">
                                                    <form action="notas_maestro.php" method="get">
                                                        <br>
                                                     

                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label" for="l0">Email</label>
                                                            <div class="col-md-9">
                                                                <input class="form-control" id="emailb" name="emailb" placeholder="Email" type="text" value="<?php echo $emailb;?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-3 col-form-label" for="l0">Matricula</label>
                                                            <div class="col-md-9">
                                                                <input class="form-control" id="matriculab" name="matriculab" placeholder="Matricula" type="text" value="<?php echo $matriculab;?>">
                                                            </div>
                                                        </div>
                                                   

                                                        

                                                                <div class="form-actions btn-list">
                                                                    <button class="btn btn-primary" type="submit">Buscar</button>
                                                                </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="box-title">Registros</h5>
                                        <p>Registros: <?php echo $notas->total_results; ?> <br> Pagina: <?php echo $notas->pag; ?> de <?php echo $notas->total_pages; ?>
                                        </p>
                                        <div class="row1">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <?php $contpag = 1; ?>
                                                    <?php
                                                    $pagemin = $notas->pag - 3;
                                                    $pagemax = $notas->pag + 3;
                                                    $PagAnt = $notas->pag - 1;
                                                    $PagSig = $notas->pag + 1;
                                                    ?>
                                                    <?php if ($notas->pag >= 1) { ?>
                                                        <li class="page-item"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>notas_maestro.php?pagi=1&<?php echo $listvar ?>">&laquo;</a></li>

<?php } ?>
<?php if ($users->pag > 1) { ?>

                                                        <li class="page-item"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>notas_maestro.php?pagi=<?php echo $PagAnt; ?>&<?php echo $listvar ?>">&lt;</a></li>


                                                    <?php } ?>
                                                    <?php while ($contpag <= $notas->total_pages) {
                                                        ?>
    <?php if ($users->pag == 1) { ?>
                                                            <li class="page-item<?php if ($contpag == $notas->pag) { ?> active<?php } ?> <?php if ($contpag > 9) echo 'oculto'; ?>"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>notas_maestro.php?pagi=<?php echo $contpag; ?>&<?php echo $listvar ?>"><?php echo $contpag; ?></a></li>

                                                            <?php
                                                            $contpag = $contpag + 1;
                                                        }
                                                        elseif ($notas->pag < 5) {
                                                            ?>
                                                            <li class="page-item<?php if ($contpag == $notas->pag) { ?> active<?php } ?> <?php if ($contpag > 7) echo 'oculto'; ?>"  >
                                                                <a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>notas_maestro.php?pagi=<?php echo $contpag; ?>&<?php echo $listvar ?>"><?php echo $contpag; ?></a>
                                                            </li>
                                                            <?php
                                                            $contpag = $contpag + 1;
                                                        } elseif ($notas->pag > $notas->total_pages - 5) {
                                                            ?>
                                                            <li class="page-item<?php if ($contpag == $notas->pag) { ?> active<?php } ?> <?php if ($contpag < $notas->total_pages - 7) echo 'oculto'; ?>"  >
                                                                <a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>notas_maestro.php?pagi=<?php echo $contpag; ?>&<?php echo $listvar ?>"><?php echo $contpag; ?></a>
                                                            </li>
        <?php $contpag = $contpag + 1;
    } else {
        ?>
                                                            <li class="page-item<?php if ($contpag == $notas->pag) { ?> active<?php } ?> <?php if ($contpag < $pagemin || $contpag > $pagemax) echo 'oculto'; ?>"  >
                                                                <a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>notas_maestro.php?pagi=<?php echo $contpag; ?>&<?php echo $listvar ?>"><?php echo $contpag; ?></a>
                                                            </li><?php
                                                    $contpag = $contpag + 1;
                                                }
                                            }
?>
                                                    <?php if ($notas->pag < $notas->total_pages) { ?>

                                                        <li class="page-item"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>notas_maestro.php?pagi=<?php echo $PagSig; ?>&<?php echo $listvar ?>">&gt;</a></li>

<?php } ?>
<?php if ($users->pag >= 1) { ?>
                                                        <li class="page-item"><a class="page-link" href="<?php echo BASE_PATH_CONTROL; ?>notas_maestro.php?pagi=<?php echo $notas->total_pages; ?>&<?php echo $listvar ?>">&raquo;</a>
                                                        </li>
<?php } ?>
                                                </ul>
                                            </nav>



                                        </div>
                                      

                                        <div class="container">
                                            <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="table-responsive">                       
                                                            <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                                                            <thead class="text-center">
                                                                <tr>
                                                               
                                                                    <th>Email</th>
                                                                   
                                                                    <th>Matricula</th>
                                                                    <th>Nombre</th>
                                                                    <th>Apaterno</th>
                                                                    <th>Amaterno</th>
                                                                    <th>Periodo</th>
                                                                    <th>Tetramestre</th>
                                                                    <th>Nivel</th>
                                                                    <th>Asignatura</th>
                                                                    <th>CalificacionFinal</th>
                                                          
                                                                    <th>Catedratico</th>
        
                                                                    <th>Acción</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php                            
                                                                foreach($tabla as $dat) {      
                                                                   // $id=$dat['id']                                                  
                                                                ?>
                                                                <tr id="<?php echo $dat['id'] ?>">
                                                                   
                                                                    <td><?php echo $dat['Email'] ?> <input  name="tipo" type="hidden" id="tipo<?php echo $dat['id'] ?>" value="<?php echo $dat['tipo']?>" /></td>
                                                                    <td id="mat<?php echo $dat['id'] ?>"><?php echo $dat['Matricula'] ?></td>

                                                                    <td id="nom<?php echo $dat['id'] ?>"><?php echo $dat['Nombre'] ?></td>
                                                                    <td id="apater<?php echo $dat['id'] ?>"><?php echo $dat['APaterno']?></td>
                                                                    <td id="amater<?php echo $dat['id'] ?>"><?php echo $dat['AMaterno'] ?></td>
                                                                    <td id="periodo<?php echo $dat['id'] ?>"><?php echo $dat['Periodo'] ?></td>
                                                                    <td id="tetra<?php echo $dat['id'] ?>"><?php echo $dat['Tetramestre'] ?></td>
                                                                    <td id="nivel<?php echo $dat['id'] ?>"><?php echo $dat['Nivel'] ?></td>
                                                                    <td id="asign<?php echo $dat['id'] ?>"><?php echo $dat['Asignatura'] ?></td>
                                                                    <td id="calif<?php echo $dat['id'] ?>"><?php echo $dat['CalificacionFinal'] ?></td>
                                                                    
                                                                    <td id="catedra<?php echo $dat['id'] ?>"><?php echo $dat['Catedratico'] ?></td>
                                                                    <td>
                                                                        <div class='text-center'> 
                                                                            <div class='btn-group'>
                                                                            <button  id="edit_<?php echo  $dat['id']; ?>"  class='btn btn-primary btnEditar3' ><i class='fas fa-user-edit'></i></button>
                                                                            <button id="delete_<?php echo  $dat['id']; ?>"class='btn btn-danger btnBorrar' style='color:black'><i class='fa fa-fw fa-trash'></i></button>
                                                                            </div>
                                                                    </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                    }
                                                                ?>                                
                                                            </tbody>        
                                                        </table>  

                                        
                                                        
                                                        </div>
                                                    </div>
                                            </div>  
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


       <!--Modal para CRUD-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="formPersonas" action="marcas_maestro.php" method="post">    
            <div class="modal-body" style="max-height: 500px;  overflow-y: auto; ">
              
                                         
                <div class="form-group">
                <label for="email" class="col-form-label" style:"margin-bottom: 0.5rem;">Email:</label>
                 <input type="text" class="form-control" style="padding: 0.275rem 0.275rem;font-size: 0.675rem;" id="email" name="email" value="">
                 <input type="hidden" class="form-control" id="id" name="id" value="">
                 </div>
                <div class="form-group">
                <label for="matricula" class="col-form-label">Matricula:</label>
                <input type="text" class="form-control" style="padding: 0.275rem 0.275rem;font-size: 0.675rem;"id="matricula" name="matricula" value="">
                </div>
                <div class="form-group">
                <label for="nombre" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control"style="padding: 0.275rem 0.275rem;font-size: 0.675rem;" id="nombre" name="nombre" value="">
                </div>
                <div class="form-group">
                <label for="apaterno" class="col-form-label">Apellido Paterno:</label>
                <input type="text" class="form-control" style="padding: 0.275rem 0.275rem;font-size: 0.675rem;"id="apaterno" name="apaterno" value="">
                </div>
                <div class="form-group">
                <label for="amaterno" class="col-form-label">Apellido Materno:</label>
                <input type="text" class="form-control" style="padding: 0.275rem 0.275rem;font-size: 0.675rem;"id="amaterno" name="amaterno" value="">
                </div>
                <div class="form-group">
                <label for="periodo" class="col-form-label">Periodo:</label>
                <input type="text" class="form-control" style="padding: 0.275rem 0.275rem;font-size: 0.675rem;"id="periodo" name="periodo" value="">
                </div>
                <div class="form-group">
                <label for="tetramestre" class="col-form-label">Tetramestre:</label>
                <input type="text" class="form-control"style="padding: 0.275rem 0.275rem;font-size: 0.675rem;" id="tetramestre" name="tetramestre" value="">
                </div>
                <div class="form-group">
                <label for="nivel" class="col-form-label">Nivel:</label>
                <input type="text" class="form-control" style="padding: 0.275rem 0.275rem;font-size: 0.675rem;"id="nivel" name="nivel" value="">
                </div>
                <div class="form-group">
                <label for="asignatura" class="col-form-label">Asignatura:</label>
                <input type="text" class="form-control" style="padding: 0.275rem 0.275rem;font-size: 0.675rem;"id="asignatura" name="asignatura" value="">
                </div>
                <div class="form-group">
                <label for="calificacion" class="col-form-label">Calificacion:</label>
                <input type="text" class="form-control"style="padding: 0.275rem 0.275rem;font-size: 0.675rem;" id="calificacion" name="calificacion" value="">
                </div>
                <div class="form-group">
                <label for="catedratico" class="col-form-label">Catedratico:</label>
                <input type="text" class="form-control"style="padding: 0.275rem 0.275rem;font-size: 0.675rem;" id="catedratico" name="catedratico" value="">
                </div>




             
                           
            
                

 
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-red" data-dismiss="modal"><i class="fas fa-arrow-alt-circle-left"></i></button>
                <button type="submit" id="btnGuardar" class="btn btn-primary"><i id="icono2" class="fas fa-save"></i></button>
            </div>
        </form>    
        </div>
    </div>
</div>  
<dialog id="dialog">
<div class="mensaje" id="mensajeRespuesta1"></div>
    <div class="modal-header">
       <h2 class="modal-title">Mi Ventana Modal</h2>
    </div>
    <input type="text" id="filterInput" placeholder="Filtrar registros...">
    <button id="btnNuevoGs" class="btn btn-success " >Nuevo</button>

    <div class="button-container">
        
        <button onclick="" id= "btn_eliminarGrupo" class="btn btn-danger ">Eliminar</button>
    </div>
    
    <div class='table-container'>
       <table id="table"></table>
    </div>
    <div class="modal-footer">
       <button type="button" id="btnCancelarDialog"  class="salir" ></button>
       
   </div>
  </dialog>

  <dialog id="formsg">
  <div class="modal-header">
    <h2 class="modal-title">Mi Ventana Modal</h2>
   </div>
    <div class='table-container'>
    <table id="formularisg"></table>
    </div>
    <div class="modal-footer">
       <button type="button" id="btnCancelar"  class="btn btn-danger" >Cancelar</button>
       <button type="submit" id="btnGuardarfor" class="btn btn-success">Guardar</button>
   </div>
  </dialog>



   <!--Modal para listar grupos--------------------------------------->
   <dialog id="lista_grupos">
   <div class="mensaje" id="mensajeRespuesta"></div>
   
    <div class="modal-header">
       <h2 class="modal-title">Mi Ventana Modal</h2>
    </div>
    <input type="text" id="filterInputGG" placeholder="Filtrar registros...">
    

    <div class='table-container'>
       <table id="table_grupos"></table>
    </div>
    <div class="modal-footer">
       <button type="button" id="btnCancelarGrupos"  class="salir"  ></button>
       
   </div>
  </dialog>
     <!--end Modal para listar grupos-------------------------------------->

       <!--Modal para listar asistencias--------------------------------------->
   <dialog id="lista_asistencias">
   <div class="mensaje" id="mensajeRespuesta"></div>
   
    <div class="modal-header">
       <h2 class="modal-title">Mi Ventana Modal</h2>
    </div>
    <input type="text" id="filterInputasis" placeholder="Filtrar registros...">
    <input type="checkbox" id="marcarTodos" onchange="seleccionarTodos()">
   
    <label for="marcarTodos">Marcar Todos</label>
    

    <div class='table-container2'>
       <table id="table_asistencias"></table>
    </div>
    <div class="modal-footer">
       <button type="button" id="btnasis"  class="salir" ></button>
       
   </div>
  </dialog>
     <!--end Modal para listar asistencias-------------------------------------->
   
  <script src="./assets/js/datatables/datatables.min.js"></script>
  <script src="./assets/js/main_notas_maestro.js"></script>
  <script src="./assets/js/lista-ventana.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

  
 
  

 

   

   <!--/ #wrapper -->
   <?php include('cierre_umla.php');?>


  

    </body>

</html>
