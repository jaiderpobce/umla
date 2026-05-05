<!-- Scripts -->


  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>-->
	
  <?php if ($_page == 'notas_maestro') { ?>
  <script type="text/javascript">
    $(document).ready(function() {
      tablaPersonas = $("#tablaPersonas").DataTable({
        "responsive": true,
        "columnDefs":[
 
       { responsivePriority: 1, targets: 3,width: '20%'},
       { responsivePriority: 2, targets: 2 },
       { responsivePriority: 3, targets: 1},
      
       { responsivePriority: 2, targets: 9 },
       { responsivePriority: 1, targets: -7 ,width: '50%'},
       { responsivePriority: 1, targets: -2 },
       { responsivePriority: 1, targets: -1 }
    ],
        
        //Para cambiar el lenguaje a español
    "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
             },
             "sProcessing":"Procesando...",
        },
    });

   
    $("#btnNuevo").click(function(){
    $("#formPersonas").trigger("reset");
    $(".modal-header").css("background-color", "#0101ff");
    $(".modal-header").css("color", "white");
    $(".modal-title").css("color", "white");
    $(".modal-title").text("Creando Registro");            
    $("#modalCRUD").modal("show");        
    id=null;
    opcion = 1; //alta
    }); 




    $(document).on("click", ".btnEditar2", function(){
    fila = $(this).closest("tr");
   id = parseInt(fila.find('td:eq(0)').text());



    
    $("#id2").val(id);
    $("#tipo").val(tipo);
    $("#nombre").val(nombre);
    $("#piscina").val(piscina);
    $("#descripcion").val(descripcion); 
    $("#fecha").val(fecha);
    $("#id_macrociclo").val(id_macrociclo); 
    $("#id_entrenador").val(id_entrenador);
    $("#vol").val(vol);

    //console.log(id);
    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#0101ff");
    $(".modal-header").css("color", "white");
    $(".modal-title").css("color", "white");
    $(".modal-title").text("Editando Marca");  
    $('#icono2').removeClass('far fa-save').addClass('fas fa-edit');
    //$('#icono1').removeClass('fas fa-edit').addClass('far fa-save');          
    $("#modalCRUD").modal("show");  
    
});



       $(document).on("click", ".btnEditar3", function(){
          //  fila = $(this).closest("tr");
        
          
            var contador = $(this).attr('id');
             var splitid = contador.split('_');
             var nombre_item = splitid[0];
             var id_nota = splitid[1];
             var action='getDatos_nota';
            // console.log(id_nota+'notas'+' '+nombre_item);
           //  return false;
             $.ajax({
                  type: "POST",
                  url: "notas_maestro.php?action="+action,
                  data: {
                    id_nota: id_nota,
                  
                  }, // serializes the form's elements.
                  success: function(data) {
                    var data = JSON.parse(data);
                   
                    console.log(data);
                    $('#id').val(data.id);
                    $('#email').val(data.Email);
                    $('#matricula').val(data.Matricula);
                    $('#nombre').val(data.Nombre);
                    $('#apaterno').val(data.APaterno);
                    $('#amaterno').val(data.AMaterno);
                    $('#periodo').val(data.Periodo);
                    $('#tetramestre').val(data.Tetramestre);
                    $('#nivel').val(data.Nivel);
                    $('#asignatura').val(data.Asignatura);
                    $('#calificacion').val(data.CalificacionFinal);
                    $('#catedratico').val(data.Catedratico);
                    opcion = 2; //editar
                    $(".modal-header").css("background-color", "#0101ff");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").css("color", "white");
                    $(".modal-title").text("Editando Registro");  
                    $('#icono2').removeClass('far fa-save').addClass('fas fa-edit');
                    //$('#icono1').removeClass('fas fa-edit').addClass('far fa-save');          
                    $("#modalCRUD").modal("show");  


                  }
                });


      });




      $("#formPersonas").submit(function(e){
            e.preventDefault(); 

            if(opcion == 2){
         
            action='update_registro';
            }else{
                action='add';
            }
               email     =      $('#email').val();
               matricula =      $('#matricula').val();
               nombre    =      $('#nombre').val();
               apaterno  =      $('#apaterno').val();
               amaterno  =      $('#amaterno').val();
               periodo   =      $('#periodo').val();
               tetramestre   =      $('#tetramestre').val();
               nivel     =      $('#nivel').val();
               asignatura =     $('#asignatura').val();
               calificacion =   $('#calificacion').val();
               catedratico =    $('#catedratico').val();
               id =    $('#id').val();

            

       

        if(email==''|| nombre ==''|| calificacion ==''){
                alert("No pueden existir campos en Blanco");
                return false;
            }
            
            //return false;    
            $.ajax({
            // url: idurl+"bd/crud.php",
                url: "notas_maestro.php?action="+action,
                type: "POST",
                dataType: "json",
                data: {id:id,email:email,matricula:matricula,nombre:nombre,apaterno:apaterno,amaterno:amaterno,periodo:periodo,tetramestre:tetramestre,nivel:nivel,asignatura:asignatura,calificacion:calificacion,catedratico:catedratico, opcion:opcion},
                success: function(data){  
                   console.log(data);
               
                
                
                    location.reload();
                            
                }        
            });
            $("#modalCRUD").modal("hide");    
            
        });    
        

        $(document).on("click", ".btnBorrar", function(){    
            var contador = $(this).attr('id');
             var splitid = contador.split('_');
             var nombre_item = splitid[0];
             var id_nota = splitid[1];
             
                opcion = 3 //borrar
                action='delete';

                var respuesta = confirm("¿Está seguro de eliminar el registro: "+id_nota+"?");
                if(respuesta){
                    $.ajax({
                        url: "notas_maestro.php?action="+action,
                        type: "POST",
                        dataType: "json",
                        data: {opcion:opcion, id_nota:id_nota},
                        success: function(){
                        alert("Registro eliminado con exito");
                        location.reload();
                        // tablaPersonas.ajax.reload();
                        // $('#tablaPersonas').DataTable().ajax.reload();
                        }
                    });
                }   
            });

      $(document).on("click", ".btnRechazado", function(){
          //  fila = $(this).closest("tr");
        
          
            var contador = $(this).attr('id');
             var splitid = contador.split('_');
             var nombre_item = splitid[0];
             var id_factura = splitid[1];
             var status = 'rechazado';
             var action='getAll_estatus';
             var id_user = '<?php echo $authj->rowff['id']; ?>';
             var descripcion = prompt("Por favor, ingrese el motivo del rechazo:");
        
         //   let nombre = "Lista de autorizacion de pago";
            console.log(id_factura,id_user,status,action, descripcion );

           // return false;


                 $.ajax({
                  type: "POST",
                  url: "ver_pagos_maestro.php?action="+action,
                  data: {
                    id_user: id_user,
                    status: status,
                    id_factura: id_factura,
                    descripcion: descripcion, 
                  }, // serializes the form's elements.
                  success: function(data) {
                   // console.log(data);
                    window.location.href = "ver_pagos_maestro.php";


                  }
                });
        
      });


      $(document).on("click", ".btnAprobado", function(){
          //  fila = $(this).closest("tr");
        
          
            var contador = $(this).attr('id');
             var splitid = contador.split('_');
             var nombre_item = splitid[0];
             var id_factura = splitid[1];
             var status = 'aprobado';
             var action='getAll_estatus';
             var id_user = '<?php echo $authj->rowff['id']; ?>';
             var descripcion = '';
         //   let nombre = "Lista de autorizacion de pago";
            console.log(id_factura,id_user,status,action );

           // return false;


                 $.ajax({
                  type: "POST",
                  url: "ver_pagos_maestro.php?action="+action,
                  data: {
                    id_user: id_user,
                    status: status,
                    id_factura: id_factura,
                    descripcion: descripcion,
                  }, // serializes the form's elements.
                  success: function(data) {
                    console.log(data);
                    window.location.href = "ver_pagos_maestro.php";


                  }
                });
        
      });


      $("#btnCancelarDialog").click(function(){
          dialog.close(); 
          console.log('dialog.close()');
      });  

    });
  </script>
<?php } ?>