<!-- Scripts -->
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="loader"></div>
        <div clas="loader-txt">
          <p><small>Cargando...</small></p>
        </div>
      </div>
    </div>
  </div>
</div>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/popper.min.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/metisMenu.min.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/perfect-scrollbar.min.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/bootstrap.min.js"></script>
 
    
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/select2.min.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/bootstrap-select.min.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.multi-select.min.js"></script>
    
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/moment.min.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/fullcalendar.min.js"></script>
    
    <script type="text/javascript" src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.numeric.js"></script>
    
    <script src="assets/vendors/dropzone/min/dropzone.min.js"></script>
    
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/tablesaw.jquery.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/tablesaw-init.js"></script>

    
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.Rut.js" type="text/javascript"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.validate.js" type="text/javascript"></script>
     <!--<script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.form-validator.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>-->
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.maskedinput.js?v=3" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.numeric.js"></script>
    
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_PATH_CONTROL; ?>assets/js/wickedpicker.min.js"></script>
    <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/jquery.multi-select.min.js"></script>
    
	
	<script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/simple-expand.js"></script>

  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>-->
	
	
      <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/template.js"></script>
     <script src="<?php echo BASE_PATH_CONTROL; ?>assets/js/custom.js"></script>
    

 
    <?php if ($_page == 'intro') { ?>
    <script type="text/javascript">
    $(".numeric").numeric();
    $('.datepicker').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
function changeResp() {
        $(".conv_respuesta").change(function() {
            var id = this.id;
            var splitid = id.split('_');
            var index = splitid[1];
            var respuesta = $(this).val();
            
            if (respuesta == 1) {
                $("#serv_"+index).removeClass( "oculto" ); 
            } else {
                $("#serv_"+index).addClass( "oculto" ); 
            }
            console.log("index: "+index);
            //$('#chkcod_'+index).val('0');
        });
        }
        
        function formConvResp() {
        
                $(".formConf").submit(function(e) {
                    $("#loadMe").modal({
                        backdrop: "static", //remove ability to close modal with click
                        keyboard: false, //remove option to close with keyboard
                        show: true //Display loader!
                      });
                      
                    console.log("se envia el form");
                  var contador = $(this).attr('rel'); 
                  var id = $(this).attr('id'); 
                  var nadador = $("#nadador_"+contador).val();
                  var competencia = $("#competencia_"+contador).val();
                  console.log(id+" competencia: "+competencia+" nadador:"+nadador);
                  var url = "<?php $baseUrl?>apoderados_convocar_confirm.php";
                  console.log($("#"+id).serialize());
                  $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#"+id).serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                      //var result = $.parseJSON(data);
                      console.log(data);
                      //$("#lineOut_"+contador).html();
                      
                      if (data == 'ok') {
                            $("#form_"+contador).html("<div class=\"alert alert-icon alert-success border-success fade show\" role=\"alert\"><i class=\"material-icons list-icon\">check_circle</i>  <strong>Respuesta enviada!</strong> La respuesta a la convocatoria fue enviada.</div>");
                           $("#loadMe").modal("hide");
                      }           
                     

                    }
                  });

                  e.preventDefault(); // avoid to execute the actual submit of the form.
                });
                }
                
             function changeBus() {
                $(".bus").click(function(e) {
                    var contador = $(this).attr('rel');
                    if( $(this).is(':checked') ) {
                        $("#div_acompanantes_"+contador).removeClass( "oculto" ); 
                    } else {
                        $("#acompanantes_"+contador).val('0')
                        $("#div_acompanantes_"+contador).addClass( "oculto" );
                        
                    }
                    
                });
             }
             
             function changeAcompanantes() {
                $(".acompanantes").change(function(e) {
                    var id = this.id;
                    var splitid = id.split('_');
                    var index = splitid[1];
                    var cantidad = $(this).val();
                    $(".div_acomp_"+index).addClass( "oculto" );
                    for (var i=1; i<=cantidad; i++) {
                        console.log('intento ' + i);
                        $("#acomp_"+index+"_"+i).removeClass( "oculto" ); 
                    }
                     
                    
                    
                });
             }
             
             function chequearRutAcomp(){
    console.log("entro");
    
      $(".rut").change(function() {
          var id = this.id;
           var splitid = id.split('_');
            var index = splitid[2];
            var contador = splitid[1];
            $('#chkcod_'+contador+'_'+index).val('0');



      });

  $(".rut").blur(function() {
    var id = this.id;
    var splitid = id.split('_');
    var index = splitid[2];
    var contador = splitid[1];



    var valor = $(this).val();
    console.log(valor);
    var chkcod = $('#chkcod_'+contador+'_'+index).val();
                  console.log(chkcod);
       
     

    if (valor != '' && chkcod == 0) {
      $('#chkcod_'+contador+'_'+index).val('1');
      $("#loadMe").modal({
                        backdrop: "static", //remove ability to close modal with click
                        keyboard: false, //remove option to close with keyboard
                        show: true //Display loader!
                      });
      $.ajax({
                            url: "<?php echo BASE_PATH_CONTROL; ?>acompanante_check4.php",
                            type: 'post',
                            dataType: "json",
                            data: { rut: valor },
                            success: function( data ) {
                                console.log("llego");
                                jQuery.each(data, function(i, v){
                                  console.log("nombre"+v.nombre);
                                  // $(this).val(v.label); // display the selected text
                                  var codigo = v.value; 
                                  var nombre = v.nombre; // selected id to input
                                  var apellido = v.apellido;
                                  var direccion = v.direccion;
                                  var fecnac = v.fecnac;
                                  console.log(nombre+" - "+apellido);
                                  //document.getElementById('codigo_'+index).value = codigo;
                                  //document.getElementById('nombre_nadador_'+index).text = nombre+" "+apellido;
                                  //$("#nombre_nadador_"+index).html(nombre+" "+apellido);
                                  $("#nombre_"+contador+"_"+index).val(nombre);
                                  $("#apellido_"+contador+"_"+index).val(apellido);
                                  $("#direccion_"+contador+"_"+index).val(direccion);
                                  $("#fecnac_"+contador+"_"+index).val(fecnac);
                                  
                                  $("#loadMe").modal("hide");
                                  if (codigo == 0) {
                                      
                                      alert("No está registrado el acompañante complete los datos");
                                      
                                      
                                  } 
                                  

                                  

                                });
                                
                                

                                /*if (data === "false") {
                                  $(this).focus();
                                  alert("Error en el codigo");
                                }*/
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                //alert(xhr.status);
                                alert(thrownError);
                            }
                        });

    } else if (valor == '' && chkcod == 0) {
                                  //document.getElementById('nombre_nadador_'+index).text ="";
                                  $("#nombre_"+contador+"_"+index).val("");
                                  $("#apellido_"+contador+"_"+index).val("");
                                  $("#direccion_"+contador+"_"+index).val("");
                                  $("#fecnac_"+contador+"_"+index).val("");
                                  $('#chkcod_'+index).val('1');

    }
    //alert( "Handler for .blur() called." );
  });
}
  $(document).ready(function() {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },

      navLinks: true, // can click day/week names to navigate views

      eventLimit: true, // allow "more" link when too many events
      events: [
        <?php 
        foreach ($comp->row as $Elem) { 
            
?>
                        {
        title:"<?php echo $Elem['nombre']?>",
        start: '<?php echo $Elem['desde']." 00:00";?>', // a start time (10am in this example)
        end: '<?php echo $Elem['hasta']." 23:59";?>', // an end time (6pm in this example)
        url: '<?php echo BASE_PATH;?>competencias_det.php?id=<?php echo $Elem['id']?>',              
        textColor: '#fff'
            
    },<?php } ?>],
    
     
    });
  
    
    changeResp();
    formConvResp();
    changeBus();
    changeAcompanantes();
    chequearRutAcomp();
    $('.rut').Rut({  
        format_on: 'keyup'
    });

  });
  

      </script>
    <?php } ?>
    <?php if ($_page == 'pruebas') { ?>
    <script type="text/javascript">
        $(document).ready(function(){
          var nombre = '';
          $("#distancia, #estilo").change(function() {
              if ($('#distancia').val() != '' && $('#estilo').val() != '' && $('#nombre').val() == '') {
                  nombre = $('#distancia').val()+" mts. "+$('#estilo').val();
                  $('#nombre').val(nombre);
              }
        
          });
        })
    </script>
    
    <?php } ?>

    <?php if ($_page == 'usuarios_add' or $_page == 'usuarios_add_o' or $_page == 'nadadores' or $_page == 'usuarios_mod' or $_page == 'nadadores_mod' or $_page == 'misdatos') { ?>
    <script type="text/javascript">
        
    $("#bt_buscar").click(function() {
        var valor = $(this).attr('rel');
        console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
        
        
    });
    $('#rut, .rut_nadador').Rut({  
        format_on: 'keyup'
    });
    
     $.validator.addMethod("rut", function(value, element) {
  return this.optional(element) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");
    
    $("#formU").validate({
  rules: {
    <?php if ($_page != 'nadadores_add_o') { ?>
    rut: {
      required: true,
      rut:true
    },
    <?php } ?>
    nombre: {
      required: true
    },
    apellido: {
      required: true
    },
    email: {
      required: true,
      email: true
    }<?php if ($_page == 'nadadores') { ?>
    ,
    fecnac: {
      required: true
    }
    <?php } ?>
  },
    messages: {
       rut: {
        required: "Debe ingresar el rut",
        rut:"Este campo debe ser un rut valido"
      }, 
      nombre: {
        required: "Debe ingresar el nombre"
      },
      apellido: {
        required: "Debe ingresar el apellido"
      },
      email: {
        required: "Debe ingresar el email",
        email: "Debe ingresar un email válido"
      }<?php if ($_page == 'nadadores') { ?>
    ,
    fecnac: {
      required: "Debe ingresar fecha de nacimiento"
    }
    <?php } ?>
    }
});

function chequearRutNadador(){
    console.log("entro");

  $(".rut_nadador").blur(function() {
    var id = this.id;
    var splitid = id.split('_');
    var index = splitid[2];



    var valor = $(this).val();
    console.log(valor);
    var chkcod = $('#chkcod_'+index).val();
                  //console.log(valor);
       
     

    if (valor != '' && chkcod == 0) {
      $('#chkcod_'+index).val('1');
      $.ajax({
                            url: "<?php echo BASE_PATH_CONTROL; ?>nadador_check4.php",
                            type: 'post',
                            dataType: "json",
                            data: { rut: valor },
                            success: function( data ) {
                                jQuery.each(data, function(i, v){
                                  //console.log(v.codigo);
                                  // $(this).val(v.label); // display the selected text
                                  var codigo = v.value; 
                                  var nombre = v.nombre; // selected id to input
                                  var apellido = v.apellido;
                                  console.log(nombre+" - "+apellido);
                                  //document.getElementById('codigo_'+index).value = codigo;
                                  //document.getElementById('nombre_nadador_'+index).text = nombre+" "+apellido;
                                  $("#nombre_nadador_"+index).html(nombre+" "+apellido);
                                  
                                  if (codigo == 0) {
                                      alert("Error en el rut, no existe el nadador");
                                      $("#rut_nadador_"+index).focus();
                                      
                                  } else {                                

                                  

                                  var cant_nad = $('#cant_nad').val();

                                  

                                  }
                                  

                                  

                                });

                                /*if (data === "false") {
                                  $(this).focus();
                                  alert("Error en el codigo");
                                }*/
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                //alert(xhr.status);
                                alert(thrownError);
                            }
                        });

    } else if (valor == '' && chkcod == 0) {
        document.getElementById('nombre_nadador_'+index).text ="";
        $('#chkcod_'+index).val('1');

    }
    //alert( "Handler for .blur() called." );
  });
}

function chequearCod() {
  $(".rut_nadador").change(function() {
            var id = this.id;
            var splitid = id.split('_');
            var index = splitid[2];
            console.log("index: "+index);
            $('#chkcod_'+index).val('0');
  });
}

chequearCod();

$('#apoderado').click(function(){
    if($(this).is(':checked')) {  
            //alert("Está activado"); 
            $( "#nadadores" ).removeClass( "oculto" );
        } else {  
            $( "#nadadores" ).addClass( "oculto" );
        } 
});

$('#add_nadador').click(function(){

                // Get last id 
                
                var index = Number($( "#cant_nad" ).val()) + 1;

                // Create row with input elements
                //var html = "<div class='row row_producto'><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='codigo_"+index+"'>Código Producto</label><input type='text' class='form-control codigov' id='codigo_"+index+"' name='codigo_"+index+"'><input type='hidden' name='chkcod_"+index+"' id='chkcod_"+index+"' value='0'><input type='hidden' name='inventario_"+index+"' id='inventario_"+index+"'value='0'></div></div><div class='col-lg-4 col-md-4 col-xs-12'><div class='form-group'><label for='nombre_"+index+"'>Nombre Producto</label><input type='text' class='form-control nombre' id='nombre_"+index+"' name='nombre_"+index+"'></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='cant_"+index+"'>Cantidad a ingresar</label><input type='text' class='form-control numeric icant' id='cant_"+index+"' name='cant_"+index+"'></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='precio_"+index+"'>Precio unitario</label><input type='text' class='form-control numeric iprecio' id='precio_"+index+"' name='precio_"+index+"' readonly></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='precio_"+index+"'>Total</label><input type='text' class='form-control numeric' id='total_"+index+"' name='total_"+index+"' readonly></div></div></div>";
                
                var html = "<div class=\"nadador_"+index+"\"><label class=\"form-control-label\">Rut Nadador "+index+"</label><input class=\"form-control rut_nadador\" rel=\""+index+"\" id=\"rut_nadador_"+index+"\" name=\"rut_nadador_"+index+"\" placeholder=\"Rut nadador\" type=\"text\"><input type='hidden' name='chkcod_"+index+"' id='chkcod_"+index+"' value='0'><div id=\"nombre_nadador_"+index+"\"></div></div>";
                // Append data
                


                $( "#cant_nad" ).val(index);
                $('#nadadores_group').append(html);
                //$(".numeric").numeric();
                $('.rut_nadador').Rut({  
                    format_on: 'keyup'
                });
                chequearRutNadador();
                chequearCod();
                  $( "#rut_nadador_"+index ).focus();
               
         
                
            });
            
            chequearRutNadador();
            chequearCod();
            
            $('.datepicker').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
            
            $(".a_elim").change(function() {
  var id = this.id;
    var splitid = id.split('_');
    var index = splitid[2];
    //console.log(index);

    if(this.checked) {
     // console.log('#row_pro_'+index);
        $('#row_pro_'+index).addClass("tachado");
    } else {
        $('#row_pro_'+index).removeClass("tachado");
    }

});
</script>
    <?php } ?>

<?php if ($_page == 'misdatos') { ?>
<script type="text/javascript">
	
		Dropzone.autoDiscover = false;
		$("#dropzone").dropzone({
			url: "<?php $baseUrl?>uploads/perfil.php",
			addRemoveLinks: true,
			dictResponseError: "Ha ocurrido un error en el server",
			acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
			uploadMultiple: false,
			maxFiles: 1,
			maxfilesexceeded: function(file) {
        		this.removeAllFiles();
				this.addFile(file);
			},
			params: {
				id: '',
				tipo: '0'
			},
			complete: function(file, response)
			{
				if(file.status == "success")
				{
          console.log(response);
          //alert("El siguiente archivo ha subido correctamente: " + response);
          $( "#foto_perfil" ).load( "<?php $baseUrl?>foto_perfil.php", function() {

          // $( "#foto_perfil" ).html( "<img src=\"<?php $baseUrl?>uploads/perfil_<?php echo $authj->rowff['id'];?>"+response['target_file']+".jpg\">", function() {
          //$('#nuevoCentro').modal().hide();
          $('.bs-modal-lg-primary').modal('hide');
					});
					this.removeFile(file);
					
				}
			},
			error: function(file)
			{
				alert("Error subiendo el archivo " + file.name);
			},
			removedfile: function(file, serverFileName)
			{
				var name = file.name;
				
							var element;
							(element = file.previewElement) != null ? 
							element.parentNode.removeChild(file.previewElement) : 
							false;
					
			}
		});
  
                
                </script>
<?php } ?>


<?php if ($_page == 'competencias_add') { ?>
<script type="text/javascript">
	
		Dropzone.autoDiscover = false;
		$("#dropzone").dropzone({
			url: "<?php echo $baseUrl?>uploads/competencias_zip.php",
			addRemoveLinks: true,
			dictResponseError: "Ha ocurrido un error en el server",
			acceptedFiles: '.zip,.ZIP',
			uploadMultiple: false,
			maxFiles: 1,
			maxfilesexceeded: function(file) {
        		this.removeAllFiles();
				this.addFile(file);
			},
			params: {
				id: '',
     
				tipo: '0'
			},
			complete: function(file, response)
			{
				if(file.status == "success")
				{
          console.log(response);
          //location.href = '/competencias.php';


          //alert("El siguiente archivo ha subido correctamente: " + response);
         /* $( "#foto_perfil" ).load( "<?php $baseUrl?>foto_perfil.php", function() {

          // $( "#foto_perfil" ).html( "<img src=\"<?php $baseUrl?>uploads/perfil_<?php echo $authj->rowff['id'];?>"+response['target_file']+".jpg\">", function() {
          //$('#nuevoCentro').modal().hide();
          $('.bs-modal-lg-primary').modal('hide');
					});
          */
					this.removeFile(file);
					
				}
			},
			error: function(file)
			{
				alert("Error subiendo el archivo " + file.name);
			},
			removedfile: function(file, serverFileName)
			{
				var name = file.name;
				
							var element;
							(element = file.previewElement) != null ? 
							element.parentNode.removeChild(file.previewElement) : 
							false;
					
			}
		});
  
                
                </script>
<?php } ?>
<?php if ($_page == 'competencias_upload_result2') { ?>

<script type="text/javascript">

  Dropzone.autoDiscover = false;
  $("#dropzone2").dropzone({
    url: "<?php echo $baseUrl?>f45t/subir_Resultado2_zip.php",
    addRemoveLinks: true,
    dictResponseError: "Ha ocurrido un error en el server",
    acceptedFiles: '.zip,.ZIP',
    uploadMultiple: false,
    maxFiles: 1,
    maxfilesexceeded: function(file) {
          this.removeAllFiles();
      this.addFile(file);
    },
    params: {
      id: '',
      compet: '<?php echo $id?>',
      id_ent: '<?php echo $id_ent?>',
      tipo: '0'
    },
    complete: function(file, response)
    {
      if(file.status == "success")
      {
       // console.log(response);
        //location.href = '/competencias.php';
        //alert("El siguiente archivo ha subido correctamente: " + response);
       /* $( "#foto_perfil" ).load( "<?php $baseUrl?>foto_perfil.php", function() {

        // $( "#foto_perfil" ).html( "<img src=\"<?php $baseUrl?>uploads/perfil_<?php echo $authj->rowff['id'];?>"+response['target_file']+".jpg\">", function() {
        //$('#nuevoCentro').modal().hide();
        $('.bs-modal-lg-primary').modal('hide');
        });
        */
        //this.removeFile(file);
        alert("subido el archivo " );
      }
    },
    error: function(file)
    {
      alert("Error subiendo el archivo " + file.name);
    },
    removedfile: function(file, serverFileName)
    {
      var name = file.name;
      
            var element;
            (element = file.previewElement) != null ? 
            element.parentNode.removeChild(file.previewElement) : 
            false;
        
    }
  });

              
              </script>

<?php } ?>







<?php if ($_page == 'archivo_upload') { ?>

  <script type="text/javascript">
	
  Dropzone.autoDiscover = false;
  $("#dropzone_archivo").dropzone({
    url: "<?php echo $baseUrl?>f45t/subir_Archivo_zip.php",
    addRemoveLinks: true,
    dictResponseError: "Ha ocurrido un error en el server",
    acceptedFiles: '.zip,.ZIP',
    uploadMultiple: false,
    maxFiles: 1,
    maxfilesexceeded: function(file) {
          this.removeAllFiles();
      this.addFile(file);
    },
    params: {
      id: '<?php echo $authj->rowff['id'];?>',
      tipo: '0'
    },
    complete: function(file, response)
    {
      if(file.status == "success")
      {
       // console.log(response);
        //location.href = '/competencias.php';
        //alert("El siguiente archivo ha subido correctamente: " + response);
       /* $( "#foto_perfil" ).load( "<?php $baseUrl?>foto_perfil.php", function() {

        // $( "#foto_perfil" ).html( "<img src=\"<?php $baseUrl?>uploads/perfil_<?php echo $authj->rowff['id'];?>"+response['target_file']+".jpg\">", function() {
        //$('#nuevoCentro').modal().hide();
        $('.bs-modal-lg-primary').modal('hide');
        });
        */
        //this.removeFile(file);
        alert("subido el archivo " );
      }
    },
    error: function(file)
    {
      alert("Error subiendo el archivo " + file.name);
    },
    removedfile: function(file, serverFileName)
    {
      var name = file.name;
      
            var element;
            (element = file.previewElement) != null ? 
            element.parentNode.removeChild(file.previewElement) : 
            false;
        
    }
  });
  
                
                </script>

  <?php } ?>

<?php if ($_page == 'competencias' || $_page == 'competencias_add') { ?>
<script type="text/javascript">
$('.expander').simpleexpand();

    $('.datepicker').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
    $('.datepicker1').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
    $('.datepickerd').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
    $('.timepicker').wickedpicker({
        title: '',
        now: "09:00",
        twentyFour: true,
        timeSeparator: ':'
    });
    $('.pickdesde').change(function(){
        
        $('.datepicker1').datepicker('setStartDate', $('.pickdesde').val());
        $('.datepicker1').datepicker('update', $('.pickdesde').val());
        
    });
    $('.pickhasta').change(function(){
        
        $('.datepicker1').datepicker('setEndDate', $('.pickhasta').val());
        
    });
            
   
    
    $('#federacion').change(function(){
        //console.log($('#federacion').val());
        var valor = $('#federacion').val();
        console.log(valor);
        if (valor == '') {
            $( "#box_categorias" ).addClass( "oculto" );
        } else {
            $( "#box_categorias" ).removeClass( "oculto" );
            $.ajax({
                            url: "<?php echo BASE_PATH_CONTROL; ?>competencias_categorias.php",
                            type: 'post',
                            data: { federacion: valor },
                            success: function( data ) {
                                //console.log("lo hizo"+data);
                                $("#lacategorias0" ).html(data);
                                $( "#lacategorias0" ).multiSelect("destroy").multiSelect();
                                //$('#lacategorias0').multiSelect();
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                               alert(xhr.status);
                                //alert(thrownError);
                            }
                        });
        }
        
        

         
    });
    
    $('#add_jornada').click(function(){

                // Get last id 
                
                var index = Number($( "#cant_jor" ).val()) + 1;

                // Create row with input elements
                //var html = "<div class='row row_producto'><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='codigo_"+index+"'>Código Producto</label><input type='text' class='form-control codigov' id='codigo_"+index+"' name='codigo_"+index+"'><input type='hidden' name='chkcod_"+index+"' id='chkcod_"+index+"' value='0'><input type='hidden' name='inventario_"+index+"' id='inventario_"+index+"'value='0'></div></div><div class='col-lg-4 col-md-4 col-xs-12'><div class='form-group'><label for='nombre_"+index+"'>Nombre Producto</label><input type='text' class='form-control nombre' id='nombre_"+index+"' name='nombre_"+index+"'></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='cant_"+index+"'>Cantidad a ingresar</label><input type='text' class='form-control numeric icant' id='cant_"+index+"' name='cant_"+index+"'></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='precio_"+index+"'>Precio unitario</label><input type='text' class='form-control numeric iprecio' id='precio_"+index+"' name='precio_"+index+"' readonly></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='precio_"+index+"'>Total</label><input type='text' class='form-control numeric' id='total_"+index+"' name='total_"+index+"' readonly></div></div></div>";
                
                //var html = "<div class=\"nadador_"+index+"\"><label class=\"form-control-label\">Rut Nadador "+index+"</label><input class=\"form-control rut_nadador\" rel=\""+index+"\" id=\"rut_nadador_"+index+"\" name=\"rut_nadador_"+index+"\" placeholder=\"Rut nadador\" type=\"text\"><input type='hidden' name='chkcod_"+index+"' id='chkcod_"+index+"' value='0'><div id=\"nombre_nadador_"+index+"\"></div></div>";
                var html = "<div class=\"row\"><div class=\"col-md-6\"><label class=\"form-control-label\">Jornada "+index+": Fecha</label><input type=\"text\" class=\"form-control datepicker1\" name=\"fec_jornada_"+index+"\"></div><div class=\"col-md-6\"><label class=\"form-control-label\">Hora</label><input type=\"text\" class=\"form-control timepicker\" name=\"hora_jornada_"+index+"\"></div></div>";
// Append data
                


                $( "#cant_jor" ).val(index);
                $('#contenido_jornadas').append(html);
                //$(".numeric").numeric();
                $('.datepicker1').datepicker({
                    format: 'yyyy/mm/dd',
                    autoclose: true,
                    startDate: $('.pickdesde').val(),
                    endDate: $('.pickhasta').val()
                });
                $('.timepicker').wickedpicker({
                    title: '',
                    now: "09:00",
                    twentyFour: true,
                    timeSeparator: ':'
                });
             
                //  $( "#rut_nadador_"+index ).focus();
               
         
                
            });
</script>


<?php } ?>
<?php if ($_page == 'competencias_reporte') { ?>
<script type="text/javascript">
    //$( "#competencias" ).multiSelect("destroy").multiSelect();
    
    $(document).ready(function() {
        /*
          var last_valid_selection = null;

          $('#competencias').change(function(event) {
              console.log("entra al cambio: "+$(this).val().length);
              
            if ($(this).val().length > 3) {

              $(this).val(last_valid_selection);
            } else {
              last_valid_selection = $(this).val();
            }
          });
        */
       $('#competencias').multiSelect({
            afterSelect: function(values){
                
              console.log();
              if ($('#competencias').val().length > 7) {
                  $('#competencias').multiSelect('deselect', values);
              }
              //alert("Select value: "+values);
            },
            afterDeselect: function(values){
              //alert("Deselect value: "+values);
            }
          });
        });
        
        
    </script>


<?php } ?>
<?php if ($_page == 'competencias_marcas_xnadador') { ?>
<script type="text/javascript">
    $(".vermasmarc").click(function(e) {
        var id = this.id;
            var splitid = id.split('_');
            var indext = splitid[1];
            
            var estado = $(this).attr('rel');
            
            
                    if( estado == 'menos' ) {
                       $(this).attr('rel', 'mas');
                        $(".oculto_"+indext).removeClass( "oculto" ); 
                        $("#vermasmarc_"+indext).html('<i class="fas fa-minus-circle"></i> Ver menos');
                    } else {
                         $(this).attr('rel', 'menos');
                        $(".oculto_"+indext).addClass( "oculto" ); 
                        $("#vermasmarc_"+indext).html('<i class="fas fa-plus-circle"></i> Ver todas las marcas');
                    }
                    
                });
    </script>
<?php } ?>

<?php if ($_page == 'notas_maestro') { ?>
<script type="text/javascript">
   $("#bt_buscar").click(function() {
        var valor = $(this).attr('rel');
        console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
        
        
    });
    </script>
<?php } ?>
<?php //echo $_page;
if ($_page == 'competencias_pruebas' or $_page == 'competencias_subir_marcas' or $_page == 'nadadores_marcas' or $_page == 'competencias_marcas' or $_page == 'vldz_tmps' or $_page == 'vldz_pronostico' or $_page == 'competencias_marcas_conf') { ?>
<script type="text/javascript">
  /*  var options = {
        <?php foreach ($estilos as $Elem) { ?>
                <?php echo $Elem; ?> : [<?php foreach (${$estilo} as $Dist) { echo "\"".$Dist."\","; } ?>],
        <?php } ?>
  }*/

<?php //echo $_page;
if ($_page == 'vldz_tmps' or $_page == 'vldz_pronostico') {
    $procesador = "pruebas_distancias1.php";
 } else {
    $procesador = "pruebas_distancias.php";
 } ?>

function inputEstilos() {
$('.estilos').change(function(){
            var id = this.id;
            var splitid = id.split('_');
            var indext = splitid[1];
            //console.log("index: "+indext);
            //$('#estilo_'+indext).val('0');
            valor = $('#estilo_'+indext).val();
            //console.log("estilo: "+valor);
            $.ajax({
                            url: "<?php echo BASE_PATH_CONTROL.$procesador; ?>",
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
}
inputEstilos();
<?php if ($_page == 'competencias_pruebas' or $_page == 'nadadores_marcas') { ?>
$('#add_prueba').click(function(){

                // Get last id 
                
                
                var index = Number($( "#cant_pru" ).val()) + 1;
                
                console.log("test"+index);

                // Create row with input elements
                //var html = "<div class='row row_producto'><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='codigo_"+index+"'>Código Producto</label><input type='text' class='form-control codigov' id='codigo_"+index+"' name='codigo_"+index+"'><input type='hidden' name='chkcod_"+index+"' id='chkcod_"+index+"' value='0'><input type='hidden' name='inventario_"+index+"' id='inventario_"+index+"'value='0'></div></div><div class='col-lg-4 col-md-4 col-xs-12'><div class='form-group'><label for='nombre_"+index+"'>Nombre Producto</label><input type='text' class='form-control nombre' id='nombre_"+index+"' name='nombre_"+index+"'></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='cant_"+index+"'>Cantidad a ingresar</label><input type='text' class='form-control numeric icant' id='cant_"+index+"' name='cant_"+index+"'></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='precio_"+index+"'>Precio unitario</label><input type='text' class='form-control numeric iprecio' id='precio_"+index+"' name='precio_"+index+"' readonly></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='precio_"+index+"'>Total</label><input type='text' class='form-control numeric' id='total_"+index+"' name='total_"+index+"' readonly></div></div></div>";
                
                //var html = "<div class=\"nadador_"+index+"\"><label class=\"form-control-label\">Rut Nadador "+index+"</label><input class=\"form-control rut_nadador\" rel=\""+index+"\" id=\"rut_nadador_"+index+"\" name=\"rut_nadador_"+index+"\" placeholder=\"Rut nadador\" type=\"text\"><input type='hidden' name='chkcod_"+index+"' id='chkcod_"+index+"' value='0'><div id=\"nombre_nadador_"+index+"\"></div></div>";
                var html = "<tr><td><select name=\"jornada_"+index+"\" id=\"jornada_"+index+"\" class=\"form-control\"><option value=\"\">Jornada</option><?php  foreach ($comp->row[0]['jornadas'] as $Jorna) {  ?><option value=\"<?php echo $Jorna['id'];?>\">Jornada <?php echo $Jorna['orden'];?></option><?php } ?></select><select name=\"estilo_"+index+"\" id=\"estilo_"+index+"\" class=\"form-control estilos\"><option value=\"\">Estilo</option><option value=\"Libre\">Libre</option><option value=\"Espalda\">Espalda</option><option value=\"Pecho\">Pecho</option><option value=\"Mariposa\">Mariposa</option><option value=\"Combinado\">Combinado</option></select><select name=\"distancia_"+index+"\" id=\"distancia_"+index+"\" class=\"form-control distancias\" disabled=\"true\"><option value=\"\">Distancia</option></select></td><td><select class=\"form-control categorias\" name=\"categorias_"+index+"\[]\" multiple=\"multiple\" data-toggle=\"select2\" data-plugin-options='{\"minimumResultsForSearch\": -1}'><?php  foreach ($comp->row[0]['categorias'] as $Cate) {  ?><option value=\"<?php echo $Cate['id'];?>\"><?php echo $Cate['nombre_cat'];?></option><?php } ?></select></td><td><div class=\"row\"><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"prueba_f_"+index+"\"># prueba Fem</label><div class=\"col-sm-9\"> <input class=\"form-control\" id=\"prueba_f_"+index+"\" name=\"prueba_f_"+index+"\" placeholder=\"\" type=\"text\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marca_f_"+index+"\">Marca mínima</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marca_f_"+index+"\" name=\"marca_f_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\" maxlength=\"6\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"maxn_f_"+index+"\">Num max nadadores</label><div class=\"col-sm-9\"> <input type=\"number\" min=\"0\" step=\"1\" id=\"maxn_f_"+index+"\" name=\"maxn_f_"+index+"\" class=\"form-control\" ></div></div></td><td><div class=\"row\"><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"prueba_m_"+index+"\"># prueba Masc</label><div class=\"col-sm-9\"> <input class=\"form-control\" id=\"prueba_m_"+index+"\" name=\"prueba_m_"+index+"\" placeholder=\"\" type=\"text\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marca_m_"+index+"\">Marca mínima</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marca_m_"+index+"\" name=\"marca_m_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\" maxlength=\"6\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"maxn_m_"+index+"\">Num max nadadores</label><div class=\"col-sm-9\"> <input type=\"number\" min=\"0\" step=\"1\" id=\"maxn_m_"+index+"\" name=\"maxn_m_"+index+"\" class=\"form-control\" ></div></div></td></tr>";
                //// Append data
                


                $( "#cant_pru" ).val(index);
                $('#table_pruebas').append(html);
                //$(".numeric").numeric();
               // $('#table_pruebas').table().data( "table" )
               $( ".categorias" ).select2();
               //$('#table_pruebas').table().data( "table" ).refresh();
               Tablesaw.init();
                
                
                inputEstilos();
             
                //  $( "#rut_nadador_"+index ).focus();
               
         
                
            });
            <?php } ?>

            
            
            <?php if ($_page == 'competencias_marcas' or $_page == 'competencias_marcas_conf') { ?>
$('#add_marca').click(function(){

                // Get last id 
                
                
                var index = Number($( "#cant_pru" ).val()) + 1;
                
                console.log("test"+index);

                // Create row with input elements
                //var html = "<div class='row row_producto'><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='codigo_"+index+"'>Código Producto</label><input type='text' class='form-control codigov' id='codigo_"+index+"' name='codigo_"+index+"'><input type='hidden' name='chkcod_"+index+"' id='chkcod_"+index+"' value='0'><input type='hidden' name='inventario_"+index+"' id='inventario_"+index+"'value='0'></div></div><div class='col-lg-4 col-md-4 col-xs-12'><div class='form-group'><label for='nombre_"+index+"'>Nombre Producto</label><input type='text' class='form-control nombre' id='nombre_"+index+"' name='nombre_"+index+"'></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='cant_"+index+"'>Cantidad a ingresar</label><input type='text' class='form-control numeric icant' id='cant_"+index+"' name='cant_"+index+"'></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='precio_"+index+"'>Precio unitario</label><input type='text' class='form-control numeric iprecio' id='precio_"+index+"' name='precio_"+index+"' readonly></div></div><div class='col-lg-2 col-md-2 col-xs-12'><div class='form-group'><label for='precio_"+index+"'>Total</label><input type='text' class='form-control numeric' id='total_"+index+"' name='total_"+index+"' readonly></div></div></div>";
                
                //var html = "<div class=\"nadador_"+index+"\"><label class=\"form-control-label\">Rut Nadador "+index+"</label><input class=\"form-control rut_nadador\" rel=\""+index+"\" id=\"rut_nadador_"+index+"\" name=\"rut_nadador_"+index+"\" placeholder=\"Rut nadador\" type=\"text\"><input type='hidden' name='chkcod_"+index+"' id='chkcod_"+index+"' value='0'><div id=\"nombre_nadador_"+index+"\"></div></div>";
                var html = "<tr><td><select name=\"estilo_"+index+"\" id=\"estilo_"+index+"\" class=\"form-control estilos\"><option value=\"\">Estilo</option><option value=\"Libre\">Libre</option><option value=\"Espalda\">Espalda</option><option value=\"Pecho\">Pecho</option><option value=\"Mariposa\">Mariposa</option><option value=\"Combinado\">Combinado</option></select><select name=\"distancia_"+index+"\" id=\"distancia_"+index+"\" class=\"form-control distancias\"><option value=\"\">Distancia</option></select></td><td><div class=\"row\"><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marcaa_f_"+index+"\">Marca A</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marcaa_f_"+index+"\" name=\"marcaa_f_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marcab_f_"+index+"\">Marca B</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marcab_f_"+index+"\" name=\"marcab_f_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marcac_f_"+index+"\">Marca C</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marcac_f_"+index+"\" name=\"marcac_f_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marcad_f_"+index+"\">Marca D</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marcad_f_"+index+"\" name=\"marcad_f_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\"></div></div></td><td><div class=\"row\"><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marcaa_m_"+index+"\">Marca A</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marcaa_m_"+index+"\" name=\"marcaa_m_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marcab_m_"+index+"\">Marca B</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marcab_m_"+index+"\" name=\"marcab_m_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marcac_m_"+index+"\">Marca C</label> <div class=\"col-sm-9\"> <input type=\"text\" id=\"marcac_m_"+index+"\" name=\"marcac_m_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\"></div><label class=\"col-form-label col-sm-3 mb-0 text-left text-sm-right\" for=\"marcad_m_"+index+"\">Marca D</label><div class=\"col-sm-9\"> <input type=\"text\" id=\"marcad_m_"+index+"\" name=\"marcad_m_"+index+"\" class=\"form-control mb-0\" data-masked-input=\"99:99.99\" placeholder=\"mm:ss.ms\"></div></div></td></tr>";
                ////// Append data
                


                $( "#cant_pru" ).val(index);
                $('#table_pruebas').append(html);
                
               //$( ".categorias" ).select2();
               Tablesaw.init();
                
                
                inputEstilos();
             
                //  $( "#rut_nadador_"+index ).focus();
               
         
                
            });
            <?php } ?>
            <?php $uniquevalor= uniqid();?>
            Dropzone.autoDiscover = false;
		$("#dropzone").dropzone({
			url: "<?php $baseUrl?>uploads/excel_pruebas.php",
			addRemoveLinks: true,
			dictResponseError: "Ha ocurrido un error en el server",
                        uploadMultiple: false,
			maxFiles: 1,
			maxfilesexceeded: function(file) {
        		this.removeAllFiles();
				this.addFile(file);
			},
			params: {
				id: '',
				tipo: '0',
                                unico : '<?php echo $uniquevalor;?>'
			},
			complete: function(file, response)
			{
				if(file.status == "success")
				{
                                        console.log(file);
					
						$('.bs-modal-lg-primary').modal('hide');
					location.href ="competencias_pruebas.php?id=<?php echo $id;?>&valor=<?php echo $uniquevalor;?>";
					this.removeFile(file);
					
				}
			},
			error: function(file)
			{
				alert("Error subiendo el archivo " + file.name);
			},
			removedfile: function(file, serverFileName)
			{
				var name = file.name;
				
							var element;
							(element = file.previewElement) != null ? 
							element.parentNode.removeChild(file.previewElement) : 
							false;
					
			}
		});
</script>
<?php } ?>

<?php if ($_page == 'competencias_convocatoria') { ?>
<script type="text/javascript">
    $('.datepicker').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                startDate: '<?php echo $dayhoy;?>',
                endDate: '<?php echo $comp->row[0]['desde'];?>'
            });
            
    $("#checkAll").click(function(){
        console.log("hizo click1");
        $("input[type='checkbox'].inp_ck").attr('checked', true);   
    });
    $("#descheckAll").click(function(){
        console.log("hizo click");
        $("input[type='checkbox'].inp_ck").attr('checked', false);   
    });

    $('#local').click(function(){
    if($(this).is(':checked')) {  
            //alert("Está activado");
            $( "#box_admin" ).addClass( "oculto" );            
        } else {  
            $( "#box_admin" ).removeClass( "oculto" );
        } 
    });
    
    
    $(".formOut").submit(function(e) {
          var contador = $(this).attr('rel'); 
          var id = $(this).attr('id'); 
          console.log(id+" rel: "+contador);
          var url = "<?php $baseUrl?>competencias_convocatoria_add_ind.php";

          $.ajax({
            type: "POST",
            url: url,
            data: $("#"+id).serialize(), // serializes the form's elements.
            success: function(data)
            {
              //var result = $.parseJSON(data);
              //console.log(result);
              //$("#lineOut_"+contador).html();
              if (data == 'ok') {
                    $("#tab_convocados").load("<?php $baseUrl?>competencias_convocatoria_convocados.php?id=<?php echo $id;?>")
                    $("#lineOut_"+contador).addClass( "oculto" ); 
              }              

            }
          });

          e.preventDefault(); // avoid to execute the actual submit of the form.
        });
        
        function changeResp() {
        $(".conv_respuesta").change(function() {
            var id = this.id;
            var splitid = id.split('_');
            var index = splitid[1];
            var respuesta = $(this).val();

            console.log(respuesta+" "+"#serv_"+index);
            
            if (respuesta == 1) {
                $("#serv_"+index).removeClass( "oculto" ); 
            } else {
                $("#serv_"+index).addClass( "oculto" ); 
            }
            console.log("index: "+index);
            //$('#chkcod_'+index).val('0');
        });
        }
        
       
       

        function formConvResp() {
        
                $(".send_conv").click(function(e) {
                    var cont = 1;
                    forma = $(this).attr('rel');
                     $("#loadMe").modal({
                        backdrop: "static", //remove ability to close modal with click
                        keyboard: false, //remove option to close with keyboard
                        show: true //Display loader!
                      });
                  var contador = $("#"+forma).attr('rel'); 
                  var id = $("#"+forma).attr('id'); 
                  var nadador = $("#nadador_"+contador).val();
                  console.log(id+" rel: "+contador);
                  console.log("contador:"+cont);
                  var url = "<?php $baseUrl?>competencias_convocar_confirm.php";
                  console.log($("#"+id).serialize());
                  $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#"+id).serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                      //var result = $.parseJSON(data);
                      console.log(data);
                      cont++;
                      //$("#lineOut_"+contador).html();
                      if (data == 'ok') {
                        //REVISARR********************
                            $("#conv_linea_"+contador).load("<?php $baseUrl?>competencias_conv_convocados_action.php?id=<?php echo $id;?>&contador="+contador+"&nadador="+nadador+"&viajax=1", function() {
                                    $("#loadMe").modal("hide");
                                });
                            //location.href ="competencias_convocatoria.php?id=<?php echo $id;?>";
                    
                      }   
                      
                      
                    }
                  });

                  e.preventDefault(); // avoid to execute the actual submit of the form.
                });
                
                $(".elim_resp").click(function(e) {
                var contador = $(this).attr('rel'); 
                var url = $(this).attr('href'); 
                var nadador = $("#nadador_"+contador).val();
                var categoria = $("#categoria_"+contador).val();
                //var id = $("competencia_"+contador).val();
                console.log(url);
                console.log(nadador);
                console.log(categoria);
                $.ajax({
                    
                    url: url,
                    success: function(data)
                    {
                      console.log(data);
                      if (data == 'ok') {
                            //console.log("llego hasta aqui");
                            $("#conv_linea_"+contador).load("<?php $baseUrl?>competencias_conv_convocados_action.php?id=<?php echo $id;?>&contador="+contador+"&nadador="+nadador);
                    
                      }              

                    }
                  });
                
                 e.preventDefault(); // avoid to execute the actual submit of the form.
                });
                
                 
        
        }
        
        
        changeResp();
        formConvResp();
  
  
</script>
<?php } ?>
<?php if ($_page == 'competencias_asistentes') { ?>
<script type="text/javascript">
    $("#formato").click(function(e) {
                    if( $(this).is(':checked') ) {
                        $("#items_extra").addClass( "oculto" ); 
                    } else {
                        $("#items_extra").removeClass( "oculto" ); 
                    }
                    
                });
</script>
<?php } ?>
<?php if ($_page == 'competencias_relevos') { ?>
<script type="text/javascript">
    $("#prioridad").change(function() {
            var id = this.id;

            var respuesta = $(this).val();
            
            if (respuesta == 1) {
                $("#group_tiempo_marca").removeClass( "oculto" ); 
            } else {
                $("#group_tiempo_marca").addClass( "oculto" );
            }
            console.log("#w_"+id);
            //$('#chkcod_'+index).val('0');
        });
        
        $("#checkAll").click(function(){
        console.log("hizo click1");
        $("input[type='checkbox'].inp_ck").attr('checked', true);   
    });
    $("#descheckAll").click(function(){
        console.log("hizo click");
        $("input[type='checkbox'].inp_ck").attr('checked', false);   
    });
    
    $("#frm_relevo").submit(function(e){
        
        var cant = $("#conta_nad").val();
        var cont = 0;
        //console.log("empezamos a contar:"+cant);
        for (var i=1; i<=cant; i++) {
            console.log("verificamos #p_nadador_"+i);
                        if($('#p_nadador_'+i).is(':checked')) {                         
                            cont++;
                            //console.log("aqui va 1");
                        }
                    }
       if (cont >= 4) {
           return;
           
       }
       alert ("debes seleccionar al menos 4 nadadores");
        e.preventDefault();
    });
    
    </script>
  <?php } ?>  
 <?php if ($_page == 'competencias_relevos_paso1') { ?>
<script type="text/javascript">      
    $(".tiemposel").change(function() {
            var id = this.id;

            var respuesta = $(this).val();
            
            if (respuesta == 't') {
                $("#marca_"+id).removeClass( "oculto" ); 
            } else {
                $("#marca_"+id).addClass( "oculto" );
            }
            console.log("#marca_"+id);
            //$('#chkcod_'+index).val('0');
        });
        </script>
  <?php } ?>  
<?php if ($_page == 'competencias_res_temp') { ?>
<script type="text/javascript">
$(".marca").blur(function(e) {
                    forma = $(this).attr('rel');
                    
                  //var contador = $("#forma_"+forma).attr('rel'); 
                  
                  var url = "<?php $baseUrl?>competencias_temp_marca.php";
                  console.log($("#forma_"+forma).serialize());
                  $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#forma_"+forma).serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                      //var result = $.parseJSON(data);
                      console.log(data);
                      //$("#lineOut_"+contador).html();
                      if (data == 'ok') {
                          console.log("guardado");
                        //REVISARR********************
                           /* $("#conv_linea_"+contador).load("<?php $baseUrl?>competencias_conv_convocados_action.php?id=<?php echo $id;?>&contador="+contador+"&nadador="+nadador, function() {
                                    $("#loadMe").modal("hide");
                                });*/
                            //location.href ="competencias_convocatoria.php?id=<?php echo $id;?>";
                            $("#resul_"+forma).html("<span class=\"azul\">Guardado</span>");
                            $("#celda_"+forma).css("background-color", "#a0ffad");
                            //$("#forma_"+forma+" #marca").val("");
                      }   else {
                          //console.log(data);
                          $("#resul_"+forma).html("<span class=\"roja\">Error</span>");
                          $("#celda_"+forma).css("background-color", "#fdafa0");
                          $("#forma_"+forma+" #marca").val("");
                      }
                      
                      
                    }
                  });

                  e.preventDefault(); // avoid to execute the actual submit of the form.
                });
