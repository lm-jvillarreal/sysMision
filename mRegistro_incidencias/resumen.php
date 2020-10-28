<?php
include '../global_seguridad/verificar_sesion.php';
function _data_last_month_day()
{
  $month = date('m');
  $year = date('Y');
  $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
  return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
};
/** Actual month first day **/
function _data_first_month_day()
{
  $month = date('m');
  $year = date('Y');
  return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}
$fecha1 = _data_first_month_day();
$fecha2 = _data_last_month_day();
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
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Control de Incidencias | Registro</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fecha_inicio">*Fecha inicial:</label>
                      <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" id="fecha_inicio" name="fecha_inicio">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fecha_inicio">*Fecha final:</label>
                      <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" id="fecha_fin" name="fecha_fin">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button class="btn btn-warning" id="btnGenerar">Generar resumen</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Control de Incidencias | Resumen</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="info-box bg-yellow">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">DIAZ ORDAZ</span>
                        <span class="info-box-number">
                          <div id="totalDO"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsDO"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoDO"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box bg-red">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">ARBOLEDAS</span>
                        <span class="info-box-number">
                          <div id="totalARB"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsARB"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoARB"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box bg-green">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">VILLEGAS</span>
                        <span class="info-box-number">
                          <div id="totalVILL"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsVILL"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoVILL"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">ALLENDE</span>
                        <span class="info-box-number">
                          <div id="totalALL"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsALL"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoALL"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="info-box bg-yellow">
                      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">LA PETACA</span>
                        <span class="info-box-number">
                          <div id="totalLP"></div>
                        </span>

                        <div class="progress">
                          <div class="progress-bar" id="prgrsLP"></div>
                        </div>
                        <span class="progress-description">
                          <div id="porcientoLP"></div>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
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
                <h3 class="box-title">Resumen de Incidencias | Diaz Ordaz</h3>
              </div>
              <div class="box-body">
                <div id="graficaDO" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Incidencias | Arboledas</h3>
              </div>
              <div class="box-body">
                <div id="graficaARB" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Incidencias | Villegas</h3>
              </div>
              <div class="box-body">
                <div id="graficaVILL" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Incidencias | Allende</h3>
              </div>
              <div class="box-body">
                <div id="graficaALL" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Resumen de Incidencias | La Petaca</h3>
              </div>
              <div class="box-body">
                <div id="graficaLP" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'modal_video.php'; ?>
    <?php include '../footer2.php'; ?>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
			 immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
  <?php include '../footer.php'; ?>
  <!-- Page script -->
  <script>
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
    $(document).ready(function(e) {
      cargar("", "");
    });

    function cargar(fecha_inicio, fecha_fin) {
      var url = "conteo_incidencias.php";
      $.ajax({
        type: "POST",
        url: url,
        data: {
          fecha_inicio: fecha_inicio,
          fecha_fin: fecha_fin
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#totalDO").html(array[0]);
          $("#porcientoDO").html(array[1] + "% del total entregado");
          $("#prgrsDO").attr("style", "width: " + array[1] + "%");
          $("#totalARB").html(array[2]);
          $("#porcientoARB").html(array[3] + "% del total entregado");
          $("#prgrsARB").attr("style", "width: " + array[3] + "%");
          $("#totalVILL").html(array[4]);
          $("#porcientoVILL").html(array[5] + "% del total entregado");
          $("#prgrsVILL").attr("style", "width: " + array[5] + "%");
          $("#totalALL").html(array[6]);
          $("#porcientoALL").html(array[7] + "% del total entregado");
          $("#prgrsALL").attr("style", "width: " + array[7] + "%");
          $("#totalLP").html(array[8]);
          $("#porcientoLP").html(array[9] + "% del total entregado");
          $("#prgrsLP").attr("style", "width: " + array[9] + "%");
        }
      });
    }
    $("#btnGenerar").click(function() {
      var fecha_inicio = $("#fecha_inicio").val();
      var fecha_fin = $("#fecha_fin").val();
      cargar(fecha_inicio, fecha_fin);
      resumen_sucursal(1, 'graficaDO');
      resumen_sucursal(2, 'graficaARB');
      resumen_sucursal(3, 'graficaVILL');
      resumen_sucursal(4, 'graficaALL');
      resumen_sucursal(5, 'graficaLP');
    });

    function resumen_sucursal(sucursal, div) {
      var url = "datos_grafica_suc.php";
      var fecha_inicio = $("#fecha_inicio").val();
      var fecha_fin = $("#fecha_fin").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          fecha_inicio: fecha_inicio,
          fecha_fin: fecha_fin,
          sucursal: sucursal
        },
        success: function(respuesta) {
          Highcharts.chart(div, {
            chart: {
              type: 'column'
            },
            title: {
              text: 'Resumen de Incidencias'
            },
            subtitle: {
              text: 'Conteo por Tipo'
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              title: {
                text: 'Conteo Incidencias'
              }

            },
            legend: {
              enabled: false
            },
            plotOptions: {
              series: {
                borderWidth: 0,
                dataLabels: {
                  enabled: true,
                  format: '{point.y:,.0f}'
                }
              }
            },

            tooltip: {
              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.0f}</b> del total<br/>'
            },

            "series": [{
              "name": "incidencia",
              "colorByPoint": true,
              "data": JSON.parse("[" + respuesta + "]")
            }]
          });
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }
  </script>
</body>

</html>