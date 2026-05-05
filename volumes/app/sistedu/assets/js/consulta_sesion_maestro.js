$(document).ready(function(){
    tablaPersonas = $("#tablaPersonas").DataTable({
        "responsive": true,
        "columnDefs":[//{
        //"targets": -1,
       // "data":null,
      //  "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar' ><i class='fas fa-user-edit'></i></button><button class='btn btn-danger btnBorrar' style='color:black'><i class='fa fa-fw fa-trash'></i></button> <button class='btn btn-info btnGrupo'id='btnGrupo' style='color:black' ><i class='fa fa-users'></i></button><button class='btn btn-success btnAsistencias' style='color:black' ><i class='fas fa-file-alt'></i></button></div></div>"  
      // },
      /* {
        targets: -1, // Última columna donde se colocarán los botones
        "data":null,
        render: function (data, type, row, meta) {
            return `
                <button id="edi<?php echo $dat['id']?>" class="btn btn-primary btnEditar"  ><i class="fas fa-user-edit"></i></button>
                <button id="'.$idBotonEliminar.'" class="eliminar">Eliminar</button>
                <button id="'.$idBotonGrupo.'" class="grupo">Grupo</button>
            `;
        }*/
    //},
       { responsivePriority: 1, targets: 3},
       { responsivePriority: 2, targets: 2 },
      
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
    $(".modal-title").text("Creando Sesión");            
    $("#modalCRUD").modal("show");        
    id=null;
    opcion = 1; //alta
}); 
$("#btnNuevoGs").click(function(){
    console.log("btnNuevoGs");
    $(".modal-header").css("background-color", "#0101ff");
    $(".modal-header").css("color", "white");
    //$(".modal-header").css("margin", "0");
    $(".modal-title").css("color", "white");
    $(".modal-title").text('Lista de Grupos');  
    id=null;
   // opcion = 1; //alta
    //openForsg();
    openGrupos(id);

});



$(document).on("click", ".btnGrupo", function(){
    fila = $(this).closest("tr");
   id = parseInt(fila.find('td:eq(0)').text());
    //id= $(this).attr('id');
   
    let nombre = "Lista de Grupos de sesión";
    console.log(id,nombre );
  //  return false;
    openDialog(nombre,id);
    //openGrupos(id);
}); 

//btnAsistencias
/*$(document).on("click", ".btnAsistencias", function(){
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text());
   
    let nombre = "Lista de Atletas";
   // console.log(id,nombre );
  //  return false;
      openAsistencias(nombre,id);
    //openGrupos(id);
});*/

//btnAsistencias2

$(document).on("click", ".btnAsistencias", function(){
    fila = $(this).closest("tr");
     id = $(this).closest('tr').attr('id');
   //  id= $(this).attr('id');
   // id = parseInt(fila.find('td:eq(0)').text());
   
    let nombre = "Lista de Atletas";
    console.log(id,nombre );
  //  return false;
      openAsistencias(nombre,id);
    //openGrupos(id);
});




$("#btnAtras").click(function(){
       
    window.location.replace("./intro.php");
});   
$("#btnCancelar").click(function(){
  
    console.log('cancelar');
    const formsg= document.getElementById('formsg');
    formsg.close();
  
    $(".modal-title").text('Lista de Grupos de sesión');  
  

}); 
$("#btnCancelarDialog").click(function(){
     dialog.close(); 
     console.log('dialog.close()');
 });   
 
 //boton de cancelar para cerrar lista grupos-----------

 $("#btnasis").click(function(){
   
    lista_asistencias.close();
    //console.log('dialog.close()');
    $(".modal-title").text('Lista de Grupos de sesión');  
    $('#table td').removeClass('seleccionada');
    $(".button-container").hide(); 
    
});  
 //end boton de cancelar para cerrar lista grupos-----------


 //boton de cancelar para cerrar lista grupos-----------

 $("#btnCancelarGrupos").click(function(){
   
    lista_grupos.close();
    console.log('dialog.close()');
    $(".modal-title").text('Lista de Grupos de sesión');  
    $('#table td').removeClass('seleccionada');
    $(".button-container").hide(); 
    
});  
 //end boton de cancelar para cerrar lista grupos-----------


var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
   id = parseInt(fila.find('td:eq(0)').text());
   //idCompleto= $(this).attr('id');
  // id = idCompleto.substring(3);
   // ti_sesion = parseInt(fila.find('td:eq(1)').text());
   // ti_sesion  = fila.find('td:eq(1) input[type="hidden"]').val();
    ti_sesion =  ($('#tipo'+id).val()) ?$('#tipo'+id).val():fila.find('td:eq(1) input[type="hidden"]').val();
    
    //nombre = fila.find('td:eq(2)').text();
    nombre = ($('#nom'+id).text())?$('#nom'+id).text():fila.find('td:eq(2)').text();
    descripcion = fila.find('td:eq(3)').text();
   // fecha = fila.find('td:eq(3)').text();
    fecha = ($('#fec'+id).text())?$('#fec'+id).text() :fila.find('td:eq(3)').text();

    id_macrociclo = fila.find('td:eq(5)').text();
    //id_entrenador= parseInt(fila.find('td:eq(6)').text());
   
    //id_entrenador=  fila.find('td:eq(4) input[type="hidden"]').val();
    id_entrenador=  $('#ent'+id).val();
   // console.log( id_entrenador+' el valor');
   // vol = parseFloat(fila.find('td:eq(5)').text());
    vol  = $('#vol'+id).text();
    
    $("#id2").val(id);
    $("#ti_sesion").val(ti_sesion);
    $("#nombre").val(nombre);
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
    $(".modal-title").text("Editando Sesión");            
    $("#modalCRUD").modal("show");  
    
});



//botón BORRAR
$(document).on("click", ".btnBorrar", function(){    
    fila = $(this);
    id = parseInt($(this).closest("tr").find('td:eq(0)').text());
   // idCompleto= $(this).attr('id');
   // id = idCompleto.substring(3);
    idurl= $("#idurl").val();
    opcion = 3 //borrar
    action='delete';

    var respuesta = confirm("¿Está seguro de eliminar el registro: "+id+"?");
    if(respuesta){
        $.ajax({
            url: "sesion_maestro.php?action="+action,
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id:id},
            success: function(){
               tablaPersonas.row(fila.parents('tr')).remove().draw();
               // tablaPersonas.ajax.reload();
               // $('#tablaPersonas').DataTable().ajax.reload();
            }
        });
    }   
});
 //btnEliminargrupo
