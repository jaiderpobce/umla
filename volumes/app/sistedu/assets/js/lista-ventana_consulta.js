function openAsistencias(nombre,id) {
   localStorage.setItem("id_asistencias", id);
 
     const lista_asistencias = document.getElementById('lista_asistencias');
     const table = document.getElementById('table_asistencias');
     const filterInput = document.getElementById('filterInputasis');
     lista_asistencias.style.width = "80%"; // Tamaño específico deseado, por ejemplo 50%
     lista_asistencias.style.height = "80%"; // Altura específica deseada, por ejemplo 50% de la altura de la ventana
     lista_asistencias.style.overflow = "hidden";
     var data = [];
     $(".modal-header").css("background-color", "#0101ff");
     $(".modal-header").css("color", "white");
    // $(".modal-header").css("margin", "0");
     $(".button-container").hide(); 
     $(".modal-title").css("color", "white");
     $(".modal-title").text(nombre);  
   
     $.ajax({
       
        url: "sesion_maestro.php?action=getAsistencias",
        type: "POST",
        dataType: "json",
        data: {id:id},
        success: function(data3){  
            console.log("entre aqui");
            //console.log('entropy');
            data=data3
            console.log(data);
            displayTable(data);
                   
        }        
    });
     
 
   
     filterInput.addEventListener('input', function() {
       const filterValue = this.value.toLowerCase();
       const filteredData = data.filter(item => item.nombre.toLowerCase().includes(filterValue) || item.apellido.toLowerCase().includes(filterValue));
   
       displayTable(filteredData);
     });
   
     function displayTable(data) {
       table.innerHTML = `
         <tr>
           <th>#</th>
           <th>As</th>
           <th>Ju.</th>
           <th>Nombre</th>
           <th>Apellido</th>
           
           
         </tr>
         
         ${data.map((item, index) => `
         
           <tr id="filatr${item.id}" ${(item.asistencia=='J')?`class="justificado"`:`class="seleccionar"`} >
 
             <td >${index+1}</td>
             <td><input type="checkbox" id="cbox${item.id}"class="checkboxTabla" value="second_checkbox" onchange="selectAsist('${item.id}')" ${(item.asistencia=='Y')?`checked`:``} /></td>
             <td><input type="checkbox" id="cboxj${item.id}"class="checkboxTabla" value="second_checkbox" onchange="selectjustificado('${item.id}','${item.asistencia}')" ${(item.asistencia=='J')?`checked`:``} /></td>
             <td>${item.nombre}</td>
             <td>${item.apellido}</td>
        
           
           </tr>
           
           `).join('')}
       `;
 
       
     }
     
  
  
  
     displayTable(data);
     lista_asistencias.showModal();
   
   }







function openGrupos(id) {
 // localStorage.setItem("id_sesion", id);

    const lista_grupos = document.getElementById('lista_grupos');
    const table = document.getElementById('table_grupos');
    const filterInput = document.getElementById('filterInputGG');
    lista_grupos.style.width = "80%"; // Tamaño específico deseado, por ejemplo 50%
    lista_grupos.style.height = "80vh"; // Altura específica deseada, por ejemplo 50% de la altura de la ventana
    lista_grupos.style.overflow = "hidden";
  
    var data = [];
  
    $.ajax({
      
       url: "sesion_maestro.php?action=getAll_list",
       type: "POST",
       dataType: "json",
       data: {id:id},
       success: function(data3){  
           console.log("entre aqui");
           //console.log('entropy');
           data=data3
           console.log(data);
           displayTable(data);
                  
       }        
   });
    

  
    filterInput.addEventListener('input', function() {
      const filterValue = this.value.toLowerCase();
      const filteredData = data.filter(item => item.grupo.toLowerCase().includes(filterValue) || item.entrenador.toLowerCase().includes(filterValue));
  
      displayTable(filteredData);
    });
  
    function displayTable(data) {
      table.innerHTML = `
        <tr>
          <th>#</th>
          <th>Gupo</th>
          <th>Entrenador</th>
          <th>Tipo-Grupo</th>
          
        </tr>
        
        ${data.map((item, index) => `
        
          <tr class="seleccionar" onclick="selectRowG('${item.id}')">

            <td>${index+1}</td>
            <td>${item.grupo}</td>
            <td>${item.apellido}</td>
            <td>${item.name_tipo_grupo}</td>
          
          </tr>
          
          `).join('')}
      `;

      
    }
  
 
 
    displayTable(data);
    lista_grupos.showModal();
  }


