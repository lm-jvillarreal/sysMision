<?php
include '../global_seguridad/verificar_sesion.php';
$fecha1 = (new DateTime('first day of this month'))->format('Y-m-d');
$fecha2 = (new DateTime('last day of this month'))->format('Y-m-d');
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
      <?php include 'menuV4.php'; ?>
      <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Filtro por fechas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <label for="">*Fecha 1</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha1; ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha1" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha1; ?>" readonly id="fecha1" name="fecha1">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
              <div class="col-md-6">
                <label for="">*Fecha 2</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha2; ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha2" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha2; ?>" readonly id="fecha2" name="fecha2">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type="button" class="btn btn-danger" onclick="cargar_resultados();">Generar</button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">TOP 3 DE ENTRADAS CON/SIN ORDEN DE COMPRA:</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla1">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">TOP MOVIMIENTOS DE INVENTARIO</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla2">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">ENTRADAS POR TIENDA (COMPADADO MES ANTERIOR)</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla3">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">MOVIMIENTOS DE INVENTARIO</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla4">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">FRECUENCIA DE ERRORES</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="tabla5">
                  </div>
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
  <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
  <!-- Page script -->
  <script>
    function cargar_resultados() {
      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();

      $.ajax({
        type: "POST",
        url: 'tabla1.php',
        data: {
          'fecha1': fecha1,
          'fecha2': fecha2
        },
        success: function(respuesta) {
          $('#tabla1').html(respuesta);
        }
      });
      $.ajax({
        type: "POST",
        url: 'tabla5.php',
        data: {
          'fecha1': fecha1,
          'fecha2': fecha2
        },
        success: function(respuesta) {
          $('#tabla5').html(respuesta);
        }
      });
      $.ajax({
        type: "POST",
        url: 'tabla3.php',
        data: {
          'fecha1': fecha1,
          'fecha2': fecha2
        },
        success: function(respuesta) {
          $('#tabla3').html(respuesta);
        }
      });
      $.ajax({
        type: "POST",
        url: 'tabla4.php',
        data: {
          'fecha1': fecha1,
          'fecha2': fecha2
        },
        success: function(respuesta) {
          $('#tabla4').html(respuesta);
        }
      });
      $.ajax({
        type: "POST",
        url: 'tabla2.php',
        data: {
          'fecha1': fecha1,
          'fecha2': fecha2
        },
        success: function(respuesta) {
          $('#tabla2').html(respuesta);
        }
      });
    }
    cargar_resultados();
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