</script>
<?php } ?>
<?php if ($_page == 'competencias_resultados') { ?>
<script type="text/javascript">

 $( ".select_nadador" ).select2();
    $(".select_nadador").change(function() {
            var id = this.id;

            var respuesta = $(this).val();
            
            if (respuesta == '') {
                $("#w_"+id).removeClass( "oculto" ); 
            } else {
                $("#w_"+id).addClass( "oculto" );
            }
            console.log("#w_"+id);
            //$('#chkcod_'+index).val('0');
        });
    </script>
<?php } ?>
<?php if ($_page == 'competencias_conf_pruebas') { ?>
<script type="text/javascript">
    function iniciarCuentas() {
        $("#pru_warning").addClass( "oculto" );
         contarInscripciones();  
         contaJornadas();
    }
    
    function contarInscripciones() {
        var contador = 0;
        $(".inscribir").each(function(){
			if($(this).is(":checked")) {
				contador++;
                            }
		});
                
                $('#pru_insc').html(contador);
                <?php if ($max_pruebas > 0) { ?>
                        if (contador > <?php echo $max_pruebas;?>) {
                            $("#pru_warning").removeClass( "oculto" );
                            alert("Estás inscribiendo mas pruebas que las permitidas en la competencia");                            
                        } else {
                           // $("#pru_warning").addClass( "oculto" );
                        }
                <?php } ?>
                     
    }
    function contaJornadas() {
        <?php if ($max_jornadas > 0 and !empty($arrayJor)) { ?>
            <?php foreach ($arrayJor as $idJor) { ?>
                var contador_<?php echo $idJor;?> = 0;
            $(".insc_jor_<?php echo $idJor; ?>").each(function(){
			if($(this).is(":checked"))
				contador_<?php echo $idJor;?>++;
		});
                if (contador_<?php echo $idJor;?> > <?php echo $max_jornadas;?>) {
                            $("#pru_warning").removeClass( "oculto" );
                            alert("Estás inscribiendo mas pruebas que las permitidas en la Jornada <?php echo $idJor;?> ");                            
                        } else {
                            //
                        }
            <?php } ?>
                
                        
                <?php } ?>
    }
    
    
    
    $(".inscribir").click(function(e) {
        
                     var id = this.id;
                     console.log("#resp_"+id);
                     iniciarCuentas();
                    if( $(this).is(':checked') ) {
                        $("#resp_"+id).removeClass( "oculto" ); 
                    } else {
                        $("#resp_"+id).addClass( "oculto" ); 
                        
                    }
                    
                });
    $(".max_nad_prueba").click(function(e) {
        var contador = $(this).attr('rel'); 
        var splitid = contador.split('_');
        var prueba = splitid[0];
        var cant_max = splitid[1];
        if( $(this).is(':checked') ) {
            $("#pru_warning").removeClass( "oculto" );
            alert("Se ha superado el numero max de nadadores ("+cant_max+") inscritos en la prueba "+prueba);
        }
    });
    
                iniciarCuentas();
         
                
    $(".tiemposel").change(function() {
            var id = this.id;

            var respuesta = $(this).val();
            
            if (respuesta == 't') {
                $("#marca_"+id).removeClass( "oculto" ); 
            } else {
                $("#marca_"+id).addClass( "oculto" );
            }
            console.log("#marca_"+id);
            //$('#chkcod_'+index).val('0');
        });
    </script>
<?php } ?>
<?php if ($_page == 'competencias_doc') { ?>
<script type="text/javascript">
	
		Dropzone.autoDiscover = false;
		$("#dropzone").dropzone({
			url: "<?php $baseUrl?>uploads/uploads.php",
			addRemoveLinks: true,
			dictResponseError: "Ha ocurrido un error en el server",
			acceptedFiles: 'image/*,.jpeg,.jpg,.png,.xlsx,.xls,.doc,.docx,.pdf,.ppt,.pptx,.gif,.zip,.JPEG,.JPG,.PNG,.XLSX,.XLS,.DOC,.DOCX,.PDF,.PPT,.PPTX,.GIF,.ZIP',
			uploadMultiple: false,
			maxFiles: 1,
			maxfilesexceeded: function(file) {
        		this.removeAllFiles();
				this.addFile(file);
			},
			params: {
				id: '<?php echo $id;?>',
				tipo: '0'
			},
			complete: function(file, response)
			{
				if(file.status == "success")
				{
			
					//alert("El siguiente archivo ha subido correctamente: " + response);
					$( "#img_ppl" ).load( "/proyectos_up_img_ppl.php?id=104", function() {
						$('.statusMsg').html('<span style="color:green;">Gracias por agregar un nuevo centro.</p>');
						//$('#nuevoCentro').modal().hide();
						$('#nuevoCentro').modal('hide');
					});
					this.removeFile(file);
					
				}
			},
			error: function(file)
			{
				alert("Error subiendo el archivo " + file.name);
			},
			removedfile: function(file, serverFileName)
			{
				var name = file.name;
				
							var element;
							(element = file.previewElement) != null ? 
							element.parentNode.removeChild(file.previewElement) : 
							false;
					
			}
		});
  
                
     </script>
<?php } ?>

