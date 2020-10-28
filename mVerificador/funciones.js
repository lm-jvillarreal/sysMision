function cargar_tabla()
    {
      $('#lista').dataTable().fnDestroy();
      $('#lista').DataTable( 
          {
              aLengthMenu: [
                  [25, 50, 100, 200, -1],
                  [25, 50, 100, 200, "All"]
              ],
              iDisplayLength: -1,
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "ajax": {
                  "type": "POST",
                  "url": "tabla.php",
                  "dataSrc": "",
                  "data": {}
              },
              "columns": [
                  { "data": "#" },
                  { "data": "Bodega" },
                  { "data": "Codigo" },
                  { "data": "Nombre" },
                  { "data": "Descripción" },
                  { "data": "Existencia" },
                  { "data": "Editar" }
              ]
          } );
    }

function CargarBodega()
    {
      $.ajax({
        type: 'POST',
        url: 'obtener_bodega.php',
        success: function(response) 
              {
                document.getElementById("bodega").innerHTML=response;
              }
      });
    }

function CargarSistema()
    {
      $.ajax({
        type: 'POST',
        url: 'obtener_sistema.php',
        success: function(response) 
              {
                document.getElementById("sistema").innerHTML=response;
              }
      });
    }