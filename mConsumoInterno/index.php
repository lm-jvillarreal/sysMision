<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha_ant = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$fecha = date('Y-m-d');
$hora = date("h:i:s");
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
            <h3 class="box-title">Libro de entrada | Consumo Interno</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_inicial" name="fecha_inicial">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_final" name="fecha_final">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Visualizar Información</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Libro de entrada | Consumo interno</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='libro_diario' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                    <thead>
                      <tr>
                        <th width="5%">Folio</th>
                        <th width="5%">C.F.</th>
                        <th>Proveedor</th>
                        <th width="5%">Recibo</th>
                        <th width="10%">Factura</th>
                        <th width="5%">Suma</th>
                        <th width="5%">Inicio</th>
                        <th width="5%">Final</th>
                        <th width="5%">Total</th>
                        <th width="10%">Obsrv.</th>
                        <th width="5%">Suc.</th>
                        <th width="5%">Quemar</th>
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
  <!-- Page script -->
  <script>
    $(document).ready(function(e) {
      libro_diario();
    });
    $("#btn-guardar").click(function() {
      libro_diario();
    });

    function libro_diario() {
      fecha_inicio = $("#fecha_inicial").val();
      fecha_fin = $("#fecha_final").val();
      $('#libro_diario').dataTable().fnDestroy();
      $('#libro_diario').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        'order': [
          [0, "desc"]
        ],
        "ajax": {
          "type": "POST",
          "url": "consulta_libroDiario.php",
          "dataSrc": "",
          "data": {
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin
          }
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "generar_carta"
          },
          {
            "data": "no_proveedor"
          },
          {
            "data": "fecha_entrada"
          },
          {
            "data": "factura"
          },
          {
            "data": "total"
          },
          {
            "data": "hora_inicio"
          },
          {
            "data": "hora_final"
          },
          {
            "data": "tiempo_total"
          },
          {
            "data": "observaciones"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "cancelar"
          }
        ]
      });
    }
    $('.form_date').datetimepicker({
      language: 'es',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0
    });
  </script>
</body>

</html>