function openDialog(nombre,id) {
  localStorage.setItem("id_sesion", id);
   console.log(localStorage.getItem("id_sesion")+" definir "+nombre);
   // fila = $(this).closest("tr");
   // id = parseInt(fila.find('td:eq(0)').text());
    const dialog = document.getElementById('dialog');
    const table = document.getElementById('table');
    const filterInput = document.getElementById('filterInput');
    dialog.style.width = "80%"; // Tamaño específico deseado, por ejemplo 50%
    dialog.style.height = "80vh"; // Altura específica deseada, por ejemplo 50% de la altura de la ventana
    dialog.style.overflow = "hidden";
    
    dialog.style.overflow = "hidden";
    var data = [];
    $(".modal-header").css("background-color", "#0101ff");
    $(".modal-header").css("color", "white");
   // $(".modal-header").css("margin", "0");
    $(".button-container").hide(); 
    $(".modal-title").css("color", "white");
    $(".modal-title").text(nombre);  
    $.ajax({
      // url: idurl+"bd/crud.php",
       url: "sesion_maestro.php?action=getSesionG",
       type: "POST",
       dataType: "json",
       data: {id:id},
       success: function(data2){  
           //console.log(data2);
           //console.log('entropy');
           data=data2
           console.log(data);
           displayTable(data);
                  
       }        
   });
    

  
    filterInput.addEventListener('input', function() {
      const filterValue = this.value.toLowerCase();
      const filteredData = data.filter(item => item.grupo.toLowerCase().includes(filterValue) || item.entrenador.toLowerCase().includes(filterValue));
  
      displayTable(filteredData);
    });
  
    function displayTable(data) {
      table.innerHTML = `
        <tr>
          <th>#</th>
          <th>Gupo</th>
          <th>Entrenador</th>
          <th>Tipo-Grupo</th>
          <th>Acción</th>
          
        </tr>
        
        ${data.map((item, index) => `
        
          <tr class="seleccionar" onclick="selectRow('${item.id_sg}','${item.grupo}', '${item.entrenador}', '${item.tipo_grupo}')">

            <td>${index+1}</td>
            <td>${item.grupo}</td>
            <td>${item.nom_ent}</td>
            <td>${item.nom_tg}</td>
            <td> <button onclick=""  class="btn btn-danger btnEliminargrupo"><i class='fa fa-fw fa-trash'></i></button></td>
          </tr>
          
          `).join('')}
      `;

      
    }
  
 
 
    displayTable(data);
    dialog.showModal();
  }
  //----------------------------------------------------------------
  //formulario sesion -grupo ---------------------------------------
  function openForsg() {
    

     const formsg= document.getElementById('formsg');
     const table = document.getElementById('formularisg');
     
   
   
      

     function displayTable() {
      const id_sesion = localStorage.getItem("id_sesion");
      console.log(id_sesion);
       table.innerHTML = `
       <form id="f_sg">
       <div class="form-group">
         <label for="grupo">Grupo:</label>
         <input type="hidden"  id="id_sesion" value="id_sesion">
         <input type="text" class="form-control" id="grupo">
         
       </div>
       <div class="form-group">
         <label for="entrenador">Entrenador:</label>
         <input type="text" class="form-control" id="entrenador">
       </div>
       <div class="form-group">
         <label for="tipoGrupo">Tipo de Grupo:</label>
         <input type="text" class="form-control" id="tipoGrupo">
       </div>
      
     </form>
       `;
 
       
     }
   
  
  
     displayTable();
     formsg.showModal();
   }




  //----------------------------------------------------------------


//--------------------------------------------------------------
function openDialog2() {
  const dialog2 = document.getElementById('dialog');
  const table = document.getElementById('table');
  const filterInput = document.getElementById('filterInput');

  const data = [
    { nombre: 'Juan', apellido: 'Pérez', rut: '12345' },
    { nombre: 'María', apellido: 'González', rut: '67890' },

 
  ];

  filterInput.addEventListener('input', function() {
    const filterValue = this.value.toLowerCase();
    const filteredData = data.filter(item => item.nombre.toLowerCase().includes(filterValue) || item.apellido.toLowerCase().includes(filterValue) || item.rut.includes(filterValue));

    displayTable(filteredData);
  });

  function displayTable(data) {
    table.innerHTML = `
      <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>RUT</th>
      </tr>
      
      ${data.map((item, index) => `
      <tr  onclick="selectRow2('${item.nombre}', '${item.apellido}', '${item.rut}')">
          <td>${index+1}</td>
          <td>${item.nombre}</td>
          <td>${item.apellido}</td>
          <td>${item.rut}</td>
        </tr>
        
        `).join('')}
    `;

    
  }



  displayTable(data);
  dialog2.showModal();
}




