$(document).ready(function(){
    tablaPersonas = $("#tablaPersonas").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar'>Borrar</button></div></div>"  
       }],
        
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
    $(".modal-header").css("background-color", "#28a745");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Creando Macrociclo");            
    $("#modalCRUD").modal("show");        
    id=null;
    opcion = 1; //alta
});  

$("#btnAtras").click(function(){
       
    window.location.replace("./intro.php");
});   
    
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text());
    nombre = fila.find('td:eq(1)').text();
    descripcion = fila.find('td:eq(2)').text();
    f_desde = fila.find('td:eq(3)').text();
    f_hasta = fila.find('td:eq(4)').text();
    id_entrenador = parseInt(fila.find('td:eq(5)').text());
    vol = parseFloat(fila.find('td:eq(6)').text());
    
    $("#id2").val(id);
    $("#nombre").val(nombre);
    $("#descripcion").val(descripcion); 
    $("#f_desde").val(f_desde);
    $("#f_hasta").val(f_hasta); 
    $("#id_entrenador").val(id_entrenador);
    $("#vol").val(vol);

    //console.log(id);
    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Macrociclo");            
    $("#modalCRUD").modal("show");  
    
});

//botón BORRAR
$(document).on("click", ".btnBorrar", function(){    
    fila = $(this);
    id = parseInt($(this).closest("tr").find('td:eq(0)').text());
    idurl= $("#idurl").val();
    opcion = 3 //borrar
    action='delete';

    var respuesta = confirm("¿Está seguro de eliminar el registro: "+id+"?");
    if(respuesta){
        $.ajax({
            url: "macro_maestro.php?action="+action,
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id:id},
            success: function(){
                tablaPersonas.row(fila.parents('tr')).remove().draw();
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
    

    

    //id = $.trim($("#id2").val());   
    nombre = $.trim($("#nombre").val());
    descripcion = $.trim($("#descripcion").val());
    f_desde = $.trim($("#f_desde").val());
    f_hasta = $.trim($("#f_hasta").val());
    id_entrenador = $.trim($("#id_entrenador").val());
    vol = $.trim($("#vol").val());
    idurl= $("#idurl").val();

    console.log(opcion);
    if(nombre ==''||descripcion==''||f_desde==''||f_hasta==''||id_entrenador==''||vol==''){
        alert("No pueden existir campos en Blanco");
        return false;
      }
    
    //return false;    
    $.ajax({
       // url: idurl+"bd/crud.php",
        url: "macro_maestro.php?action="+action,
        type: "POST",
        dataType: "json",
        data: {id:id,nombre:nombre, descripcion:descripcion, f_desde:f_desde, f_hasta:f_hasta, id_entrenador:id_entrenador, vol:vol, opcion:opcion},
        success: function(data){  
            //console.log(data);
            id = data[0].id;   
            console.log(id);         
            nombre = data[0].nombre;
            descripcion = data[0].descripcion; 
            f_desde= data[0].f_desde;
            f_hasta= data[0].f_hasta;
            id_entrenador= data[0].id_entrenador;
            vol= data[0].vol;
            if(opcion == 1){tablaPersonas.row.add([id,nombre,descripcion,f_desde,f_hasta,id_entrenador,vol]).draw();}
            else{tablaPersonas.row(fila).data([id,nombre,descripcion,f_desde,f_hasta,id_entrenador,vol]).draw();} 
                      
        }        
    });
    $("#modalCRUD").modal("hide");    
    
});    
    
});