<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
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
// echo $primer_dia;
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
            <h3 class="box-title">Auditoría de entradas | Filtros</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-datos">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha_inicio">*Fecha de inicio:</label>
                    <div class="input-group date form_date" data-date="<?php echo $primer_dia ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $primer_dia ?>" readonly id="fecha_inicial" name="fecha_inicial">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fecha_fin">*Fecha final:</label>
                    <div class="input-group date form_date" data-date="<?php echo $ultimo_dia ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                      <input class="form-control" size="16" type="text" value="<?php echo $ultimo_dia ?>" readonly id="fecha_final" name="fecha_final">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Visualizar Información</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Auditoría de entradas | Análisis de desempeño</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Díaz Ordaz | EA</span>
                      <span class="info-box-number">
                        <div id="af_do"></div>
                      </span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 0%" id="bp_do"></div>
                      </div>
                      <span class="progress-description">
                        <div id="cal_do"></div>
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Arboledas | EA</span>
                      <span class="info-box-number">
                        <div id="af_ar"></div>
                      </span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 0%" id="bp_ar"></div>
                      </div>
                      <span class="progress-description">
                        <div id="cal_ar"></div>
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Villegas | EA</span>
                      <span class="info-box-number">
                        <div id="af_vi"></div>
                      </span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 0%" id="bp_vi"></div>
                      </div>
                      <span class="progress-description">
                        <div id="cal_vi"></div>
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Allende | EA</span>
                      <span class="info-box-number">
                        <div id="af_all"></div>
                      </span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 0%" id="bp_all"></div>
                      </div>
                      <span class="progress-description">
                        <div id="cal_all"></div>
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">La Petaca | EA</span>
                      <span class="info-box-number">
                        <div id="af_lp"></div>
                      </span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 0%" id="bp_lp"></div>
                      </div>
                      <span class="progress-description">
                        <div id="cal_lp"></div>
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">CEDIS | EA</span>
                      <span class="info-box-number">
                        <div id="af_cedis"></div>
                      </span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 0%" id="bp_cedis"></div>
                      </div>
                      <span class="progress-description">
                        <div id="cal_cedis"></div>
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Montemorelos | EA</span>
                      <span class="info-box-number">
                        <div id="af_mmorelos"></div>
                      </span>

                      <div class="progress">
                        <div class="progress-bar" style="width: 0%" id="bp_mmorelos"></div>
                      </div>
                      <span class="progress-description">
                        <div id="cal_mmorelos"></div>
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Auditoría de entradas | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div id="resp"></div>
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
    function estilo_tablas() {
      $('#lista_detalle').DataTable({
        'paging': true,
        "dom": 'Bfrtip',
          buttons: [
          {
						extend: 'pageLength',
						text: 'Registros',
						className: 'btn btn-default'
					},
					{
						extend: 'excel',
						text: 'Exportar a Excel',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'copy',
						text: 'Copiar registros',
						className: 'btn btn-default',
						copyTitle: 'Ajouté au presse-papiers',
						copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
						copySuccess: {
							_: '%d lignes copiées',
							1: '1 ligne copiée'
						}
					}
				],

        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        }
      })
    };

    function carga_calificaciones() {
      var url = "consulta_calificacion.php"; // El script a dónde se realizará la petición.
      var fecha_inicio = $("input[name='fecha_inicial']").val();
      var fecha_fin = $("input[name='fecha_final']").val();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          fecha_inicial: fecha_inicio,
          fecha_final: fecha_fin
        },
        success: function(respuesta) {
          var array = eval(respuesta);
          $('#af_do').html(array[0]);
          $('#cal_do').html(array[1]);
          $('#bp_do').css("width", array[2]);
          $('#af_ar').html(array[3]);
          $('#cal_ar').html(array[4]);
          $('#bp_ar').css("width", array[5]);
          $('#af_vi').html(array[6]);
          $('#cal_vi').html(array[7]);
          $('#bp_vi').css("width", array[8]);
          $('#af_all').html(array[9]);
          $('#cal_all').html(array[10]);
          $('#bp_all').css("width", array[11]);
          $('#af_lp').html(array[12]);
          $('#cal_lp').html(array[13]);
          $('#bp_lp').css("width", array[14]);
          $('#af_mmorelos').html(array[15]);
          $('#cal_mmorelos').html(array[16]);
          $('#bp_mmorelos').css("width", array[17]);
          $('#af_cedis').html(array[18]);
          $('#cal_cedis').html(array[19]);
          $('#bp_cedis').css("width", array[20]);
        }
      });
      return false;
    }
  </script>
  <script>
    function estilo_tablas2() {
      $('#lista_detalle2').DataTable({
        'paging': true,
        "dom": 'Bfrtip',
            buttons: [
          {
						extend: 'pageLength',
						text: 'Registros',
						className: 'btn btn-default'
					},
					{
						extend: 'excel',
						text: 'Exportar a Excel',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'pdf',
						text: 'Exportar a PDF',
						className: 'btn btn-default',
						title: 'Modulos-Lista',
						exportOptions: {
							columns: ':visible'
						}
					},
					{
						extend: 'copy',
						text: 'Copiar registros',
						className: 'btn btn-default',
						copyTitle: 'Ajouté au presse-papiers',
						copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
						copySuccess: {
							_: '%d lignes copiées',
							1: '1 ligne copiée'
						}
					}
				],
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        }
      })
    }
  </script>
  <script>
    $(function() {
      $("#btn-guardar").click(function() {
        var url = "tabla.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form-datos").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta) {
            $('#resp').html(respuesta);
            estilo_tablas();
            estilo_tablas2();
            carga_calificaciones();
          }
        });
        return false;
      });
    });
  </script>
  <script type="text/javascript">
    $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
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
    $('.form_time').datetimepicker({
      language: 'fr',
      weekStart: 1,
      todayBtn: 1,
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