//--------------------------------------------------------------



 //<tr onclick="selectRow('${item.nombre}', '${item.apellido}', '${item.rut}')
   
  function selectRow(id_sg,grupo, entrenador,tipo_grupo) {
    

    localStorage.setItem("id_sg", id_sg);
    
    const selectedData = { id_sg,grupo, entrenador,tipo_grupo };
 
    //console.log('Registro seleccionado:', selectedData);
    $('#table td').click(function() {
      $('#table td').removeClass('seleccionada'); // Elimina la clase 'seleccionada' de todas las celdas
      $(this).parent().find('td').addClass('seleccionada'); // Agrega la clase 'seleccionada' a todos los td de la fila seleccionada
     });
  
    //$(".button-container").show();
    //openForsg();
    //dialog.close();
   
  }
  // cuando seleccionan la fila de los grupos-------------------------------------
  function selectRowG(id_grupo) {
    
    var data = [];
    //localStorage.setItem("id_sg", id_sg);
    let id_sesion = localStorage.getItem("id_sesion");
    console.log(id_sesion+" seleccion");
    $.ajax({
      // url: idurl+"bd/crud.php",
       url: "sesion_maestro.php?action=getGS",
       type: "POST",
       dataType: "json",
       data: {id_grupo:id_grupo,id_sesion:id_sesion},
       success: function(data2){  
           data=data2;
           console.log('ingresado',data.existe); 
           if(data2.existe =='0')
           {
             
            lista_grupos.close();
           $('#table td').removeClass('seleccionada');
           $(".button-container").hide(); 

           $('.mensaje').css("background-color", "#06d6a0");
           
           openDialog("Lista de Grupos de sesión",id_sesion);
           
           mostrarMensaje('¡Grupo Agregado a Sesión con Exito!');

           }else{

            $('.mensaje').css("background-color", "#ff3333");
            mostrarMensaje('¡ERROR: Grupo ya Vinculado a Sesión!');

           }
      
           
           
                  
       }        
   });
 
    
    
 
  }

  // end cuando seleccionan la fila de los grupos-------------------------------------

  function selectAsist(id) {
    var checkbox = document.getElementById("cbox"+id);
    let asistencia = '';
   
    if (checkbox.checked) {
      asistencia = 'Y';
   
      cargarasistencia(id, asistencia);
 
    } else {
         asistencia = 'N';
        
        cargarasistencia(id, asistencia);
    
    }
  }
  function selectjustificado(id,asistem) {
    var checkbox = document.getElementById("cboxj"+id);
    let asistencia = '';
   
    if (checkbox.checked) {
      asistencia = 'J';
   
      cargarasistencia(id, asistencia);
 
    } else {
         asistencia = 'N';
        
        cargarasistencia(id, asistencia);
    
    }
  }

//selectjustificado ----------------------------------------------------
function selectjustificado2(fila,asistem) {
  var Checkboxj = document.getElementById("cboxj"+fila);
  var Checkbox = document.getElementById("cbox"+fila);
  var filatr= document.getElementById("filatr"+fila);
  const id_sesion = localStorage.getItem("id_asistencias");
  var asistencia='';
  
 if (Checkbox.checked && asistem == 'Y') 
    {
     alert('Seleccion invalidada Atleta Marcado como Presente en Sesion');
     return false;
    }
  else if (Checkbox.checked && asistem == 'J') 
    {
      let nombre = "Lista de Atletas";
    
       lista_asistencias.close();
       openAsistencias(nombre,id_sesion);

    }
   else if (Checkbox.checked && asistem == 'N') 
              {
                
              }
    
  else
  {

       if ( asistem == 'N') 
           {
                asistencia ='J';
                cargarasistencia(fila, asistencia);
                $(document).on("click", "#table_asistencias tr", function(){  
                  localStorage.setItem('selectedRow', $(this).index());
              
                 $(this).css('background-color', '#32c718 !import'); // Cambia el color de fondo al hacer clic en la fila
                });
                //lista_asistencias.close();
              //  let nombre = "Lista de Atletas";
              //  console.log(nombre +''+id_sesion);
              //  openAsistencias(nombre,id_sesion);
           }
        else if (asistem == 'J' )
           {
            asistencia ='N';
            cargarasistencia(fila, asistencia);
            $(document).on("click", "#table_asistencias tr", function(){  
               localStorage.setItem('selectedRow', $(this).index());
            //  $(this).css('background-color', 'blue'); // Cambia el color de fondo al hacer clic en la fila
            });
           // lista_asistencias.close();
           // let nombre = "Lista de Atletas";
           // openAsistencias(nombre,id_sesion);

           }
         else{
            

            }
  }
 
}

