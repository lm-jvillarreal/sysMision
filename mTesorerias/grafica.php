   <?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  function _data_last_month_day() { 
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));
    return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
  /** Actual month first day **/
  function _data_first_month_day() {
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
  $fecha1 = _data_first_month_day();
  $fecha2 = _data_last_month_day(); 
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <style type="text/css">
    #container {
      min-width: 320px;
      max-width: 800px;
      margin: 0 auto;
    }
  </style>
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <?php include '../header.php'; ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include 'menuV5.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger" id="contenedor_tabla">
        <div class="box-header">
          <h3 class="box-title">Tesoreria | Grafica</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-3">
                <label>*Fecha Inicio</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly name="fecha1" id="fecha1" onchange="cargar()">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
              <div class="col-md-3">
                <label>*Fecha Final</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly name="fecha2" id="fecha2" onchange="cargar()">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_final">*Sucursal</label>
                   <select name="sucursal" id="sucursal" class="form-control" onchange="cargar();"></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_final">*Apartado</label>
                   <select name="apartado" id="apartado" class="form-control" onchange="cargar();">
                    <option value=""></option>
                    <option value="1">Efectivos</option>
                    <option value="2">Tarjetas Debito</option>
                    <option value="3">Bonos</option>
                   </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" name="guardar" id="guardar" onclick="regresar();">Regresar</button>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <div class='col-md-8'>
                <div id="grafica"></div>   
              </div>
              <div class='col-md-4'>
                <div id="grafica2"></div>   
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


<!-- Page script -->
 <script>
  $(function(){
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
       url: "combo_sucursales.php",
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
    });
    $('#apartado').select2({
      placeholder: 'Seleccione una opcion '
    });
  })
  function generar(){
    var fecha1   = $('#fecha1').val();
    var fecha2   = $('#fecha2').val();
    var sucursal = $('#sucursal').val();
    var apartado = $('#apartado').val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: 'datos_grafica.php',
      data: {'fecha1':fecha1,'fecha2':fecha2,'sucursal':sucursal,'apartado':apartado}, // Adjuntar los campos del formulario enviado.
      // async: false,
      success: function(respuesta)
      {
        var options = {
          chart: {
              renderTo: 'grafica',
              type: 'column'
          },
          title: {
              text: 'TOTAL DE EFECTIVOS'
          },
          xAxis: {
              type: 'category'
          },
          yAxis: {
              title: {
                  text: 'Cantidad de $'
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
  function generar2(){
    var fecha1 = $('#fecha1').val();
    var fecha2 = $('#fecha2').val();
    var sucursal = $('#sucursal').val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: 'datos_grafica2.php',
      data: {'fecha1':fecha1,'fecha2':fecha2,'sucursal':sucursal}, // Adjuntar los campos del formulario enviado.
      // async: false,
      success: function(respuesta)
      {
        var options = {
          chart: {
              renderTo: 'grafica2',
              type: 'column'
          },
          title: {
              text: 'TOTAL DE PRESTAMOS'
          },
          xAxis: {
              type: 'category'
          },
          yAxis: {
              title: {
                  text: 'Cantidad de $'
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
  function cargar(){
    generar();
    generar2();
  }
  function regresar(){
    $("#sucursal").select2("trigger", "select", {
      data: { id: '', text:'' }
    });
    $("#apartado").select2("trigger", "select", {
      data: { id: '', text:'' }
    });
  }
  cargar();
</script>
<script type="text/javascript">
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