<?php if ($_page == 'nadadores_add_o') { ?>
<script type="text/javascript">
$('.datepicker').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
</script>
<?php } ?>
<?php if ($_page == 'nadadores_marcas') { ?>
<script type="text/javascript">
$('.datepicker1').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
</script>
<?php } ?>


<?php if ($_page == 'competencias_subir_marcas') { ?>
<script type="text/javascript">
  
  $(document).ready(function(){
   
              
                $(document).on("click", ".btnAsistencias", function(){
                    fila = $(this).closest("tr");
                    id = $(this).closest('tr').attr('id');
                    // id_tipo = $.trim($("#tipo").val());
                    id_tipo =  $.trim($('#tipo'+id).val());
                    window.location.href = 'competencias_subir_marcas2?id=' + id + '&tipo=' +id_tipo;
                  //  id= $(this).attr('id');
                  // id = parseInt(fila.find('td:eq(0)').text());
                  
                  // let nombre = "Lista de Atletas";
                  //  console.log(id,nombre );
                  //  return false;
                    //  openAsistencias(nombre,id);
                    //openGrupos(id);
                });

              $(document).on("click", "#atrasmarcas", function(){
              
                window.location.href = 'marcas_maestro' ;
             
            });
   
             //----formulario de asignar detalle de marca--------------------------------------
            $("#formarcas").submit(function(e){
                e.preventDefault(); 
            
                var opcion ="<?php echo $opcion?>";
               // console.log("entre aqui  <?php echo $id?>");
                //return false;
                if(opcion == 0){
                    id = $.trim($("#id2").val());
                    // console.log(id); 
                    action='add_det';
                }else{
                   
                    action='update_det';
                }
            
                nom_genero= $('select[name="genero"] option:selected').text();
                id_dt= "<?php echo  $marca2['id']?>";
                console.log('id '+id_dt);
               // return false;
                id_marca= "<?php echo $id?>";
                genero = $.trim($("#genero").val());   
                piscina = $.trim($("#piscina").val());

                edad_desde = $.trim($("#edad_desde").val());   
                edad_hasta = $.trim($("#edad_hasta").val());

                prueba = $.trim($("#prueba").val());   
                tiempo = $.trim($("#tiempo").val());

                atleta =($.trim($("#atleta").val()))?$.trim($("#atleta").val()):'0'; 

                fecha = ($.trim($("#fecha").val()))?$.trim($("#fecha").val()):'0000-00-00';
                ubicacion = $.trim($("#ubicacion").val());
                ano_nac = $.trim($("#ano_nac").val());
                relevo = $.trim($("#relevo").val());
            
            
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
                    url: "competencias_subir_marcas.php?action="+action,
                    type: "POST",
                    dataType: "json",
                    data: {id_dt:id_dt,id_marca:id_marca,genero:genero, opcion:opcion,piscina:piscina,edad_desde:edad_desde,edad_hasta:edad_hasta,prueba:prueba,tiempo:tiempo,atleta:atleta,fecha:fecha,ubicacion:ubicacion,ano_nac:ano_nac,relevo:relevo},
                    success: function(data){  
                        console.log("creado con exito");
                       // id = data[0].id;   
                       //  = data[0].tipo;    
                       // nombre = data[0].nombre;
                      
                        
                        location.reload();
                                  
                    }        
                 });
              //  $("#modalCRUD").modal("hide");    
                
            });    
            //----formulario de asignar detalle de marca--------------------------------------
            
            
   });

