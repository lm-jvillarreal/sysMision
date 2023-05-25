<?php
include '../global_seguridad/verificar_sesion.php';
$folio_pago = $_GET['chk'];
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
            <h3 class="box-title">Desglose de Pagos | Registro</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="folio_pago">Folio de pago:</label>
                  <input type="text" name="folio_pago" id="folio_pago" class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Desglose de Pagos | Listado de facturas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_facturas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='20%'>Proveedor</th>
                        <th width=15%>Factura</th>
                        <th>Desc. Factura</th>
                        <th width='8%'>Monto</th>
                        <th width='5%'>N.C.</th>
                        <th width='5%'>C.F.</th>
                        <th width='5%'>C.P.</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <div class="row">
              <div class="col-md-6">
                <h3 class="box-title">Desglose de pagos | Notas de crédito</h3>
              </div>
              <div class="col-md-6">
                <h3 class="box-title">Desglose de pagos | Cartas Faltantes</h3>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_nc" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Proveedor</th>
                        <th width='5%'>Folio</th>
                        <th width='5%'>Fecha</th>
                        <th width='5%'>Monto</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_cf" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width='10%'>Folio</th>
                      <th>Tipo</th>
                      <th width='10%'>Monto</th>
                      <th width='20%'></th>
                      <th width='10%'></th>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <div class="row">
              <div class="col-md-6">
                <h3 class="box-title">Desglose de pagos | Dif. Costo</h3>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table id="lista_notasCargo" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <th width='10%'>Folio</th>
                      <th>Tipo Mov</th>
                      <th width='10%'>Monto</th>
                      <th width='5%'></th>
                    </thead>
                    <tbody></tbody>
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
    <?php include 'modal_entradas.php'; ?>
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
  <!-- Page script -->
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script>
    $(document).ready(function(e) {
      $("#folio_pago").val(<?php echo $folio_pago ?>);
      $("#folio_pago").focus();
      cargar_tabla(<?php echo $folio_pago ?>);
      tabla_nc();
      tabla_cf();
      tabla_dc();
    });
    $('#modal-entradas').on('show.bs.modal', function(e) {
      var almacen = $(e.relatedTarget).data().almacen;
      var tipomov = $(e.relatedTarget).data().tipomov;
      var foliomov = $(e.relatedTarget).data().foliomov;
      var ficha = $(e.relatedTarget).data().ficha;
      var fechaafectacion = $(e.relatedTarget).data().fechaafectacion
      $("#almacen").val(almacen);
      $("#tipomov").val(tipomov);
      $("#foliomov").val(foliomov);
      $("#fecha_sello").val(ficha);
      $("#fecha_afectacion").val(fechaafectacion);

      tabla_entrada(almacen, tipomov, foliomov);
    });

    function cargar_tabla() {
      var folio_pago = $("#folio_pago").val();
      $('#lista_facturas').dataTable().fnDestroy();
      $('#lista_facturas').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "asc"]
        ],
        "searching": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_facturas.php",
          "dataSrc": "",
          "data": {
            folio_pago: folio_pago
          }
        },
        "columns": [{
            "data": "proveedor"
          },
          {
            "data": "factura"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "monto"
          },
          {
            "data": "carcre"
          },
          {
            "data": "cf"
          },
          {
            "data": "cp"
          }
        ]
      });
    }

    function tabla_nc(factura) {
      $('#lista_nc').dataTable().fnDestroy();
      $('#lista_nc').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "order": [
          [0, "asc"]
        ],
        "searching": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_nc.php",
          "dataSrc": "",
          "data": {
            factura: factura
          }
        },
        "columns": [{
            "data": "proveedor"
          },
          {
            "data": "folio"
          },
          {
            "data": "fecha"
          },
          {
            "data": "monto"
          }
        ]
      });
    }

    function tabla_cf(factura) {
      var ficha_entrada = $("#ficha_entrada").val();
      $('#lista_cf').dataTable().fnDestroy();
      $('#lista_cf').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "searching": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_cf.php",
          "data": {
            factura: factura
          },
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "tipo"
          },
          {
            "data": "monto"
          },
          {
            "data": "opciones"
          },
          {
            "data": "estatus"
          }
        ]
      });
    };

    function tabla_dc(factura) {
      $('#lista_notasCargo').dataTable().fnDestroy();
      $('#lista_notasCargo').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "searching": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_dc.php",
          "data": {
            factura: factura
          },
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "tipo"
          },
          {
            "data": "monto"
          },
          {
            "data": "opciones"
          }
        ]
      });
    };
    function tabla_entrada(almacen, tipomov, foliomov) {
      $('#lista_entrada').dataTable().fnDestroy();
      $('#lista_entrada').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "searching": false,
        "ajax": {
          "type": "POST",
          "url": "tabla_entrada.php",
          "data": {
            almacen: almacen,
            tipomov: tipomov,
            foliomov: foliomov
          },
          "dataSrc": ""
        },
        "columns": [{
            "data": "artc_articulo"
          },
          {
            "data": "artc_descripcion"
          },
          {
            "data": "um"
          },
          {
            "data": "cantidad"
          },
          {
            "data": "cu"
          },
          {
            "data": "total"
          }
        ]
      });
    };
    $("#folio_pago").keypress(function(e) { //Función que se desencadena al presionar enter
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code == 13) {
        cargar_tabla();
        return false;
      }
    });
  </script>
</body>

</html>