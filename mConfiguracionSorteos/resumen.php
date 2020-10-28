<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha_hoy = date("Y-m-d");
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
          <div class="col-md-6">
            <form action="rpt_detalle_ticket.php" method="POST" id="frm_reporte">
              <div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Detalle de Tickets | Reporte</h3>
                </div>
                <div class="box-body">

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="fecha_inicio">*Fecha inicial:</label>
                        <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                          <input class="form-control" size="16" type="text" value="" readonly id="fecha_inicial" name="fecha_inicial">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="fecha_inicio">*Fecha final:</label>
                        <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                          <input class="form-control" size="16" type="text" value="" readonly id="fecha_final" name="fecha_final">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="sucursal">*Sucursal</label>
                        <select name="sucursal" id="sucursal" class="form-control">
                          <option value=""></option>
                          <option value="1">Diaz Ordaz</option>
                          <option value="2">Arboledas</option>
                          <option value="3">Villegas</option>
                          <option value="4">Allende</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer text-right">
                  <button class="btn btn-warning" id="btn-generar">Generar Excel</button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Detalle de Tickets | Resumen</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fecha_inicio">*Fecha inicial:</label>
                      <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha_hoy; ?>" readonly id="cantInicio" name="cantInicio">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fecha_inicio">*Fecha final:</label>
                      <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha_hoy; ?>" readonly id="cantFin" name="cantFin">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer text-right">
                <button id="btnGenerar" class="btn btn-warning">Generar resumen</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Detalle de Tickets | Resumen</h3>
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
  <!-- Page script -->
  <script>
    $(document).ready(function(e) {
      cargar("", "");
    });

    function cargar(fecha_inicio, fecha_fin) {
      var url = "conteo_boletos.php";
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
        }
      });
    }
    $("#btnGenerar").click(function() {
      var fecha_inicio = $("#cantInicio").val();
      var fecha_fin = $("#cantFin").val();
      cargar(fecha_inicio, fecha_fin);
    });
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
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
  </script>
</body>

</html>