//$('#btn_eliminarGrupo').click(function() { 
 $(document).on("click", ".btnEliminargrupo", function(){  
    const id_sg= localStorage.getItem("id_sg");
    const id_sesion = localStorage.getItem("id_sesion");
   // console.log("#btn_eliminarGrupo");
    var respuesta = confirm("¿Está seguro de eliminar el registro: "+id_sg+"?");
 
    opcion = 3 //borrar
    action='delete_gs';
    var data = [];
  
    if(respuesta){
        $.ajax({
            url: "sesion_maestro.php?action="+action,
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id:id_sg},
            success: function(data2){
                data=data2
                //console.log(data);
                $('.mensaje').css("background-color", "#06d6a0");
                mostrarMensaje('¡Grupo eliminado con Exito!');
                
                $('#table td').removeClass('seleccionada');
                //$(".button-container").hide(); 
                dialog.close();
                openDialog("Lista de Grupos de sesión",id_sesion);
              
               

            }
        });
    }   
});
    
    
//----formulario de asignar grupos a sesion--------------------------------------


//----end formulario de asignar grupos a sesion--------------------------------------
    
    $('#mostrarBtn').click(function() {
        mostrarMensaje('¡Mensaje de respuesta activado con jQuery!');
    });

  
    var selectedRowIndex = localStorage.getItem('selectedRow');
    if (selectedRowIndex !== null) {
        $('#table_asistencias tr').eq(selectedRowIndex).focus();
    }
  
    $("#bt_buscarff").click(function() {
        var valor = $(this).attr('rel');
        console.log('entre');

        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
        
        
    });

});