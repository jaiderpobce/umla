$(document).ready(function(){
   

//----formulario de asignar detalle de marca--------------------------------------


$("#formarcas").submit(function(e){
    e.preventDefault(); 

   var opcion =0;
    //return false;
    if(opcion == 2){
        id = $.trim($("#id2").val());
       // console.log(id); 
      action='update';
    }else{
        action='add';
    }

    nom_genero= $('select[name="genero"] option:selected').text();
    id_maraca= "echo ";
    genero = $.trim($("#genero").val());   
    piscina = $.trim($("#piscina").val());
    edad_desde = $.trim($("#edad_desde").val());   
    edad_hasata = $.trim($("#edad_hasta").val());
    prueba = $.trim($("#prueba").val());   
    tiempo = $.trim($("#tiempo").val());
    atleta = $.trim($("#atleta").val());   
    fecha = $.trim($("#fecha").val());
    ubicacion = $.trim($("#ubicacion").val());
    ano_nac = $.trim($("#ano_nac").val());
    relevo = $.trim($("#relevo").val());


   // console.log('funciona ff '+' '+genero+' '+piscina+' '+nom_genero);
  //  return false;

   // idurl= $("#idurl").val();

    console.log(opcion);
 if(genero==''|| piscina ==''){
        alert("No pueden existir campos en Blanco");
        return false;
      }
    
    //return false;    
    $.ajax({
       // url: idurl+"bd/crud.php",
        url: "competencias_subir_marcas.php?action="+action,
        type: "POST",
        dataType: "json",
        data: {id_marca:id_maraca,tipo:tipo,nombre:nombre, opcion:opcion},
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




});