</script>
<?php } ?>
  




<?php if ($_page == 'grupos') { ?>
<script type="text/javascript">

    $('.timepicker').wickedpicker({
        title: '',
        now: "09:00",
        twentyFour: true,
        timeSeparator: ':'
    });
    $('#actividad').change(function(){
        
        var valor = $(this).val();
        if (valor == 'Otra') {
            $("#otra_actividad").removeClass( "oculto" ); 
        } else {
            $("#otra_actividad").addClass( "oculto" ); 
        }
        
    });


  
    //---------------NAY 04-2021 INICIO----///

   $("#club").change(function() {
      var club= $("#club").val();

      buscarEntrenadores(club);

       
   });  


 function buscarEntrenadores(club){
         var respEntrenadorc='';
      
        $.ajax({
                type: "POST",
                url: "<?php echo BASE_PATH_CONTROL; ?>buscar_entrenadores.php",
                data:  {club:club},
                type: 'post',   
                      success: function(data) {
                       //alert(data);
                        var arrResp  = data.split('_'); 

                      respEntrenadorc   = arrResp[0];
                      var select = document.getElementById("entrenador");
                      var combo_eentrenador = "";
                      select.options.length = 0;
                      combo_entrenador =  respEntrenadorc; 

                      $("#entrenador").append(combo_entrenador);

                      
                      },
                      error: function(data) {
                            alert("Error");
                            console.log(data);
                      }
             });

   } // fin buscarEntrenadores

     $("#formGrupos").validate({

  rules: {
    
    club: {
      required: true
    },
   entrenador: {
      required: true
    },
  nombre: {
      required: true
    },
     tipo_grupo: {
      required: true
    },
   
  },
    messages: {
      
      club: {
        required: "Debe seleccionar el Club"
      },
      entrenador: {
        required: "Debe seleccionar el Entrenador"
      },
      nombre: {
        required: "Debe ingresar el Nombre"
      },
       tipo_grupo: {
        required: "Debe seleccionar el Tipo de Grupo"
      },
       
    }
});

//---------------NAY 04-2021 INICIO----///

    </script>
<?php } ?>

     <?php if ($_page == 'nadadores_calendario') { ?>
    <script type="text/javascript">
    

  $(document).ready(function() {

   
    $('#agenda').fullCalendar({
    defaultView: 'agendaWeek',    //3pm
    
                  
    events: [
        <?php 
        $min_hora = "23:00:00";
        foreach ($gru->horario as $Elem) { 
            if ($Elem['desde'] < $min_hora) { 
                $min_hora = $Elem['desde'];
            }
?>
                        {
        title:"<?php echo $Elem['actividad']?>",
        start: '<?php echo $Elem['desde']?>', // a start time (10am in this example)
        end: '<?php echo $Elem['hasta']?>', // an end time (6pm in this example)
        
        dow: [ <?php echo $Elem['dia']?> ], // Repeat monday and thursday
        <?php if ($Elem['actividad'] == 'Preparacion Física') { ?>
        color  : '#E2BF1C',
        <?php } else if ($Elem['actividad'] == 'Piscina') { ?>
            color  : '#1968BF',
            <?php } else { ?>
                color  : '#A2250F',
                
        <?php } ?>
        textColor: '#fff'
            
    },<?php } ?>],
    textColor: '#fff',
    scrollTime :  "<?php echo $min_hora;?>",
    
});
    

  });


      </script>
    <?php } ?>

    <script type="text/javascript">
      
   


 
   



        function PadLeft000(value, length) {
              return (value.toString().length < length) ? PadLeft("0" + value, length) : 
              value;
          }


     function convertiraMS(tiempo)
            {
                var porcion1 = tiempo.split(":");
                var minutos = porcion1[0];
                var porcion2 = porcion1[1].split(".");
                var segundos = porcion2[0];
                var milisegundos = (porcion2[1]*10);

                
                var tiempoMS = (minutos*60*1000)+(segundos*1000)+milisegundos;
                var tiempoS = tiempoMS/1000;
                //console.log("estan los 3 valores"+tiempo);
                return tiempoS;
                
            }


            function convertiraSEG(tiempo)
            {
                tiempo = tiempo*1000;
                var segundos=tiempo/1000;

               
          //verificamos residuo para ver si llevará decimales
                var Ms=((tiempo%1000)/10);
                      //$segundos = $segundos - $Ms;
                      
                var segundos1=Math.floor(segundos);
                      //$segundos1
                      
                      if (segundos1 >= 60) {
                          var minutos1=segundos1/60;
                          //verificamos residuo para ver si llevará decimales
                          var Seg=segundos1%60;
                          var minutos=Math.floor(minutos1);
                          
                      } else {
                          var Seg = segundos1;
                          var minutos="00";            
                      }
                      
                      //console.log(minutos+" "+Seg+" "+Ms);
                      
                      var tiempoSG = PadLeft(minutos, 2)+":"+PadLeft(Seg, 2)+"."+PadLeft(Math.round(Ms), 2);
                      
                      
                      return tiempoSG;
                     // return $segundos." ".$Ms
                      
                  }
                  </script>

     <?php if ($_page == 'vldz_pronostico') { ?>
      <script type="text/javascript">

    

        $(document).ready(function() {

          var porcentajeM = new Array();
          var porcentajeF = new Array();
           <?php foreach ($datos as $Elem) { ?>
              porcentajeM[<?php echo $Elem["edad"] ?>] = <?php echo $Elem["masculino"] ?>;
              porcentajeF[<?php echo $Elem["edad"] ?>] = <?php echo $Elem["femenino"] ?>;
          <?php } ?>

        

         

            function calcularTPronostico1 () {
              //console.log("calcula pronostico");
                var cporc1 = 100-$("#porc_desde").val();
                var cporc2 = 100-$("#porc_hasta").val();

                //console.log(cporc1);

                var calcTdesde = ($( "#tiempoSeg" ).val()*cporc1)/100;
                var calcThasta = ($( "#tiempoSeg" ).val()*cporc2)/100;

                //console.log(calcTdesde);
                //console.log(convertiraSEG(calcTdesde));

                $( "#marcaPdesde" ).val(convertiraSEG(calcTdesde));
                $( "#marcaPhasta" ).val(convertiraSEG(calcThasta));
                
            }

            function calcularEficienciaRef() {

            var diferenciae = $("#eficr").val() - $("#efic").val();

            var diferenciae = diferenciae.toFixed(2);
                $("#difer").val(diferenciae);

                }


            $( "#distancia_1, #marca, #prom" ).change(function() {
              //console.log("empieza a revisar");

                 if ($( "#distancia_1" ).val() && $( "#marca" ).val() && $( "#prom" ).val() )  {
                  
                  var distancia = $("#distancia_1").val();
                    var splitid = distancia.split('-');

                   
                      var distancia1 = splitid[3];
                  //console.log (distancia1);

                    var velocidad = distancia1/convertiraMS($( "#marca" ).val());

                    $( "#tiempoSeg" ).val(convertiraMS($( "#marca" ).val()));

                    $("#velocidad1").val(velocidad);

                    var eficiencia = (velocidad*60)/$( "#prom" ).val();

                    var eficiencia = eficiencia.toFixed(2);

                    $("#efic").val(eficiencia);
                    calcularEficienciaRef();

                    console.log("estan los 3 valores"+$("#velocidad1").val());
                  }
               
            });


             $( "#genero, #edad" ).change(function() {

              if ($( "#genero" ).val() && $( "#edad" ).val() )  {
                  if ($( "#genero" ).val() == 1) {
                      var porc_hasta = porcentajeF[$( "#edad" ).val()];
                      var porc_desde = porc_hasta - 1;
                      $("#porc_hasta").val(porc_hasta);
                      $("#porc_desde").val(porc_desde);
                      
                  } else {
                    var porc_hasta = porcentajeM[$( "#edad" ).val()];
                      var porc_desde = porc_hasta - 1;
                      $("#porc_hasta").val(porc_hasta);
                      $("#porc_desde").val(porc_desde);

                  }
                  if ($( "#marca" ).val() )  {
                    calcularTPronostico1();
                  }  
                }

             }); 


             $( "#porc_desde, #porc_hasta" ).change(function() {

                  if ($( "#marca" ).val() )  {
                    calcularTPronostico1();
                  }  


              }); 



             $( "#marca" ).change(function() {
              $( "#tiempoSeg" ).val(convertiraMS($( "#marca" ).val()));
                if ($( "#porc_hasta" ).val() && $( "#porc_desde" ).val() )  {
                  calcularTPronostico1();
                  }


              });


             $( "#promh, #efich" ).change(function() {

              if ($( "#promh" ).val() && $( "#efich" ).val() && $( "#distancia_1" ).val() )  {

                var distancia = $("#distancia_1").val();
                    var splitid = distancia.split('-');

                   
                      var distancia1 = splitid[3];
                  
                  var velocidadProy = ($("#promh").val()*$( "#efich" ).val())/60;
                  var tiempoProy =  distancia1/velocidadProy;
                  $( "#marcah" ).val(convertiraSEG(tiempoProy));

                }

             }); 


             $( "#prom" ).change(function() {
                var diferenciaf = $("#promr").val() - $("#prom").val();
                diferenciaf = diferenciaf.toFixed(2)
                $("#diffr").val(diferenciaf);
              });


             $( "#efic" ).change(function() {
                 calcularEficienciaRef();
              });





          });


      </script>

      <?php } ?>

        <?php if ($_page == 'vldz_ritmo') { ?>
          <script type="text/javascript">

            $( "#marca, #efic, #distancia" ).change(function() {

              if ($( "#marca" ).val() && $( "#efic" ).val() && $( "#distancia" ).val() )  {
                  
                      var result90 = (convertiraMS($( "#marca" ).val())*110)/100;

                      $( "#tiempo90" ).val(convertiraSEG(result90));

                      var result92 = (convertiraMS($( "#marca" ).val())*108)/100;

                      $( "#tiempo92" ).val(convertiraSEG(result92));


                      var result98 = (convertiraMS($( "#marca" ).val())*102)/100;

                      $( "#tiempo98" ).val(convertiraSEG(result98));

                      //distancia/tiempocalculado * 60/edb
                      var  fdb90 = ($( "#distancia" ).val()/result90)*(60/$( "#efic" ).val());
                      fdb90 = fdb90.toFixed(1);
                       $( "#fdb90" ).val(fdb90);


                       var  fdb92 = ($( "#distancia" ).val()/result92)*(60/$( "#efic" ).val());
                        fdb92 = fdb92.toFixed(1);
                       $( "#fdb92" ).val(fdb92);


                       var  fdb98 = ($( "#distancia" ).val()/result98)*(60/$( "#efic" ).val());
                        fdb98 = fdb98.toFixed(1);
                       $( "#fdb98" ).val(fdb98);
                 
                  
                }

             }); 

          </script>
        <?php } ?>

        <?php if ($_page == 'vldz_tmps') { ?>

              <script type="text/javascript">
                $('#calcular').click(function(){

                    var tiempo = convertiraMS($("#marca").val());
                    console.log("tiempo original: "+tiempo );
                    var variacion = $("#distancia_1").val();
                    var splitid = variacion.split('-');

                    if ($("#genero").val()=='1') {
                      var variacion1 = splitid[0];
                    } else {
                      var variacion1 = splitid[1];
                    }

                    variacion1 = variacion1/1000;
                    var varcrono = splitid[2]/1000;
                    console.log("variacion: "+variacion1);


                    if ($("#piscina").val()=='25') {
                       var tmp25 = tiempo;
                       var tmp50 = tiempo + variacion1;
                    } else if ($("#piscina").val()=='50') {
                       var tmp25 = tiempo - variacion1;
                       var tmp50 = tiempo;                      
                    }

                    if ($("#crono").val()=='1') {
                       var tmp25m = tmp25;
                       var tmp50m = tmp50;
                       var tmp25a = tmp25+varcrono;
                       var tmp50a = tmp50+varcrono;

                    } else if ($("#crono").val()=='2') {
                       var tmp25m = tmp25-varcrono;
                       var tmp50m = tmp50-varcrono;
                       var tmp25a = tmp25;
                       var tmp50a = tmp50;                      
                    }


                    var resultado = "Tiempo Piscina 25mts. Crono Manual "+convertiraSEG(tmp25m)+"<br>";
                    resultado = resultado + "Tiempo Piscina 25mts. Crono Automatico "+convertiraSEG(tmp25a)+"<br>";
                    resultado = resultado + "Tiempo Piscina 50mts. Crono Manual "+convertiraSEG(tmp50m)+"<br>";
                    resultado = resultado + "Tiempo Piscina 50mts. Crono Automatico "+convertiraSEG(tmp50a)+"<br>";
                    $("#resultado").html(resultado);

                    console.log(convertiraSEG(tmp25m));
                    console.log(convertiraSEG(tmp50m));
                    console.log(convertiraSEG(tmp25a));
                    console.log(convertiraSEG(tmp50a));



                  });

              </script>
                
            <?php } ?>

