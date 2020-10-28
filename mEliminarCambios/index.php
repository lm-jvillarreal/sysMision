<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
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
            <h3 class="box-title">Cambios de Precio | Cambios de Precio pendientes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="folio">*Folio</label>
                  <input type="text" name="folio" id="folio" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sucursal">*Sucursal</label>
                  <select name="sucursal" id="sucursal" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="descripcion">*Descripción</label>
                  <input type="text" id="descripcion" name="descripcion" class="form-control" readonly="true">
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-6">
                <button class="btn btn-danger" id="eliminar_folio">Eliminar folio</button>
              </div>
              <div class="col-md-6 text-right">
                <button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Detalle de Artículo | Detalle de Cambio de precio</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_detalle" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='10%'>Articulo</th>
                        <th>Descripcion</th>
                        <th width='10%'>Folio</th>
                        <th width='10%'>Precio</th>
                      </tr>
                    </thead>
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
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_sucursales.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });
    $(document).ready(function() {
      cargar_tabla();
    })
    $("#mostrar_datos").click(function() {
      cargar_tabla();
      descripcion();
    });
    $("#eliminar_folio").click(function(){
      baja();
    });

    function cargar_tabla() {
      var folio = $("#folio").val();
      var sucursal = $("#sucursal").val();
      $('#lista_detalle').dataTable().fnDestroy();
      $('#lista_detalle').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
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
            extend: 'copy',
            text: 'Copiar registros',
            className: 'btn btn-default',
            copyTitle: 'Ajouté au presse-papiers',
            copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
            copySuccess: {
              _: '%d lignes copiées',
              1: '1 ligne copiée'
            }
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "tabla_detalle.php",
          "dataSrc": "",
          "data": {
            folio: folio,
            sucursal: sucursal
          }
        },
        "columns": [{
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "folio_importacion"
          },
          {
            "data": "precio"
          }
        ]
      });
    }

    function descripcion() {
      var folio = $("#folio").val();
      var sucursal = $("#sucursal").val();
      var url = "consulta_descripcion.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          folio:folio,
          sucursal:sucursal
        },
        success: function(respuesta) {
          if (respuesta == "no_existe") {
            alertify.error("El folio ingresado no existe");
          }else{
            var array = eval(respuesta);
            $("#descripcion").val(array[0]);
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function baja() {
      var folio = $("#folio").val();
      var sucursal = $("#sucursal").val();
      var url = 'baja_folio.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          folio:folio,
          sucursal:sucursal
        },
        success: function(respuesta) {
          if (respuesta == "ok") {
            alertify.success("Folio eliminado correctamente");
            cargar_tabla();
          }
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
      cargar_tabla();
    }
  </script>
</body>

</html>