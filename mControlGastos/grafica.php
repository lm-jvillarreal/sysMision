<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
    $fecha = date('Y-m-d');

    function _data_first_month_day() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }
    $primer_dia = _data_first_month_day($fecha);
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
		<div class="box-body">
			<div class="box box-danger">
				<div class="box-header">
					<h3 class="box-title">*Filtros Grafica</h3>
				</div>
				<div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="llave_banorte">*Fecha Inicio</label>
                                    <div class="input-group date form_date" data-date="<?php echo $primer_dia ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                                        <input class="form-control" size="16" type="text" value="<?php echo $primer_dia ?>" readonly id="fecha_inicio" name="fecha_inicio" >
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="llave_banorte">*Fecha Fin</label>
                                    <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                                        <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_fin" name="fecha_fin" >
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="box-footer text-right">
                                <button class="btn btn-warning" id="guardar" onclick="generar()">Generar</button>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="box-footer"></div>
			</div>
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">Grafica Gastos</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div id="grafica" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
                <div class="box-footer"></div>
            </div>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php include '../footer2.php'; ?>
 	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>

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
	function generar(){
        var fecha1 = $('#fecha_inicio').val();
        var fecha2 = $('#fecha_fin').val();
        var url    = "datos_grafica.php"; // El script a dónde se realizará la petición.
        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: {'fecha1':fecha1,'fecha2':fecha2}, // Adjuntar los campos del formulario enviado.
            // async: false,
            success: function(respuesta)
            {
                var options = {
                    chart: {
                        renderTo: 'grafica',
                        type: 'column'
                    },
                    title: {
                        text: 'Gastos'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: 'Gastos'
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
                                format: '${point.y:,.2f}'
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>${point.y:,.2f}</b><br/>'
                    },
                    series: [{}]
                };
                options.series[0].data= respuesta;
                var chart = new Highcharts.Chart(options);
            }
        });
    }
</script>
<script>
  $('.form_datetime').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1
  });
  $('.form_date').datetimepicker({
    language:  'es',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
  });
  $('.form_time').datetimepicker({
    language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
  });
</script>
</body>
</html>
