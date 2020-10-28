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
$fecha2 =  _data_last_month_day();
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
            <h3 class="box-title">Entradas por Usuario</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha Inicio</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha1 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha1 ?>" readonly id="fecha_inicio" name="fecha_inicio">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_final">*Fecha Final</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha2 ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_final" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha2 ?>" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <a onclick="estilo_tablas()" class="btn btn-warning">Generar Tabla</a>
            <a onclick="generar();" class="btn btn-warning">Generar Grafica</a>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Entradas</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla" style="display: none;">
                <div class="table-responsive">
                  <table id="lista_entradas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="10%"># Usuario</th>
                        <th>Nombre del Usuario</th>
                        <th width="15%">Cant. de Ordenes</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div id="contenedor_grafica" style="display: none;">
                <div id="grafica" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
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

  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
  <!-- Page script -->
  <script>
    function estilo_tablas() {
      $('#contenedor_grafica').hide();
      $('#tabla').show();
      var fecha_inicio = $('#fecha_inicio').val();
      var fecha_final = $('#fecha_final').val();
      $('#lista_entradas').dataTable().fnDestroy();
      $('#lista_entradas').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "paging": false,
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'pageLength',
            text: 'Registros',
            className: 'btn btn-default'
          },
          {
            extend: 'excel',
            text: 'Exportar a Excel',
            className: 'btn btn-default',
            title: 'Entradas Usuario',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Entradas Usuario',
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
        "ajax": {
          "type": "POST",
          "url": "tabla_entradas.php",
          "dataSrc": "",
          "data": {
            'fecha_inicio': fecha_inicio,
            'fecha_final': fecha_final
          },
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "#Usuario"
          },
          {
            "data": "NombreUsuario"
          },
          {
            "data": "Cantidad"
          },
        ]
      });
    }

    function generar() {
      $('#tabla').hide();
      $('#contenedor_grafica').show();
      var fecha_inicio = $('#fecha_inicio').val();
      var fecha_final = $('#fecha_final').val();
      var url = "data.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: {
          'fecha_inicio': fecha_inicio,
          'fecha_final': fecha_final
        }, // Adjuntar los campos del formulario enviado.
        // async: false,
        success: function(respuesta) {
          var options = {
            chart: {
              renderTo: 'grafica',
              type: 'column'
            },
            title: {
              text: 'Grafica de Entradas por Usuario'
            },
            subtitle: {
              text: ''
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              title: {
                text: 'Promedio'
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
              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:,.0f}</b><br/>'
            },
            series: [{}]
          };
          options.series[0].data = respuesta;
          var chart = new Highcharts.Chart(options);
        }
      });
    }
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