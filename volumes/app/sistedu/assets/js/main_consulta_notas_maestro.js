$(document).ready(function(){
    tablaPersonas = $("#tablaPersonas").DataTable({
        "responsive": true,
        "columnDefs":[
            /*{
        "targets": -1,
        "data":null,
          
       },*/
   
       { responsivePriority: 1, targets: 3,width: '10%'},
       { responsivePriority: 2, targets: 2 }
   
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
    // id_tipo = $.trim($("#tipo").val());
     id_tipo =  $.trim($('#tipo'+id).val());
     window.location.href = 'marcas_maestro2.php?id=' + id + '&tipo=' +id_tipo ;
   //  id= $(this).attr('id');
   // id = parseInt(fila.find('td:eq(0)').text());
   
   // let nombre = "Lista de Atletas";
  //  console.log(id,nombre );
  //  return false;
    //  openAsistencias(nombre,id);
    //openGrupos(id);
});

$('#id_records').change(function(){
    console.log("entre");
    var opcion = $(this).val();
   
    switch (opcion) {
      case '1':
        $('#atleta').prop('readonly', false);
        $('#fecha').prop('readonly', false);
        $('#ubicacion').prop('readonly', false);
        $('#ano_nac').prop('readonly', false);
        
        break;
  
      default:
        $('#atleta').val('0');
        $('#atleta').prop('readonly', true);

        $('#fecha').prop('readonly', true);
        $('#fecha').val('0000-00-00');

        $('#ubicacion').prop('readonly', true);
        $('#ubicacion').val('');

        $('#ano_nac').prop('readonly', true);
        $('#ano_nac').val('0');
        

       
        break;
    }
});



$('.estilos').change(function(){
    var id = this.id;
    var splitid = id.split('_');
    var indext = splitid[1];
    //console.log("index: "+indext);
    //$('#estilo_'+indext).val('0');
    valor = $('#estilo_'+indext).val();
    //console.log("estilo: "+valor);
    $.ajax({
                    url: "pruebas_distancias.php",
                    type: 'post',
                    data: { estilo: valor },
                    success: function( data ) {
                       console.log("lo hizojj"+data);
                        $("#distancia_"+indext ).html(data);
                        $("#distancia_"+indext).removeAttr('disabled');
                        
                       
                        //$('#lacategorias0').multiSelect();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                       alert(xhr.status);
                        //alert(thrownError);
                    }
                });
                
    
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
    tipo =  ($('#tipo'+id).val()) ?$('#tipo'+id).val():fila.find('td:eq(1) input[type="hidden"]').val();
    
    //nombre = fila.find('td:eq(2)').text();
    nombre = ($('#nom'+id).text())?$('#nom'+id).text():fila.find('td:eq(2)').text();
    piscina = ($('#piscina'+id).text())?$('#piscina'+id).text():fila.find('td:eq(2)').text();
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
            url: "marcas_maestro.php?action="+action,
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
            url: "marcas_maestro.php?action="+action,
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
    
$("#formPersonas").submit(function(e){
    e.preventDefault(); 

    if(opcion == 2){
        id = $.trim($("#id2").val());
       // console.log(id); 
      action='update';
    }else{
        action='add';
    }
   // nom_tipo= $('select[name="tipo"] option:selected').text();
    //nom_entrenador= $('select[name="id_entrenador"] option:selected').text();
    //console.log(nom_tipo);

    tipo = $.trim($("#tipo").val());   
    nombre = $.trim($("#nombre").val());
   // nombre = $.trim($("#nombre").val());
    piscina = $.trim($("#piscina").val());

   // idurl= $("#idurl").val();

    //console.log(opcion);

 if(tipo==''|| nombre ==''|| piscina ==''){
        alert("No pueden existir campos en Blanco");
        return false;
      }
    
    //return false;    
    $.ajax({
       // url: idurl+"bd/crud.php",
        url: "marcas_maestro.php?action="+action,
        type: "POST",
        dataType: "json",
        data: {id:id,tipo:tipo,nombre:nombre,piscina:piscina, opcion:opcion},
        success: function(data){  
            //console.log(data);
            id = data.id;   
            tipo = data.tipo;    
            nombre = data.nombre;
            piscina = data.piscina;
          
           
            location.reload();
                      
        }        
    });
    $("#modalCRUD").modal("hide");    
    
});    
   


   $(document).on("click", "#atrasmarcas", function(){
              
    window.location.href = 'marcas_maestro' ;
 
   });
  //----formulario de asignar detalle de marca--------------------------------------
  $("#formarcas2").submit(function(e){
    e.preventDefault(); 

    var opcion =1;
    //console.log("entre aqui ");
    //return false;

    if(opcion == 1){
        id = $.trim($("#id2").val());
        // console.log(id); 
        action='add_det2';
    }else{
       
        action='update_det2';
    }
    id_dt= ($.trim($("#id_det").val()))?$.trim($("#id_det").val()):'0';

   // nombre= $.trim($("#prueba").val())+' '+$.trim($("#edad_desde").val())+'-'+$.trim($("#edad_hasta").val());
    tipo=  $.trim($("#id_tipo").val());
    //console.log('id '+id_dt);
   // return false;
    estilo= $.trim($("#estilo_1").val());
    genero = $.trim($("#genero").val());   
    //distancia = $.trim($("#distancia_1").val());

    edad_desde = $.trim($("#edad_desde").val());   
    edad_hasta = $.trim($("#edad_hasta").val());
    //piscina = $.trim($("#piscina").val());

    prueba = $.trim($("#distancia_1").val());   
    tiempo = $.trim($("#tiempo").val());

    atleta =($.trim($("#atleta").val()))?$.trim($("#atleta").val()):'0'; 

    fecha = ($.trim($("#fecha").val()))?$.trim($("#fecha").val()):'0000-00-00';
    ubicacion = $.trim($("#ubicacion").val());
    ano_nac = $.trim($("#ano_nac").val());
   // relevo = $.trim($("#relevo").val());


    // console.log('funciona ff '+' '+genero+' '+piscina+' '+nom_genero);
  //  return false;

    // idurl= $("#idurl").val();

    //console.log(opcion);
  if(genero==''|| piscina ==''){
        alert("No pueden existir campos en Blanco");
        return false;
      }
    
    //return false;    
    $.ajax({
        // url: idurl+"bd/crud.php",
        url: "marcas_maestro2.php?action="+action,
        type: "POST",
        dataType: "json",
        data: {id_dt:id_dt,tipo:tipo,genero:genero, opcion:opcion,estilo:estilo,distancia:distancia,piscina:piscina,edad_desde:edad_desde,edad_hasta:edad_hasta,prueba:prueba,tiempo:tiempo,atleta:atleta,fecha:fecha,ubicacion:ubicacion,ano_nac:ano_nac,relevo:relevo},
        success: function(data){  
            console.log("creado con exito");
          //  console.log(data);
            id = data.id;   
             nombre  = data.nombre;    
              nom_tipo = data.nom_tipo;
          
           if(opcion == 1){tablaPersonas.row.add([id,nom_tipo,nombre]).draw();}
           else{tablaPersonas.row(fila).data([id,nom_tipo,nombre]).draw();} 
         //   location.reload();
             
                    $("#prueba").val('');
                    $("#id_records").val('');
                    
                    $("#estilo_1").val('');
                    $("#genero").val('');   
                    $("#distancia_1").val('');

                    $("#edad_desde").val('');   
                    $("#edad_hasta").val('');
                    $("#piscina").val('');

                    $("#prueba").val('');   
                    $("#tiempo").val('');

                  
                    $("#relevo").val('');

                    $('#prueba').focus();

                    $('#atleta').val('');

                    $('#atleta').prop('readonly', true);

                    $('#fecha').prop('readonly', true);
                    $('#fecha').val('0000-00-00');

                    $('#ubicacion').prop('readonly', true);
                    $('#ubicacion').val('');

                    $('#ano_nac').prop('readonly', true);
                    $('#ano_nac').val('');
         
        }        
     });
  //  $("#modalCRUD").modal("hide");    
    
});    
//----formulario de asignar detalle de marca--------------------------------------







//----formulario de asignar detalle de marca--------------------------------------


$("#formarcas").submit(function(e){
    e.preventDefault(); 

    console.log('funciona ');
    return false;
    if(opcion == 2){
        id = $.trim($("#id2").val());
       // console.log(id); 
      action='update';
    }else{
        action='add';
    }
    nom_tipo= $('select[name="tipo"] option:selected').text();
    nom_entrenador= $('select[name="id_entrenador"] option:selected').text();
    console.log(nom_tipo);
    tipo = $.trim($("#tipo").val());   
    nombre = $.trim($("#nombre").val());

    idurl= $("#idurl").val();

    console.log(opcion);
 if(tipo==''|| nombre ==''){
        alert("No pueden existir campos en Blanco");
        return false;
      }
    
    //return false;    
    $.ajax({
       // url: idurl+"bd/crud.php",
        url: "marcas_maestro.php?action="+action,
        type: "POST",
        dataType: "json",
        data: {id:id,tipo:tipo,nombre:nombre, opcion:opcion},
        success: function(data){  
            //console.log(data);
            id = data[0].id;   
            tipo = data[0].tipo;    
            nombre = data[0].nombre;
          
           
            location.reload();
                      
        }        
    });
    $("#modalCRUD").modal("hide");    
    
});    
//----formulario de asignar detalle de marca--------------------------------------



//----end formulario de asignar grupos a sesion--------------------------------------
    
    $('#mostrarBtn').click(function() {
        mostrarMensaje('¡Mensaje de respuesta activado con jQuery!');
    });

  
    var selectedRowIndex = localStorage.getItem('selectedRow');
    if (selectedRowIndex !== null) {
        $('#table_asistencias tr').eq(selectedRowIndex).focus();
    }
  
  
    $('.estilos').change(function(){
        var id = this.id;
        var splitid = id.split('_');
        var indext = splitid[1];
        //console.log("index: "+indext);
        //$('#estilo_'+indext).val('0');
        valor = $('#estilo_'+indext).val();
        //console.log("estilo: "+valor);
        $.ajax({
                        url: "http://localhost/proyecto_chile/PulproSys/pruebas_distancias.php",
                        type: 'post',
                        data: { estilo: valor },
                        success: function( data ) {
                           console.log("lo hizo"+data);
                            $("#distancia_"+indext ).html(data);
                            $("#distancia_"+indext).removeAttr('disabled');
                            
                           
                            //$('#lacategorias0').multiSelect();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                           alert(xhr.status);
                            //alert(thrownError);
                        }
                    });
                    
        
});




});