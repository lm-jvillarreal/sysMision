<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$fecha_inicio = date("Y-m-01");
$fecha_fin = date("Y-m-d");
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
            <h3 class="box-title">Resumen de Vales de caja | Filtros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha inicial:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha_inicio ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha_inicio ?>" id="fecha_inicio" name="fecha_inicio">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha_fin ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha_fin ?>" id="fecha_fin" name="fecha_fin">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-consultar">Filtrar información</button>
          </div>
        </div>
        <div class="box box-danger" id="contenedor_tabla">
          <div class="box-header">
            <h3 class="box-title">Control de Promotores | Grafica Promedio de Participacion de Promotores</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class='col-md-12'>
                <div id="container"></div>
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
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/highcharts-more.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>


  <!-- Page script -->
  <script>
    $("#btn-consultar").click(function(){
      graficar();
    });

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

    function graficar() {
      var fecha_inicio = $("#fecha_inicio").val();
      var fecha_fin = $("#fecha_fin").val();
      var url = "registro_entrada2.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          fecha_inicio: fecha_inicio,
          fecha_fin: fecha_fin
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          grafica_horas(respuesta);
        }
      });
    }

    function grafica_horas(registro) {
      Highcharts.chart('container', {
        chart: {
          type: 'line'
        },
        title: {
          text: 'Horario'
        },
        xAxis: {
          categories: [<?php include 'promotores_grafica2.php'; ?>]
        },
        yAxis: {
          title: {
            text: 'Cantidad de Horas'
          }
        },
        plotOptions: {
          line: {
            dataLabels: {
              enabled: true
            },
            enableMouseTracking: false
          }
        },
        series: [{
          name: 'Promedio de Horas en la Mision',
          data: JSON.parse("[" + registro + "]")
        }, {
          name: 'Horario',
          data: [<?php include 'horario_grafica2.php'; ?>]
        }]
      });
    }
  </script>
</body>

</html>