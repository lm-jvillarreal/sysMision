function cargar_tabla()
    {
      $('#lista').dataTable().fnDestroy();
      $('#lista thead th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" style="width:100%" />' );
      });
      var table = $('#lista').DataTable( 
          {
              aLengthMenu: [
                  [25, 50, 100, 200, -1],
                  [25, 50, 100, 200, "All"]
              ],
              iDisplayLength: -1,
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              "buttons": [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
              "ajax": {
                  "type": "POST",
                  "url": "tabla.php",
                  "dataSrc": "",
                  "data": {}
              },
              "columns": [
                  { "data": "#" },
                  // { "data": "Codigo" },
                  { "data": "Bodega" },
                  { "data": "Nombre" },
                  { "data": "Proveedor" },
                  { "data": "Existencia" },
                  { "data": "Pedir" },
                  { "data": "Editar" }
              ]
          });
          table.columns().every( function () {
		        var that = this;
		        $( 'input', this.header() ).on( 'keyup change', function () {
		            if ( that.search() !== this.value ) {
		                that
		                  .search( this.value )
		                  .draw();
		            }
		        });
	    	});
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