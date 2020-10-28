<?php

include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$hora=date ("h:i:s");
function _datos_primer_dia_mes_pasado() { 
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
 
  /** Actual month first day **/
  function _datos_primer_dia_mes() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
  $fecha1 = _datos_primer_dia_mes();
  $fecha2 =  _datos_primer_dia_mes_pasado();

 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
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
            <h3 class="box-title">Rangos de Surtido</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_fechas">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha1">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha1" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly id="fecha1" name="fecha1">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha2">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha2" data-link-format="yyyy-mm-dd" >
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly id="fecha2" name="fecha2">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div> 
            </div>
            </form>
            <div class="box-footer text-right">
              <button class="btn btn-warning" onclick="grafica()" id="btn-guardar" >Visualizar Grafica</button>
            </div>
          </div>
        </div>
         <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Grafica | Surtido</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">

                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

                <label id="cantidad"></label><br>
                <label id="surtido"></label><br>
                <label id="no_surtido"></label><br>
                <label id="porcentaje"></label>
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
  function cargar_grafica(surtidos,no_surtidos){

     Highcharts.chart('container', {
     chart: {
     plotBackgroundColor: null,
     plotBorderWidth: null,
     plotShadow: false,
     type: 'pie'
     },
     title: {
       text: 'Grafica de unidades vendidas'
     },
     tooltip: {
       pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
     },
     plotOptions: {
       pie: {
         allowPointSelect: true,
         cursor: 'pointer',
         dataLabels: {
           enabled: false
         },
         showInLegend: true
       }
     },
     series: [{
       name: 'Medicamento',
       colorByPoint: true,
       data: [{
         name: 'Surtido',
         y: surtidos,
         color: '#f57f17',
         sliced: true,
         selected: true
       }, {
         name: 'No surtido',
         color: '#434348',
         y: no_surtidos
       }]
     }]
   });  
}
  
</script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
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
<script>
 function grafica(){
    var fecha1= $("#fecha1").val();
    var fecha2= $("#fecha2").val();
    var url= "calcular_ventas.php";
    
          $.ajax({
          type: "POST",
          url: url,
         data: $("#form_fechas").serialize(),
          success: function(respuesta)
          {
            var array_datos = eval(respuesta);
            var surtidos = array_datos[0];
            var no_surtidos = array_datos[1];
            var porcentaje = array_datos[2];
            
            var cantTexto = "Total de medicamentos: "
            var surtTexto = "Medicamentos surtidos: "
            var nosurtTexto = "Medicamentos no surtidos: "
            var porcTexto = "Porcentaje: "
            
            var cantidad = parseInt(surtidos) + parseInt(no_surtidos);
            var final_cantidad = cantTexto+cantidad;
            var final_surtido = surtTexto +surtidos;
            var final_nosurtido = nosurtTexto + no_surtidos;
            var final_porcentaje = porcTexto + porcentaje + "%";
            
            cargar_grafica(surtidos,no_surtidos);
            $("#cantidad").html(final_cantidad);
            $("#surtido").html(final_surtido);
            $("#no_surtido").html(final_nosurtido);
            $("#porcentaje").html(final_porcentaje);
          }
     });
  }
 grafica();
</script>

</body>
</html>
