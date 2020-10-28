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
            <h3 class="box-title">Carga de existencias</h3>
          </div>
          <div class="box-body" id="registro">
            <form method="POST" id="form_datos" >
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                	<input type="text" name="" id="" class="hidden">
                  <label for="proveedor">*Sucursal</label>
                  <select id="sucursal" name="sucursal" class="form-control">
                    <option disabled selected>Seleccione...</option>
                    <option value="1">Diaz Ordaz</option>
                    <option value="2">Arboledas</option>
                    <option value="3">Villegas</option>
                    <option value="4">Allende</option>
                    <option value="5">Petaca</option>
                    <option value="99">CEDIS</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="comprador">*Fecha</label>
                  <input type="date" name="fecha" id="fecha" class="form-control">
                </div>
              </div>
            </div>
          </form>
            <br>
          </div>
          <div class="box-body" id="importar"  style="display: none">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <form id="form_importar">
                    <input type="hidden" name="id_registro" id="id_registro" >
                    <input type="file" name="excel">
                  </form>
                </div>
              </div>
            </div>
            <br>
          </div>
          <div class="box-footer text-right">
            <a href="#" onclick="crear_folio()" class="btn btn-warning">Crear</a>
            <a href="#" onclick="subir_excel()" class="btn btn-warning">Importar</a>
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
  // $(function () {
  //   $('.select2').select2({
  //     placeholder: 'Seleccione una opcion',
  //     lenguage: 'es'
  //   })
  // })
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
function crear_folio() {
    var fecha = $('#fecha').val();
    var sucursal = $('#sucursal').val();

     $.ajax({
        url: "crear_registro.php",
        type: "POST",
        dateType: "html",
        data: {
            "fecha": fecha,
            "sucursal": sucursal
        },
        success: function(respuesta) {
            alertify.success("Registro creado");
            $('#id_registro').val(respuesta);
            $('#importar').removeAttr('style');
            $('#registro').hide();
            
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
<script type="text/javascript">
  function subir_excel() {
    var parametros = new FormData($("#form_importar")[0]);

    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: 'excelamysql/importar.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        contentType: false,
        processData: false,
        beforesend: function() {

        },
        success: function(response) {
          Swal.fire('Existencias Guardadas').
          then(function () {
            location.reload();
          })
          // //alert(response);
          //   alert("Existencias guardadas");
          //   location.reload();
          //   //setTimeout(location.reload(), 10000);
          //   //location.reload.delay();

        }
    });
}
</script>
</body>
</html>
