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
                        <p class="page-title-description mr-0 d-none d-md-inline-block">Categorias</p>
                    </div>
                    <!-- /.page-title-left -->
                    <div class="page-title-right d-none d-sm-inline-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Intro</a>
                            </li>
                            <li class="breadcrumb-item active">Categorias</li>
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
                    <div class="widget-bg">
                                <div class="widget-body">
                                    <div class="row">
                    <div class="col-md-6 widget-holder">
                        <h5 class="box-title">Agregar nueva cateoria</h5>
                        <form method="post" action="categorias_add.php">
                                        
                                        
                                        <div class="form-group">
                                            <label class="form-control-label">Federación</label>
                                            <select name="federacion" id="federacion" class="form-control" required>
                                                <option value="">Seleccionar</option>
                                                <?php  foreach ($fed->row as $Fede) { ?>
                                                <option value="<?php echo $Fede['id']?>"><?php echo $Fede['federacion']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Nombre de la categoria</label>
                                            
                                                <input class="form-control" id="nombre" name="nombre" placeholder="Nombre" type="text" required="true">
                                            
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Edad desde</label>
                                            
                                                <input class="form-control" id="desde" name="desde" placeholder="Edad desde" type="text" required="true">
                                            
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="l0">Edad hasta</label>
                                            
                                                <input class="form-control" id="hasta" name="hasta" placeholder="Edad hasta" type="text" required="true">
                                            
                                        </div>
                            
                                        <div class="form-actions btn-list">
                                            <button class="btn btn-primary" type="submit">Enviar</button>
                                        </div>
                            
                                        
                                        <!-- /.form-group -->
                                        
                                        <!-- /.form-group -->
                                        
                                        <!-- /.form-group -->
                                    </form>
                    </div>
                    <div class="col-md-6 widget-holder">
                            <div class="widget-bg">
                                <div class="widget-body">
                                    <h5 class="box-title">Categorias configuradas</h5>
                                    
                                     <?php  
                                     $ult_fed = 0;
                                     $tabs = "";
                                     $federaciones = array();
                                     $div_tab = array();
                                     $table_tab = array();
                                     foreach ($cat->row as $Cate) { 
                                         
                                         //echo "Aqui".$Cate['categoria']." - ".$Cate['federacion']."<br>";
                                         if ($Cate['federacion'] != $ult_fed) {
                                             $federaciones[] = $Cate['federacion'];
                                             //echo "Aqui".$Cate['federacion']."<br>";
                                             $tabs .= "<li class=\"nav-item\"><a class=\"nav-link";
                                             if ($ult_fed == 0) {
                                                $tabs .= " active";
                                             }
                                             $tabs .= "\" href=\"#tab-".$Cate['federacion']."\" data-toggle=\"tab\" aria-expanded=\"true\">".$Cate['fede_nombre']."</a></li>";
                                             $div_tab[$Cate['federacion']] = "<div class=\"tab-pane";
                                             
                                             if ($ult_fed == 0) {
                                                $div_tab[$Cate['federacion']] .= " active";
                                             }
                                             $div_tab[$Cate['federacion']] .= "\" id=\"tab-".$Cate['federacion']."\">";
                                             
                                             
                                             
                                         }
                                         $table_tab[$Cate['federacion']] .= "<tr>";
                                                $table_tab[$Cate['federacion']] .= "<td>".$Cate['categoria']."</td>";
                                                if ($Cate['desde'] == $Cate['hasta']) {
                                                   $table_tab[$Cate['federacion']] .= "<td>".$Cate['desde']."</td>"; 
                                                } else {
                                                    $table_tab[$Cate['federacion']] .= "<td>".$Cate['desde']."-".$Cate['hasta']."</td>"; 
                                                }
                         
                                                $table_tab[$Cate['federacion']] .= "<td><a href=\"". BASE_PATH_CONTROL."grupos_elim.php?id=".$Cate['id']."\" class=\"btn mini\" title=\"Eliminar\" alt=\"Eliminar\" onClick=\"return confirm('Seguro de eliminar esta categoria?');\"><i class=\"fa fa-fw fa-trash\"></i></a></td>";
                                            $table_tab[$Cate['federacion']] .= "</tr>";
                                      $ult_fed = $Cate['federacion'];
                                     } ?>
                                    
                                    <div class="tabs">
                                        <ul class="nav nav-tabs">
                                            <?php echo $tabs; ?>
                                        </ul>
                                        <!-- /.nav-tabs -->
                                        <div class="tab-content">
                                            
                                            <?php foreach ($federaciones as $valor) { 
                                                //echo "entra";
                                                ?>
                                            
                                            <?php echo $div_tab[$valor];?>
                                                <table class="tablesaw color-table table-hover table tablesaw-stack table-striped tablesaw-row-zebra" data-tablesaw-mode="stack">
                                                    <thead>
                                                        <tr>
                                                            <th>Categoria</th>
                                                            <th>Edad</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php echo $table_tab[$valor];?>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } ?>
                                            
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- /.tabs -->
                                    
                                    
                                </div>
                                <!-- /.widget-body -->
                            </div>
                    </div>
                 
                                </div></div></div>
                   
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