// en selectjustificado ----------------------------------------------------

 


  function cargarasistencia(id,valor) {
    
    var data = [];
 
    $.ajax({
      // url: idurl+"bd/crud.php",
       url: "sesion_maestro.php?action=getAsistio",
       type: "POST",
       dataType: "json",
       data: {id:id,valor:valor},
       success: function(data2){  
       
                 
       }        
   });
 
  }
  
  function selectasistencia21(id) {
  
    let nombre = "Lista de Atletas";
    console.log(id,nombre );
  //  return false;
    //  openAsistencias(nombre,id);
 
  }


  function seleccionarTodos() {
    var checkboxes = document.getElementsByClassName("checkboxTabla");
    var marcarTodosCheckbox = document.getElementById("marcarTodos");
  
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = marcarTodosCheckbox.checked;
      if (checkboxes[i].checked) 
      {
        var id = checkboxes[i].id
        var ultimosCaracteres = id.slice(4); // Obtener los dos últimos caracteres del ID
      
       $('#table_asistencias tr').removeClass('justificado');
        asistencia = 'Y';
        cargarasistencia(ultimosCaracteres, asistencia);

      } else {
        var id = checkboxes[i].id
        var ultimosCaracteres = id.slice(4); // Obtener los dos últimos caracteres del ID
        $('#table_asistencias tr').removeClass('justificado');
       
        asistencia = 'N';
        cargarasistencia(ultimosCaracteres, asistencia);
      }
      

    }
  }


  // buscar grupo seleccionado-------------------------------------
  function buscarGS(id_grupo,id_sesion) {
    
    var data = [];
   
    $.ajax({
      // url: idurl+"bd/crud.php",
       url: "sesion_maestro.php?action=getBuscarGS",
       type: "POST",
       dataType: "json",
       data: {id_grupo:id_grupo,id_sesion:id_sesion},
       success: function(data2){  
           
           data=data2
          
          
           lista_grupos.close();
           console.log('ingresado',data); 
           $('#table td').removeClass('seleccionada');
           $(".button-container").hide(); 

           openDialog("Lista de Grupos de sesión",id_sesion);
           mostrarMensaje('¡Grupo Agregado a Sesión con Exito!');
                  
       }        
   });
 
    
    
 
  }

  // en buscar grupo seleccionado------------------------------------

  function selectRow2(nombre, apellido, rut) {
    const selectedData = { nombre, apellido, rut };
   // console.log('Registro seleccionado:', selectedData);
    dialog2.close();
    openDialog();

   // console.log('Registro seleccionado');
    // Aquí puedes enviar los datos seleccionados de vuelta a la ventana principal de la forma que necesites
  }
  function cerrarformulario() {
    const formsg= document.getElementById('formsg');
    formsg.close();
   // let nombre = "Lista de Grupos de sesión";
    $(".modal-title").text('Lista de Grupos de sesión');  
    dialog.showModal();
   // openDialog();
  }
  function mostrarMensaje(mensaje) {
    $('.mensaje').text(mensaje).show();
    setTimeout(function() {
      $('.mensaje').hide();
    }, 5000);
  }

  //actualizar tabla
  function displayTableListado(data) {
    const table = document.getElementById('table_asistencias');
    table.innerHTML = `
      <tr>
        <th>#</th>
        <th>Asistencia</th>
        <th>Nombre</th>
        <th>Apellido</th>
        
        
      </tr>
      
      ${data.map((item, index) => `
      
        <tr id="filatr${item.id}" ${(item.asistencia=='J')?`class="justificado"`:`class="seleccionar"`} onclick="selectjustificado('${item.id}','${item.asistencia}')" >

          <td >${index+1}</td>
          <td><input type="checkbox" id="cbox${item.id}"class="checkboxTabla" value="second_checkbox" onchange="selectAsist('${item.id}')" ${(item.asistencia=='Y')?`checked`:``} /></td>
          <td>${item.nombre}</td>
          <td>${item.apellido}</td>
     
        
        </tr>
        
        `).join('')}
    `;

    
  }

  // en actualizar tabla
 
  