<!--
<script type='text/javascript'>

    $j=jQuery.noConflict();

    $j(document).ready(function () {

        $j("#marca").inputmask("99:99.99");

    });
</script>

-->
        
<!---------NAY 04-2021------------------------>

<?php if (($_page == 'grupos_asociar') or ($_page == 'grupos_asociar_add') )  { ?>
   <script type="text/javascript">

      $("#bt_buscar").click(function() {
        var valor = $(this).attr('rel');
        //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
     });

 
  </script>
<?php } ?>


<?php if ($_page == 'grupos_asociar_add') { ?>
  <script type="text/javascript">
      function mostrarBoton() {
        var elementos = $('input.miUsuarios');
        var algunoMarcado = elementos.toArray().find(function(elemento) {
           return $(elemento).prop('checked');
        });
        
        if(algunoMarcado) {
           $("#btnGuardar").removeClass("oculto");
        } else {
          $("#btnGuardar").addClass("oculto");
        }
      }

       $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
           if( $('#checkAll').is(':checked') ) {
             $("#btnGuardar").removeClass("oculto");
           } else {
          $("#btnGuardar").addClass("oculto");
        }
       });
    </script>
<?php } ?>


<?php if (($_page == 'tesoreria_cuotas_asociar') || ($_page == 'tesoreria_cuotas_asociar_add')  || ($_page == 'tesoreria_cuotas_user_detalle')   ) { ?>
  <script type="text/javascript">
  
    $("#bt_buscar").click(function() {
        var valor = $(this).attr('rel');
        //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
            $("#buscador_div1").addClass("oculto");
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
     });

 
    


  </script>
<?php } ?>
<?php if ($_page == 'tesoreria_cuotas' || $_page == 'tesoreria_cuotas_resumen') { ?>
  <script type="text/javascript">
  
 
    $("#bt_buscar").click(function() {
        var valor = $(this).attr('rel');
        //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
            $("#buscador_div1").addClass("oculto");
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
     });

 
        $("#bt_buscar1").click(function() {
        var valor = $(this).attr('rel');
      //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div1").removeClass("oculto");
            $(this).attr('rel', 'visible');
            $("#buscador_div").addClass("oculto");
        } else {
            $("#buscador_div1").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
     });


               
   $("#tipo_cuotav").change(function() {
        var tipoCuota= $("#tipo_cuotav").val();
        if (tipoCuota == '1') {
            $("#vencimiento_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
           
        } else {
            $("#vencimiento_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }

   });  
   
  $("#formTCuotas").validate({

  rules: {
    
    cuota: {
      required: true
    },
   tipo_cuotav: {
      required: true
    },
  monto: {
      required: true
    },
     club: {
      required: true
    },
     fecha_inicio: {
      required: true
    },
     fecha_fin: {
      required: true
    },
 
    dia_vencimiento: {
      required: true
    },

   
  
     
     
  },
    messages: {
      
      cuota: {
        required: "Debe ingresar la Nombre de la Cuota"
      },
      tipo_cuota: {
        required: "Debe seleccionar el Tipo de Cuota"
      },
      monto: {
        required: "Debe ingresar el Monto"
      },
       club: {
        required: "Debe seleccionar el Club"
      },
       fecha_inicio: {
        required: "Debe ingresar el Fecha de Inicio"
      },
       fecha_fin: {
        required: "Debe ingresar el Fecha Fin"
      },
       
      dia_vencimiento: {
        required: "Debe seleccionar el Dia Vencimiento"
      },
    }
});

  </script>
<?php } ?>







<?php if (($_page == 'tesoreria_cuotas_asociar_add') or ($_page == 'tesoreria_cuotas_user_detalle'))  { ?>
  <script type="text/javascript">
      function mostrarBoton() {
        var elementos = $('input.miUsuarios');
        var algunoMarcado = elementos.toArray().find(function(elemento) {
           return $(elemento).prop('checked');
        });
        
        if(algunoMarcado) {
           $("#btnGuardar").removeClass("oculto");
        } else {
          $("#btnGuardar").addClass("oculto");
        }
      }

       $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
           if( $('#checkAll').is(':checked') ) {
             $("#btnGuardar").removeClass("oculto");
           } else {
          $("#btnGuardar").addClass("oculto");
        }
       });
    </script>
<?php } ?>



<?php if (($_page == 'tesoreria_mispagos')  || ($_page == 'tesoreria_pagos')  ) { ?>
  <script type="text/javascript">
  
     $("#bt_buscar").click(function() {
        var valor = $(this).attr('rel');
        //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
            $("#buscador_div1").addClass("oculto");
            $("#div_transferencia").addClass("oculto");
             $("#div_agregar").removeClass("jumbotron");
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
     });

 
        $("#bt_buscar1").click(function() {
        var valor = $(this).attr('rel');
      //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div1").removeClass("oculto");
           
            $(this).attr('rel', 'visible');
            $("#buscador_div").addClass("oculto");
            $("#div_agregar").addClass("jumbotron");
             $("#tipo_pagov").val("");
        } else {
            $("#buscador_div1").addClass("oculto");
            $(this).attr('rel', 'oculto');
             $("#div_agregar").removeClass("jumbotron");
        }
     });


   $("#tipo_pagov").change(function() {
     
        var tipoPago= $("#tipo_pagov").val();
        console.log("tipo pago "+tipoPago);
        if (tipoPago == '1') {
          console.log("test");
            $("#div_enlinea").removeClass("oculto");
            $("#div_transferencia").addClass("oculto");
            $("#btnGuardar").removeClass("oculto");
            $("#div_banco").addClass("oculto");
            $(this).attr('rel', 'visible');
            buscarDatosApiLinea(tipoPago);
            $("#bancov").val("");
           
        } else if (tipoPago == '2') {
          
            $("#div_transferencia").removeClass("oculto");
            $("#div_enlinea").addClass("oculto");
            $(this).attr('rel', 'oculto');
            $("#btnGuardar").removeClass("oculto");
        }else{
             $("#div_transferencia").addClass("oculto");
              $("#div_enlinea").addClass("oculto");
             $("#btnGuardar").addClass("oculto");
              $("#div_banco").addClass("oculto");

        }

   });  


   $("#clubv").change(function() {
     
        var club= $("#clubv").val();
        if (club != '') {
            $("#div_TipoPago").removeClass("oculto");
             buscarTiposPago();
             buscarBancos();
           
        } else{
             $("#div_TipoPago").addClass("oculto");
             $("#div_transferencia").addClass("oculto");
             $("#div_enlinea").addClass("oculto");
             $("#btnGuardar").addClass("oculto");
             $("#div_banco").addClass("oculto");
             

        }

   });  



   function buscarTiposPago(){
        
         var idClub= $("#clubv").val();
        $.ajax({
                type: "POST",
                url: "<?php echo BASE_PATH_CONTROL; ?>datos_TipoPagos.php",
                data:  {idClub:idClub},
                type: 'post',   
                      success: function(data) {
                        //alert(data);
                     
                      respTipoPago  = data;
                      var select = document.getElementById("tipo_pagov");
                      var combo_tipoPago = "";
                      select.options.length = 0;
                      combo_tipoPago =  respTipoPago; 
                      $("#tipo_pagov").append(combo_tipoPago);
                      
              
                       
                      },
                      error: function(data) {
                            alert("Error");
                            console.log(data);
                      }
             });

   } // fin buscarTiposPago


     function buscarBancos(){
        
         var idClub= $("#clubv").val();
        $.ajax({
                type: "POST",
                url: "<?php echo BASE_PATH_CONTROL; ?>datos_lisbancos.php",
                data:  {idClub:idClub},
                type: 'post',   
                      success: function(data) {
                        //alert(data);
                     
                      respBanco  = data;
                      var select = document.getElementById("bancov");
                      var combo_banco = "";
                      select.options.length = 0;
                      combo_banco =  respBanco; 
                      $("#bancov").append(combo_banco);
                      
              
                       
                      },
                      error: function(data) {
                            alert("Error");
                            console.log(data);
                      }
             });

   } // fin buscarTiposPago

   function buscarDatosBanco(idBanco){
        
         var idClub= $("#clubv").val();
        $.ajax({
                type: "POST",
                url: "<?php echo BASE_PATH_CONTROL; ?>datos_banco.php",
                data:  {idBanco:idBanco,idClub:idClub},
                type: 'post',   
                      success: function(data) {
                        //alert(data);
                      var datosBanco=data; 
                      $("#div_banco").removeClass("oculto");
                      $("#div_banco").html(datosBanco);
                      
                       
                      },
                      error: function(data) {
                            alert("Error");
                            console.log(data);
                      }
             });

   } // fin buscarDatosBanco

   function buscarDatosApiLinea(tipoPago){
        
         var idClub= $("#clubv").val();
        $.ajax({
                type: "POST",
                url: "<?php echo BASE_PATH_CONTROL; ?>datos_api_enlinea.php",
                data:  {tipoPago:tipoPago,idClub:idClub},
                type: 'post',   
                      success: function(data) {
                        var arrResp  = data.split('_'); 
                        var api=arrResp[0]; 
                        var secret=arrResp[1]; 
                        $("#api").val(api);
                         $("#secret").val(secret);

                      
                       
                      },
                      error: function(data) {
                            alert("Error");
                            console.log(data);
                      }
             });

   } // fin buscarDatosBanco


   $("#bancov").change(function() {
        var idBanco= $("#bancov").val();
       // alert(idBanco);
        buscarDatosBanco(idBanco);

   });  


 
  
    $('#rut').Rut({  
        format_on: 'keyup'
    });
    
    


 $("#rut").blur(function() {
   var rut =  $("#rut").val();


   if (rut!=""){

      var validarRut=$.Rut.validar(rut); 
    
      if(validarRut==false){
         $("#rut-error").removeClass("oculto");
         $("#rut-error").html("Este campo debe ser un rut valido");

      }else{

          buscarDatosRutPago(rut);
          $("#rut-error").addClass("oculto");
          $("#rut-error").html("");
      }
   }else{
     $("#rut-error").removeClass("oculto");
     $("#rut-error").html("Debe ingresar el rut");
    
  
   
   }
  });  


 

 function buscarDatosRutPago(rut){
        
        var respnum='';
        
        $.ajax({
                type: "POST",
                url: "<?php echo BASE_PATH_CONTROL; ?>check_rut_pago.php",
                data:  {rut:rut},
                type: 'post',   
                      success: function(data) {
                       //alert(data);
                        var arrResp  = data.split('_'); 
                        respnum=arrResp[0];
                        var idUser=arrResp[1]; 
                        var nombre=arrResp[2]; 
                    
                        var idClubOrigen=arrResp[3]; 
                        var montoVencido=arrResp[4];
                        var montoPorVencer=arrResp[5];
                        var montoTotal=arrResp[6];
                        


                        

                        if(respnum=='0'){
                           $("#rut-error").removeClass("oculto");
                           $("#rut-error").html("Rut No registrado en la base de datos");
                    
                        }else if(respnum=='1'){
                            $("#rut-error").html("");
                            
                            $("#idUsuario").val(idUser);
                           
                            if(idClubOrigen!='0'){
                              $("#clubv").val(idClubOrigen);
                              //document.getElementById("clubv").disabled = true;
                            }else{
                               //$("#clubv").val("");
                              //document.getElementById("clubv").disabled = false;
                            }

                                $(".msg-vencida").html(montoVencido);
                            
                            $(".msg-pentiente").html(montoPorVencer);
                            $(".msg-total").html(montoTotal);
                            $("#nombre_completo").val(nombre);
                            

                            $("#monto").val(montoTotal);
                            $("#div_TipoPago").removeClass("oculto");
                             buscarTiposPago();
                             buscarBancos();

                            
                        }


                        
                
                      
                      },
                      error: function(data) {
                            alert("Error");
                            console.log(data);
                      }
             });

   } // fin buscarDatosNadador


     $("#formMisPagos").validate({

  rules: {
     club: {
      required: true
    },
   tipo_pagov: {
      required: true
    },
  banco: {
      required: true
    },
     monto_transferencia: {
      required: true
    },
     fecha_pago: {
      required: true
    },
     transferencia: {
      required: true,

       remote: {
                url: "<?php $baseUrl?>check_transferencia.php",
                type: "post",
                 complete: function(data){
                        if( data.responseText == "false" ) {
                            //alert("Free");
                          }
                     }
            }
    },
 
  },
    messages: {
       club: {
        required: "Debe seleccionar el Club"
      },
      tipo_pago: {
        required: "Debe seleccionar el Tipo de Pago"
      },
      banco: {
        required: "Debe seleccionar el Banco"
      },
      monto_transferencia: {
        required: "Debe ingresar el Monto"
      },
       
       fecha_pago: {
        required: "Debe ingresar el Fecha de Pago"
      },
       transferencia: {
        required: "Debe ingresar el numero de transferencia",
        remote: "Este numero de transferencia ya está registrado en la base de datos"
      },
      
    }
});

    


  </script>
<?php } ?>


