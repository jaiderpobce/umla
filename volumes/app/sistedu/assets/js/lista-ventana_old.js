function openDialog(nombre,id) {
   // fila = $(this).closest("tr");
   // id = parseInt(fila.find('td:eq(0)').text());
    const dialog = document.getElementById('dialog');
    const table = document.getElementById('table');
    const filterInput = document.getElementById('filterInput');
  
    var data = [];
    $(".modal-title").text(nombre);  
    $.ajax({
      // url: idurl+"bd/crud.php",
       url: "sesion_maestro.php?action=getSesionG",
       type: "POST",
       dataType: "json",
       data: {id:id},
       success: function(data2){  
           console.log(data2);
           console.log('entropy');
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
          
        </tr>
        
        ${data.map((item, index) => `
        <tr onclick="selectRow('${item.grupo}', '${item.entrenador}', '${item.tipo_grupo}')">
            <td>${index+1}</td>
            <td>${item.grupo}</td>
            <td>${item.entrenador}</td>
            <td>${item.tipo_grupo}</td>
          
          </tr>
          
          `).join('')}
      `;

      
    }
  
 
 
    displayTable(data);
    dialog.showModal();
  }

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
      <tr onclick="selectRow2('${item.nombre}', '${item.apellido}', '${item.rut}')">
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
  function selectRow(nombre, apellido, rut) {
    const selectedData = { nombre, apellido, rut };
    console.log('Registro seleccionado:', selectedData);
    dialog.close();
   // console.log('Registro seleccionado');
    // Aquí puedes enviar los datos seleccionados de vuelta a la ventana principal de la forma que necesites
  }
  function selectRow2(nombre, apellido, rut) {
    const selectedData = { nombre, apellido, rut };
    console.log('Registro seleccionado:', selectedData);
    dialog2.close();
    openDialog();

   // console.log('Registro seleccionado');
    // Aquí puedes enviar los datos seleccionados de vuelta a la ventana principal de la forma que necesites
  }
