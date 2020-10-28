<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha_inicio = date('Y-01-01');
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
      <?php include 'menuV2.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen de Traspasos de entradas | Filtros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha inicial:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha_inicio ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha_inicio ?>" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_fin">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha_fin ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha_fin ?>" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-danger" id="btn-mostrar">Filtrar Resultados</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen de Traspasos de entradas | Cantidad por Sucursal</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-caret-square-o-right"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">DIAZ ORDAZ</span>
                    <span class="info-box-number">
                      <div id="totalDO"></div>
                    </span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 0%" id="prgrsDO"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcentajeDO"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-caret-square-o-right"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">ARBOLEDAS</span>
                    <span class="info-box-number">
                      <div id="totalARB"></div>
                    </span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 0%" id="prgrsARB"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcentajeARB"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-caret-square-o-right"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">VILLEGAS</span>
                    <span class="info-box-number">
                      <div id="totalVILL"></div>
                    </span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 0%" id="prgrsVILL"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcentajeVILL"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                  <span class="info-box-icon"><i class="fa fa-caret-square-o-right"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">ALLENDE</span>
                    <span class="info-box-number">
                      <div id="totalALL"></div>
                    </span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 0%" id="prgrsALL"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcentajeALL"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div id="detalleDO" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
              <div class="col-md-6">
                <div id="detalleARB" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div id="detalleVILL" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
              <div class="col-md-6">
                <div id="detalleALL" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <?php include 'modal.php'; ?>
    <!-- /.content-wrapper -->
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
  <script type="text/javascript">
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

    function totales() {
      var url = "consulta_totales.php";
      var fecha_inicio = $("#fecha_inicial").val();
      var fecha_fin = $("#fecha_final").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          fecha_inicio: fecha_inicio,
          fecha_fin: fecha_fin
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#totalDO").html(array[0]);
          $("#porcentajeDO").html(array[1] + " del total general");
          $("#prgrsDO").attr("style", "width: " + array[1] + "%");
          $("#totalARB").html(array[2]);
          $("#porcentajeARB").html(array[3] + " del total general");
          $("#prgrsARB").attr("style", "width: " + array[3] + "%");
          $("#totalVILL").html(array[4]);
          $("#porcentajeVILL").html(array[5] + " del total general");
          $("#prgrsVILL").attr("style", "width: " + array[5] + "%");
          $("#totalALL").html(array[6]);
          $("#porcentajeALL").html(array[7] + " del total general");
          $("#prgrsALL").attr("style", "width: " + array[7] + "%");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }
    $("#btn-mostrar").click(function() {
      totales();
      detalle_traspasos(1,'detalleDO','Enviado desde Diaz Ordaz');
      detalle_traspasos(2,'detalleARB','Enviado desde Arboledas');
      detalle_traspasos(3,'detalleVILL','Enviado desde Villegas');
      detalle_traspasos(4,'detalleALL','Enviado desde Allende');
    })

    function detalle_traspasos(sucursal, div, texto) {
      var url = "datos_grafica.php";
      var fecha_inicio = $("#fecha_inicial").val();
      var fecha_fin = $("#fecha_final").val();
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
              text: 'Resumen de Traspasos'
            },
            subtitle: {
              text: texto
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              title: {
                text: 'Total de traspasos'
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
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>$ {point.y:,.2f}</b> del total<br/>'
            },

            "series": [{
              "name": "Traspasos",
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