<?php if ($_page == 'tesoreria_mispagos_up') { ?>
   <script type="text/javascript">


 Dropzone.autoDiscover = false;
    $("#dropzone").dropzone({
      url: "<?php $baseUrl?>uploads/uploads_tesoreria_pagos_up.php",
   
      addRemoveLinks: true,
      dictResponseError: "Ha ocurrido un error en el server",
      acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
      uploadMultiple: false,
      maxFiles: 1,
      maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
      },
      /*init: function() {
        this.on("sending", function(file, xhr, formData) {
          formData.append("id", "<?php echo $id;?>");
          formData.append("tipo", '0');
          formData.append("requisitos", $('#requisitos').val());
         
          console.log(formData)
        });
      },*/
     
      params: {
        id: '<?php echo $id;?>',
        tipo: '0'
      
        
      },
      complete: function(file, response)
      {
        if(file.status == "success")
        {
      
         //alert("El siguiente archivo ha subido correctamente: " + response);
           $( "#docu_id" ).load( "<?php echo BASE_PATH_CONTROL; ?>tesoreria_mispagos_int.php?id=<?php echo $id; ?>&tp=<?php echo $_GET['tp']; ?>", function() {
            $('#statusMsg').html('<span style="color:green;">Gracias por agregar documento.</p>');
            $('#div_dropzone').hide();
           
          });
          this.removeFile(file);
          
        }
      },
      error: function(file)
      {
        alert("Error subiendo el archivo " + file.name);
      },
      removedfile: function(file, serverFileName)
      {
        var name = file.name;
        
              var element;
              (element = file.previewElement) != null ? 
              element.parentNode.removeChild(file.previewElement) : 
              false;
          
      }
       
    });
  

       </script>
