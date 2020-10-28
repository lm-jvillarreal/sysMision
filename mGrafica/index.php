<?php

include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$hora = date("h:i:s");
function _datos_primer_dia_mes_pasado()
{
  $month = date('m');
  $year = date('Y');
  $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

  return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
};

/** Actual month first day **/
function _datos_primer_dia_mes()
{
  $month = date('m');
  $year = date('Y');
  return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
}
$fecha1 = _datos_primer_dia_mes();
$fecha2 =  _datos_primer_dia_mes_pasado();

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
            <h3 class="box-title">Rango del Período | Resumen de Consultorio</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_fechas">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha1">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly id="fecha_inicio" name="fecha_inicio">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha2">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly id="fecha_fin" name="fecha_fin">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </form>

          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Visualizar Resumen</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen de Consultas | Consultorio</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Turnos impresos</span>
                    <span class="info-box-number" id="total_turnos"></span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total de consultas</span>
                    <span class="info-box-number" id="total_consultas"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_consultas"></div>
                    </div>
                    <span class="progress-description" id="porc_consultas">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total de Hombres</span>
                    <span class="info-box-number" id="total_hombres"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_hombres"></div>
                    </div>
                    <span class="progress-description" id="porc_hombres">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total de Mujeres</span>
                    <span class="info-box-number" id="total_mujeres"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_mujeres"></div>
                    </div>
                    <span class="progress-description" id="porc_mujeres">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Consultas Emmanuel Ramirez</span>
                    <span class="info-box-number" id="total_eramirez"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_eramirez"></div>
                    </div>
                    <span class="progress-description" id="porc_eramirez">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Consultas Pilar Reyes</span>
                    <span class="info-box-number" id="total_preyes"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_preyes"></div>
                    </div>
                    <span class="progress-description" id="porc_preyes">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Consultas Javier Prado</span>
                    <span class="info-box-number" id="total_jprado"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_jprado"></div>
                    </div>
                    <span class="progress-description" id="porc_jprado">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Recetas Emmanuel Ramírez</span>
                    <span class="info-box-number" id="total_recetas_eramirez"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_recetas_eramirez"></div>
                    </div>
                    <span class="progress-description" id="porc_recetas_eramirez">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Recetas Pilar Reyes</span>
                    <span class="info-box-number" id="total_recetas_preyes"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_recetas_preyes"></div>
                    </div>
                    <span class="progress-description" id="porc_recetas_preyes">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Recetas Javier Prado</span>
                    <span class="info-box-number" id="total_recetas_jprado"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_recetas_jprado"></div>
                    </div>
                    <span class="progress-description" id="porc_recetas_jprado">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Medicamento Recetado (Unidades)</span>
                    <span class="info-box-number" id="total_medicamento"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_medicamento"></div>
                    </div>
                    <span class="progress-description" id="porc_medicamento">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Med. Surtido E. Ramirez</span>
                    <span class="info-box-number" id="total_surtido_eramirez"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_surtido_eramirez"></div>
                    </div>
                    <span class="progress-description" id="porc_surtido_eramirez">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Med Surtido P. Reyes</span>
                    <span class="info-box-number" id="total_surtido_preyes"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_surtido_preyes"></div>
                    </div>
                    <span class="progress-description" id="porc_surtido_preyes">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Med Surtido J. Prado</span>
                    <span class="info-box-number" id="total_surtido_jprado"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_surtido_jprado"></div>
                    </div>
                    <span class="progress-description" id="porc_surtido_jprado">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Recetas Surtidas</span>
                    <span class="info-box-number" id="total_recSurt"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_recSurt"></div>
                    </div>
                    <span class="progress-description" id="porc_recSurt">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Promedio por receta</span>
                    <span class="info-box-number" id="total_promReceta"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_promReceta"></div>
                    </div>
                    <span class="progress-description" id="porc_promReceta">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                  <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Promedio Edad</span>
                    <span class="info-box-number" id="total_promedio"></span>

                    <div class="progress">
                      <div class="progress-bar" id="prgrs_edad"></div>
                    </div>
                    <span class="progress-description" id="porc_edad">
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
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
    $(document).ready(function(e) {
      cargar_totales();
    });

    function cargar_totales() {
      var fecha_inicio = $("#fecha_inicio").val();
      var fecha_fin = $("#fecha_fin").val();
      var url = "consulta_resumen.php"; // El script a dónde se realizará la petición.
      var sucursal = $("#sucursal").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          fecha_inicio: fecha_inicio,
          fecha_fin: fecha_fin
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          $("#total_turnos").html(array[0]);
          $("#total_consultas").html(array[1]);
          $("#prgrs_consultas").attr("style", "width: " + array[2]);
          $("#porc_consultas").html(array[3]);
          $("#total_hombres").html(array[4]);
          $("#prgrs_hombres").attr("style", "width: " + array[5]);
          $("#porc_hombres").html(array[6]);
          $("#total_mujeres").html(array[7]);
          $("#prgrs_mujeres").attr("style", "width: " + array[8]);
          $("#porc_mujeres").html(array[9]);
          $("#total_eramirez").html(array[10]);
          $("#prgrs_eramirez").attr("style", "width: " + array[11]);
          $("#porc_eramirez").html(array[12]);
          $("#total_preyes").html(array[13]);
          $("#prgrs_preyes").attr("style", "width: " + array[14]);
          $("#porc_preyes").html(array[15]);
          $("#total_jprado").html(array[34]);
          $("#prgrs_jprado").attr("style", "width: " + array[35]);
          $("#porc_jprado").html(array[36]);
          $("#total_promedio").html(array[16]);
          $("#total_recetas_eramirez").html(array[17]);
          $("#prgrs_recetas_eramirez").attr("style", "width: " + array[18]);
          $("#porc_recetas_eramirez").html(array[19]);
          $("#total_recetas_preyes").html(array[20]);
          $("#prgrs_recetas_preyes").attr("style", "width: " + array[21]);
          $("#porc_recetas_preyes").html(array[22]);
          $("#total_recetas_jprado").html(array[37]);
          $("#prgrs_recetas_jprado").attr("style", "width: " + array[38]);
          $("#porc_recetas_jprado").html(array[39]);
          $("#total_medicamento").html(array[23]);
          $("#total_surtido_eramirez").html(array[24]);
          $("#prgrs_surtido_eramirez").attr("style", "width: " + array[25]);
          $("#porc_surtido_eramirez").html(array[26]);
          $("#total_surtido_preyes").html(array[27]);
          $("#prgrs_surtido_preyes").attr("style", "width: " + array[28]);
          $("#porc_surtido_preyes").html(array[29]);
          $("#total_surtido_jprado").html(array[40]);
          $("#prgrs_surtido_jprado").attr("style", "width: " + array[41]);
          $("#porc_surtido_jprado").html(array[42]);
          $("#total_promReceta").html(array[30]);
          $("#total_recSurt").html(array[31]);
          $("#prgrs_recSurt").attr("style", "width: " + array[32]);
          $("#porc_recSurt").html(array[33]);
        }
      });
      return false;
    }
    $("#btn-guardar").click(function() {
      cargar_totales();
    })
  </script>
</body>

</html>