<?php
  include '../global_seguridad/verificar_sesion.php';
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d");   
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
          <h3 class="box-title">Grafica Devoluciones</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4">
                <label>*Tipo</label>
                <select name="tipo" id="tipo" class="form-control" onchange="generar()">
                  <option value=""></option>
                  <option value="1">Proveedor</option>
                  <option value="2">Tipo Devolucion</option>
                  <option value="3">Sucursal</option>
                  <option value="4">Usuario Libera</option>
                  <option value="5">Usuario Registra</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>*Fecha Inicio</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha1" id="fecha1" onchange="generar()">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
              <div class="col-md-4">
                <label>*Fecha Final</label>
                <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha2" id="fecha2" onchange="generar()">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" id="tabla_promotores">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Grafica</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class='col-md-12'>
                  <div id="grafica"></div>   
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
  function generar(){
    var fecha1 = $('#fecha1').val();
    var fecha2 = $('#fecha2').val();
    var tipo   = $('#tipo').val();

    if(tipo != "" || fecha1 != "" || fecha2 != ""){
      $.ajax({
          type: "POST",
          dataType: "json",
          url: 'datos.php',
          data: {'fecha1':fecha1,'fecha2':fecha2,'tipo':tipo}, // Adjuntar los campos del formulario enviado.
          // async: false,
          success: function(respuesta)
          {
            var options = {
              chart: {
                  renderTo: 'grafica',
                  type: 'column'
              },
              title: {
                  text: 'GRAFICA DEVOLUCIONES'
              },
              xAxis: {
                  type: 'category'
              },
              yAxis: {
                  title: {
                      text: 'Cantidad'
                  }
              },
              legend: {
                  enabled: false
              },
              plotOptions: {
                  series: {
                      borderWidth: 0,
                      dataLabels: {
                          enabled: true
                      }
                  }
              },
              tooltip: {
                  headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b></b><br/>'
              },
              series: [{}]
            };
            options.series[0].data= respuesta;
            var chart = new Highcharts.Chart(options);
          }
      });
    }
  }
  $(function () {
    $('#tipo').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  });
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