<?php } ?>


<?php if ($_page == 'tesoreria_pagos') { ?>
      <script type="text/javascript">


  function estatusDocumento(radio,id,estatusOld) {

    var estatus=radio.value;

    if(estatus=='1'){

      var confirmar = confirm("Seguro de Aprobar el Documentos?")
    
        if (confirmar) {
                  $("#p_estatusdoc"+id).css('color','green');
                  $("#p_estatusdoc"+id).css('text-align','center');
                  $("#p_estatusdoc"+id).html("<strong>Aprobado</strong>");
                  $("#comentariodoc"+id).attr("required", false);
                  $("#lestatusaprobado"+id).removeClass('label-no-evaluado');
                  $("#lestatusaprobado"+id).addClass('label-aprobabo');
                  $("#lestatusrechazado"+id).removeClass('label-rechazado');
                  $("#lestatusrechazado"+id).addClass('label-no-evaluado');
                  $("#comentariodoc"+id).addClass('oculto');
                  $("#btnGuardar"+id).removeClass('oculto');
                radio.checked = true;
        }
        else {
            
            $("#p_estatusdoc"+id).css('color','#000');
            $("#p_estatusdoc"+id).html(estatusOld);
            $("#comentariodoc"+id).attr("required", false);
            $("#lestatusaprobado"+id).removeClass('label-aprobabo');
            $("#lestatusaprobado"+id).addClass('label-no-evaluado');
            $("#lestatusrechazado"+id).removeClass('label-rechazado');
            $("#lestatusrechazado"+id).addClass('label-no-evaluado');
            $("#comentariodoc"+id).addClass('oculto');
            radio.checked = false;
        }
     }else if(estatus=='2'){

          var confirmar = confirm("Seguro de Rechazar el Documento?")
        
          if (confirmar) {
                 $("#p_estatusdoc"+id).css('color','red');
                 $("#p_estatusdoc"+id).css('text-align','center');
                 $("#p_estatusdoc"+id).html("<strong>Rechazado</strong>");
                 $("#comentariodoc"+id).attr("required", true);
                 $("#lestatusaprobado"+id).removeClass('label-aprobabo');
                $("#lestatusaprobado"+id).addClass('label-no-evaluado');
                $("#lestatusrechazado"+id).removeClass('label-no-evaluado');
                $("#lestatusrechazado"+id).addClass('label-rechazado');
                 $("#comentariodoc"+id).removeClass('oculto');
                 $("#btnGuardar"+id).removeClass('oculto');
                 radio.checked = true;
          }else {
              
              $("#p_estatusdoc"+id).css('color','#000');
              $("#p_estatusdoc"+id).html(estatusOld);
              $("#comentariodoc"+id).attr("required", false);
              $("#lestatusaprobado"+id).removeClass('label-aprobabo');
              $("#lestatusaprobado"+id).addClass('label-no-evaluado');
              $("#lestatusrechazado"+id).removeClass('label-rechazado');
              $("#lestatusrechazado"+id).addClass('label-no-evaluado');
              $("#comentariodoc"+id).addClass('oculto');
              radio.checked = false;
          }

     }
}




</script>
<?php } ?>


