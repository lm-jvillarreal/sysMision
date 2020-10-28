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
      <?php include 'menuV3.php'; ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Movimientos por Usuario</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha 1</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha1" id="fecha1">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_final">*Fecha 2</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha2" id="fecha2">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="fecha_final">*Sucursal</label>
                  <select name="sucursal" id="sucursal" class="form-control"></select>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <a onclick="mostrar_datos();" class="btn btn-warning">Generar</a>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Datos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class='col-md-12'>
                <div id="grafica"></div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_mov" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="3%">#</th>
                        <th>Usuario</th>
                        <th width="5%">SXMCAR</th>
                        <th width="5%">SXMFTA</th>
                        <th width="5%">SXMPAN</th>
                        <th width="5%">SXMTOR</th>
                        <th width="5%">SXMBOD</th>
                        <th width="5%">SXMEDO</th>
                        <th width="5%">SXROB</th>
                        <th width="5%">SXMFCI</th>
                        <th width="5%">SFAACC</th>
                        <th width="5%">SFCBOT</th>
                        <th width="5%">EXVIGI</th>
                        <th width="5%">ECHORI</th>
                        <th width="5%">SCHORI</th>
                        <th width="5%">TRADEP</th>
                        <th width="5%">EXCONV</th>
                        <th width="5%">EXCOMP</th>
                        <th width="5%">SXMVAR</th>
                        <th width="5%">SXCONV</th>
                        <th width="5%">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tbody>
                  </table>
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

  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
  <!-- Page script -->
  <script>
    $(function() {
      $('#sucursal').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: {
          url: "combo_sucursales.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term // search term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      })
    })

    function cargar() {
      var sucursal = $('#sucursal').val();
      var fecha1 = $("#fecha1").val();
      var fecha2 = $("#fecha2").val();

      $('#lista_mov').dataTable().fnDestroy();
      $('#lista_mov').DataTable({
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
          "url": "tabla_mov.php",
          "dataSrc": "",
          "data": {
            'fecha1': fecha1,
            'fecha2': fecha2,
            'sucursal': sucursal
          },
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "Usuario"
          },
          {
            "data": "SXMCAR"
          },
          {
            "data": "SXMFTA"
          },
          {
            "data": "SXMPAN"
          },
          {
            "data": "SXMTOR"
          },
          {
            "data": "SXMBOD"
          },
          {
            "data": "SXMEDO"
          },
          {
            "data": "SXROB"
          },
          {
            "data": "SXMFCI"
          },
          {
            "data": "SFAACC"
          },
          {
            "data": "SFCBOT"
          },
          {
            "data": "EXVIGI"
          },
          {
            "data": "ECHORI"
          },
          {
            "data": "SCHORI"
          },
          {
            "data": "TRADEP"
          },
          {
            "data": "EXCONV"
          },
          {
            "data": "EXCOMP"
          },
          {
            "data": "SXMVAR"
          },
          {
            "data": "SXCONV"
          },
          {
            "data": "Total"
          }
        ]
      });
    }

    function generar() {
      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();
      var sucursal = $('#sucursal').val();

      $.ajax({
        type: "POST",
        dataType: "json",
        url: 'datos2.php',
        data: {
          'fecha1': fecha1,
          'fecha2': fecha2,
          'sucursal': sucursal
        }, // Adjuntar los campos del formulario enviado.
        // async: false,
        success: function(respuesta) {
          var options = {
            chart: {
              renderTo: 'grafica',
              type: 'column'
            },
            title: {
              text: 'CANTIDAD DE MOVIMIENTO POR USUARIO'
            },
            xAxis: {
              type: 'category'
            },
            yAxis: {
              title: {
                text: 'Movimientos'
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
          options.series[0].data = respuesta;
          var chart = new Highcharts.Chart(options);
        }
      });
    }

    function mostrar_datos() {
      generar();
      cargar();
    }
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