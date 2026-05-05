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
                                <h6 class="page-title-heading mr-0 mr-r-5"> Historial Académico</h6>
                             
                            </div>
                            
                            <!-- /.page-title-left -->
                            <div class="page-title-right d-none d-sm-inline-flex">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Intro</a>
                                    </li>
                                    <li class="breadcrumb-item">Notas</li>
                                    <li class="breadcrumb-item active"> Listar</li>
                                </ol>
                            </div>
                          
                            <!-- /.page-title-right -->
                        </div>
                        <div class="form-actions btn-list text-right">
                            
                            
                                   <a href="listado_atletas_excel.php?id_user=<?php echo  $usuariob; ?>&admin=<?php echo  $admin; ?>" class="btn  btn-xs btn-rounded ripple" title="Descargar Excel de atletas registrados" alt="Descargar Excel de atletas registrados" style="color:#0fcf25"><i class="far fa-file-excel"></i>&nbsp;&nbsp;Descargar</a>
                                                                             
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
                                        
                                      

                                        <div class="container">
                                            <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="table-responsive">                       
                                                            <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                                                            <thead class="text-center">
                                                                <tr>
                                                                    
                                                                
                                                                   
                                                                    <th>Matricula</th>
                                                                    <th>Nombre</th>
                                                                    <th>Apellidos</th>
                                                                    
                                                                 
                                                                    <th>Tetramestre</th>
                                                                  
                                                                    <th>Asignatura</th>
                                                                    <th>CalificacionFinal</th>
                                                               
                                                                    <th>Catedratico</th>
        
                                                                 
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php                            
                                                                foreach($tabla as $dat) {      
                                                                   // $id=$dat['id']                                                  
                                                                ?>
                                                                <tr id="<?php echo $dat['id'] ?>">
                                                                
                                                                   
                                                                    <td id="mat<?php echo $dat['id'] ?>"><?php echo $dat['Matricula'] ?></td>

                                                                    <td id="nom<?php echo $dat['id'] ?>"><?php echo $dat['Nombre'] ?></td>
                                                                    <td id="apater<?php echo $dat['id'] ?>"><?php echo $dat['APaterno'].' '.$dat['AMaterno']?></td>
                                                                    
                                                                    
                                                                    <td id="tetra<?php echo $dat['id'] ?>"><?php echo $dat['Tetramestre'] ?></td>
                                                                  
                                                                    <td id="asign<?php echo $dat['id'] ?>"><?php echo $dat['Asignatura'] ?></td>
                                                                    <td id="calif<?php echo $dat['id'] ?>"><?php echo $dat['CalificacionFinal'] ?></td>
                                                                   
                                                                    <td id="catedra<?php echo $dat['id'] ?>"><?php echo $dat['Catedratico'] ?></td>
                                                                   
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
            <div class="modal-body">
              
                <div class="form-group">
                     <input type="hidden" id="id2" name="id2" value="1">
                     <input type="hidden" id="opcion" name="opcion" value="1">

                                            <label class="form-control-label">Tipo de Marca</label>
                                            <select name="tipo" id="tipo" class="form-control records1" >
                                                 <option value=""> Elegir Tipo de Marca</option>
                                                 <option value="1">Records</option>
                                                 <option value="2">Marca Minimas</option>
                                                 <option value="3">Marca Maxima</option>
                                                            
                                            </select>
                
                </div>
                                         
                <div class="form-group">
                
                <label for="nombre" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" value="">
                </div>

                <div class="form-group">
                
                <label for="piscina" class="col-form-label">Piscina:</label>
                    <select name="piscina" id="piscina" class="form-control piscina" >
                                                 <option value=""> Elegir Tipo de Piscina</option>
                                                 <option value="25">25 Metros</option>
                                                 <option value="50">50 Metros</option>
                                                
                                                            
                    </select>
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
  <script src="./assets/js/main_consulta_notas_maestro.js"></script>
  <script src="./assets/js/lista-ventana.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

  
 
  

 

   




  

    </body>

</html>