<?php if ($_page == 'clubes_maestro'  || $_page == 'clubes_maestro_mod' || $_page == 'bancos'  || $_page == 'bancos_mod' || $_page == 'tipo_pagos'  || $_page == 'tipo_pagos_mod'  || $_page == 'estatus'  || $_page == 'estatus_mod' ) { ?>
  <script type="text/javascript">
  
 
    $("#bt_buscar").click(function() {
        var valor = $(this).attr('rel');
        //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
            $("#buscador_div1").addClass("oculto");
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
     });

 
        $("#bt_buscar1").click(function() {
        var valor = $(this).attr('rel');
      //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div1").removeClass("oculto");
            $(this).attr('rel', 'visible');
            $("#buscador_div").addClass("oculto");
        } else {
            $("#buscador_div1").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
     });


        
  </script>
<?php } ?>

<?php if ($_page == 'clubes_maestro' || $_page == 'clubes_maestro_mod') { ?>
  <script type="text/javascript">
  
  $('#rut').Rut({  
        format_on: 'keyup'
    });
    
     $.validator.addMethod("rut", function(value, element) {
  return this.optional(element) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");
    
   
  $("#formClubes").validate({

  rules: {
    rut: {
      required: true,
      rut: true,
      <?php if ($_page == 'clubes_maestro') { ?>
       remote: {
                url: "<?php $baseUrl?>check_rut_club.php",
                type: "post",
                 complete: function(data){
                        if( data.responseText == "false" ) {
                            //alert("Free");
                          }
                     }
            }
         <?php } ?>
    },
    club: {
      required: true
    },
   email: {
      required: true,
	email: true
    },

  },
    messages: {
      rut: {
        required: "Debe ingresar el Rut del Club",
         rut:"Este campo debe ser un rut valido",
          <?php if ($_page == 'clubes_maestro') { ?>
         remote: "Este Rut ya está registrado en la base de datos"
          <?php } ?>
      },
      club: {
        required: "Debe ingresar el Nombre del Club"
      },
      email: {
        required: "Debe ingresar el Email",
	email: "Debe ingresar un Email valido",
      },
     
    }
});

  </script>
<?php } ?>

<?php if ($_page == 'clubes_metodo_pago' || $_page == 'clubes_metodo_pago_mod') { ?>
  <script type="text/javascript">
  $("#bt_buscar").click(function() {
        var valor = $(this).attr('rel');
        //console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div").removeClass("oculto");
            $(this).attr('rel', 'visible');
            $("#buscador_div1").addClass("oculto");
            $("#div_transferencia").addClass("oculto");
            $("#div_enlinea").addClass("oculto");
        } else {
            $("#buscador_div").addClass("oculto");
            $(this).attr('rel', 'oculto');
        }
     });

 
        $("#bt_buscar1").click(function() {
        var valor = $(this).attr('rel');
      console.log(valor);
        if (valor == 'oculto') {
            $("#buscador_div1").removeClass("oculto");
             $("#div_form").addClass("jumbotron");
            $("#tipo_pagov").val("");
            $(this).attr('rel', 'visible');
            $("#buscador_div").addClass("oculto");

        } else {

            $("#buscador_div1").removeClass("oculto");
             $("#div_form").addClass("jumbotron");
            $(this).attr('rel', 'oculto');
        }
     });


   $("#tipo_pagov").change(function() {
        var tipoCuota= $("#tipo_pagov").val();
        if (tipoCuota == '1') {
            $("#div_enlinea").removeClass("oculto");
            $("#div_transferencia").addClass("oculto");
            $("#btnGuardar").removeClass("oculto");
            
            $(this).attr('rel', 'visible');
           
        } else if (tipoCuota == '2') {
            $("#div_transferencia").removeClass("oculto");
            $("#div_enlinea").addClass("oculto");
            $(this).attr('rel', 'oculto');
            $("#btnGuardar").removeClass("oculto");
        }else{
             $("#div_transferencia").addClass("oculto");
              $("#div_enlinea").addClass("oculto");
             $("#btnGuardar").addClass("oculto");

        }

   });  


     $("#formMetodoPagos").validate({

  rules: {
    
   tipo_pagov: {
      required: true
    },
  banco: {
      required: true
    },
     tipo_cuenta: {
      required: true
    },
     nro_cuenta: {
      required: true
    },
     rut_titular: {
      required: true
    },
     nombre_titular: {
      required: true
    },
     email_titular: {
      required: true,
      email:true
    },

    api: {
      required: true
    },
    secret: {
      required: true
    },
     
 
  },
    messages: {
      
      tipo_pago: {
        required: "Debe seleccionar el Tipo de Pago"
      },
      banco: {
        required: "Debe seleccionar el Banco"
      },
      tipo_cuenta: {
        required: "Debe ingresar el Tipo de Cuenta"
      },
       
       nro_cuenta: {
        required: "Debe ingresar el Numero de Cuenta"
      },

       rut_titular: {
        required: "Debe ingresar el Rut del Titular"
      },
       nombre_titular: {
        required: "Debe ingresar el Nombre del Titular"
      },

       email_titular: {
              required: "Debe ingresar el Email",
            email: "Debe ingresar un Email valido",
      },

      api: {
              required: "Debe ingresar el Api",
           
      },

      secret: {
              required: "Debe ingresar el Secret",
           
      },
      
    }
});


  </script>
<?php } ?>


<?php if ($_page == 'clubes_maestro_mod') { ?>
<script type="text/javascript">
  
    Dropzone.autoDiscover = false;
    $("#dropzone").dropzone({
      url: "<?php $baseUrl?>uploads/club_logo.php",
      addRemoveLinks: true,
      dictResponseError: "Ha ocurrido un error en el server",
      acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
      uploadMultiple: false,
      maxFiles: 1,
      maxfilesexceeded: function(file) {
            this.removeAllFiles();
        this.addFile(file);
      },
      params: {
        id:<?php echo $id;?>,
        tipo: '0'
      },
      complete: function(file, response)
      {
        if(file.status == "success")
        {
            console.log(response);

            $( "#club_logo" ).load( "<?php $baseUrl?>club_logo.php", function() {
          
           
            $('.bs-modal-lg-primary').modal('hide');

          });
          this.removeFile(file);
          
        }
      },
      error: function(file)
      {
        alert("Error subiendo el archivo " + file.name);
      },
      removedfile: function(file, serverFileName)
      {
        var name = file.name;
        
              var element;
              (element = file.previewElement) != null ? 
              element.parentNode.removeChild(file.previewElement) : 
              false;
          
      }
    });
  
                
                </script>
<?php } ?>


