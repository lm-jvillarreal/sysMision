<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
$hora = date("h:i:s");

function _data_first_month_day()
{
  $month = date('m');
  $year = date('Y');
  return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}

$ultimo_dia = $fecha;
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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Monitoreo de Entradas | Filtros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="fecha_fin">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sucursal">*Sucursal:</label>
                  <select name="sucursal" id="sucursal" class="form-control select">
                    <option value=""></option>
                    <option value="1">Díaz Ordaz</option>
                    <option value="2">Arboledas</option>
                    <option value="3">Villegas</option>
                    <option value="4">Allende</option>
                    <option value="5">Petaca</option>
                    <option value="99">CEDIS</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="mostrar_datos">Mostrar datos</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen | Monitoreo de Entradas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">OC PROGRAMADAS</span>
                    <span class="info-box-number">
                      <div id="totalOC"></div>
                    </span>
                    <div class="progress">
                      <div class="progress-bar" id="prgrsOC"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcientoOC"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box bg-aqua">
                  <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">TOTAL DE ENTRADAS</span>
                    <span class="info-box-number">
                      <div id="total"></div>
                    </span>
                    <div class="progress">
                      <div class="progress-bar" id="prgrsTotal"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcientoTotal"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">TOTAL ENTCOC</span>
                    <span class="info-box-number">
                      <div id="totalENTCOC"></div>
                    </span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrsENTCOC"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcientoENTCOC"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">TOTAL ENTSOC</span>
                    <span class="info-box-number">
                      <div id="totalENTSOC"></div>
                    </span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrsENTSOC"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcientoENTSOC"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">ENTCOC | SURT. PARCIAL</span>
                    <span class="info-box-number">
                      <div id="totalPARCIAL"></div>
                    </span>
                    <div class="progress">
                      <div class="progress-bar" id="prgrsPARCIAL"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcientoPARCIAL"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box bg-aqua">
                  <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">ENTCOC | SURT. COMPLETO</span>
                    <span class="info-box-number">
                      <div id="totalCOMPLETO"></div>
                    </span>
                    <div class="progress">
                      <div class="progress-bar" id="prgrsCOMPLETO"></div>
                    </div>
                    <span class="progress-description">
                      <div id="porcientoCOMPLETO"></div>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
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
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    })
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

    function resumen() {
      var fecha_inicial = $("#fecha_inicial").val();
      var fecha_final = $("#fecha_final").val();
      var sucursal = $("#sucursal").val();
      var url = "consulta_resumen.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          fecha_inicial: fecha_inicial,
          fecha_final: fecha_final,
          sucursal: sucursal
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#total").html(array[0]);
          $("#porcientoTotal").html(array[1] + "% del total general");
          $("#prgrsTotal").attr("style", "width: " + array[1] + "%");
          $("#totalENTCOC").html(array[2]);
          $("#porcientoENTCOC").html(array[3] + "% del total general");
          $("#prgrsENTCOC").attr("style", "width: " + array[3] + "%");
          $("#totalENTSOC").html(array[4]);
          $("#porcientoENTSOC").html(array[5] + "% del total general");
          $("#prgrsENTSOC").attr("style", "width: " + array[5] + "%");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }

    function resumen_oc() {
      var fecha_inicial = $("#fecha_inicial").val();
      var fecha_final = $("#fecha_final").val();
      var sucursal = $("#sucursal").val();
      var url = "consulta_oc.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          fecha_inicial: fecha_inicial,
          fecha_final: fecha_final,
          sucursal: sucursal
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#totalOC").html(array[0]);
          //$("#porcientoTotal").html(array[1] + "% del total general");
          $("#prgrsOC").attr("style", "width: 100%");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }
    function resumen_totales() {
      var fecha_inicial = $("#fecha_inicial").val();
      var fecha_final = $("#fecha_final").val();
      var sucursal = $("#sucursal").val();
      var url = "consulta_totales.php";
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {
          fecha_inicial: fecha_inicial,
          fecha_final: fecha_final,
          sucursal: sucursal
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#totalPARCIAL").html(array[0]);
          $("#porcientoPARCIAL").html(array[1] + "% del total ENTCOC");
          $("#prgrsPARCIAL").attr("style", "width: " + array[1] + "%");
          $("#totalCOMPLETO").html(array[2]);
          $("#porcientoCOMPLETO").html(array[3] + "% del total ENTCOC");
          $("#prgrsCOMPLETO").attr("style", "width: " + array[3] + "%");
        },
        error: function(xhr, status) {
          alert("error");
          //alert(xhr);
        },
      });
    }
    $("#mostrar_datos").click(function() {
      resumen_oc();
      resumen();
      resumen_totales();
    });
  </script>
</body>

</html>