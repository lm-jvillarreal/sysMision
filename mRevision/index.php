<?php
  include '../global_seguridad/verificar_sesion.php';
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <?php include '../header.php'; ?>
  </header>
  <link rel="stylesheet" type="text/css" href="estilo_imagen.css">
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include 'menuV.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Revisión de facturas</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                	<input type="text" name="id_registro" id="id_registro" class="hidden">
                  <label for="proveedor">*Proveedor</label>
                  <select id="proveedor" name="proveedor" class="form-control"></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="comprador">*Factura</label>
                  <input type="text" name="factura" id="factura" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="ap_materno">*Tipo</label>
                  <select name="tipo" id="tipo" class="select form-control">
                    <option selected disabled>Seleccione...</option>
                  	<option value="ENTSOC">Entrada sin orden</option>
                  	<option value="ENTCOC">Entrada con orden</option>
                  </select>
                </div>
              </div>
            </div>
            <br>
            <div class="row" style="display: none" id="imagenes">
            	<div class="col-md-12">
                <div class="col-md-1"></div>
            		<div class="col-md-5">
		              <div class="form-group">
		               	<label for="IP">*Imagen Presentacion</label>
		               	<input type="file" name="IP" id="IP">
                    <br>
                    <img src="" id="imagen_presentacion" width="200px" class="img-rounded zoom">
				          </div>
		            </div>
		            <div class="col-md-5">
		              <div class="form-group">
		               	<label for="IC">*Imagen Codigo</label>
		               	<input type="file" name="IC" id="IC">
                    <br>
                    <img src="" id="imagen_codigo" width="200px" class="img-rounded zoom">
				          </div>
		            </div>
                <div class="col-md-1"></div>
            	</div>
            </div>
          </div>
          <div class="box-footer text-right">
            <a href="#" onclick="cargar_tabla()" class="btn btn-warning">Buscar</a>
            
          </div>
          </form>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Altas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_altas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Folio</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tfoot>
	                  <tr>
                        <th>#</th>
                        <th>Sucursal</th>
                        <th>Folio</th>
                        <th>Fecha</th>
	                  </tr>
                  	</tfoot>  
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include '../footer2.php'; ?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include '../footer.php'; ?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    $('.select').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
<script>
    function estilo_tablas () {
    $('#lista_altas').DataTable({
      'paging'    : false,
      'lengthChange'  : true,
      'searching'   : true,
      'ordering'    : true,
      'info'      : true,
      'autoWidth'   : true,
      'language'    : {"url": "../plugins/DataTables/Spanish.json"}
    })
   }
  function cargar_tabla () {

    var tipo = $('#tipo').val();
    var proveedor = $('#proveedor').val();
    var factura =  $('#factura').val();

      $('#lista_altas').dataTable().fnDestroy();
      $('#lista_altas').DataTable( {
          'language': {"url": "../plugins/DataTables/Spanish.json"},
          "paging":   false,
          "dom": 'Bfrtip',
            buttons: [
              {
                extend: 'pageLength',
                text: 'Registros',
                className: 'btn btn-default'
              },
              {
                extend: 'excel',
                text: 'Exportar a Excel',
                className: 'btn btn-default',
                title: 'Modulos-Lista',
                exportOptions: {
                  columns: ':visible'
                }
              },
              {
                extend: 'pdf',
                text: 'Exportar a PDF',
                className: 'btn btn-default',
                title: 'Modulos-Lista',
                exportOptions: {
                  columns: ':visible'
                }
              },
              {
                extend: 'copy',
                text: 'Copiar registros',
                className: 'btn btn-default',
                copyTitle: 'Ajouté au presse-papiers',
                copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                copySuccess: {
                  _: '%d lignes copiées',
                  1: '1 ligne copiée'
                }
              }
            ],
          "ajax": {
              "type": "POST",
              "url": "tabla_consulta.php",
              "dataSrc": "",
              "data": {
                "tipo": tipo,
                "proveedor": proveedor,
                "factura": factura
          },
        },
          "columns": [
              { "data": "s" },
              { "data": "sucursal" },
              { "data": "folio" },
              { "data": "fecha" }
            ]
      });
   }  

  </script>
  <script>
  	$(function () {
	    $('#proveedor').select2({
	      placeholder: 'Seleccione una opcion',
	      lenguage: 'es',
	      //minimumResultsForSearch: Infinity
	      ajax: { 
	     url: "consulta_proveedores.php",
	     type: "post",
	     dataType: 'json',
	     delay: 250,
	     data: function (params) {
	      return {
	        searchTerm: params.term // search term
	      };
	     },
	     processResults: function (response) {
	       return {
	          results: response
	       };
	     },
	     cache: true
	    }
	    })
	 });
    $(function () {
      $('#comprador').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
       url: "consulta_compradores.php",
       type: "post",
       dataType: 'json',
       delay: 250,
       data: function (params) {
        return {
          searchTerm: params.term // search term
        };
       },
       processResults: function (response) {
         return {
            results: response
         };
       },
       cache: true
      }
      })
   });
  </script>
  <script type="text/javascript">
    function liberar(id_registro){
      $.ajax({
        url: 'procesar_registro.php',
        data: '&id_registro='+ id_registro,
        type: "POST",
        success: function(respuesta) {
         estilo_tablas();
        }
      });
    }
  function editar_registro(id_registro){
    $.ajax({
        url: 'editar_registro.php',
        data: '&id_registro='+ id_registro,
        type: "POST",
        success: function(respuesta) {
          var array    = eval(respuesta);
          id_comprador     = array[0];
          nombre_comprador = array[1];
          id_proveedor     = array[2];
          costo            = array[3];
          iva              = array[4];
          ieps             = array[5];
          imagen_p         = array[6];
          imagen_c         = array[7];
          nombre_proveedor = array[8];

          $('#id_registro').val(id_registro);

          if (iva == 1 && ieps == 2){
            $('select option').prop('selected',true);
          }
          else{
            if (iva == 1){
              $('#impuesto').val(iva).trigger('change.select2');
            }
            else{
              $('#impuesto').val(ieps).trigger('change.select2');
            }
          }

          $("#proveedor").select2("trigger", "select", {
            data: { id: id_proveedor, text:nombre_proveedor }
          });
          $("#comprador").select2("trigger", "select", {
            data: { id: id_comprador, text:nombre_comprador }
          });

          $('#costo').val(costo);
          $('#imagenes').show();

          if (imagen_p != null){
            $("#IP").attr("disabled",true);  
          }
          else{
            $( "#imagen_presentacion" ).removeClass( "zoom" );
          }
          if (imagen_c != null){
            $("#IC").attr("disabled",true);  
          }
          else{
            $( "#imagen_codigo" ).removeClass( "zoom" );
          }

          $("#imagen_presentacion").attr("src",imagen_p);
          $("#imagen_codigo").attr("src",imagen_c);
        }
      });
  }
function buscar() {
    $.ajax({
        url: "revisar_factura.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatos').serialize(),
        success: function(respuesta) {
            $('#contenedor_tabla').html(respuesta);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}
  </script>
  <script>
  $(document).ready(function(){
    estilo_tablas();
    $('.zoom').hover(function() {
      $(this).addClass('transition');
    }, function() {
      $(this).removeClass('transition');
    });
  });
</script>
</body>
</html>
