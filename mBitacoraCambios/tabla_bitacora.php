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
$fecha2 = _data_last_month_day();
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
            <h3 class="box-title">Bitácora de Cambios | Listado</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha">*Fecha:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" id="fecha1" name="fecha1" value="<?php echo $fecha1 ?>" onchange='cargar_tabla()'>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha">*Fecha:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" id="fecha2" name="fecha2" value="<?php echo $fecha2 ?>" onchange='cargar_tabla()'>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_cambios" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: 0.8em;">
                    <thead>
                      <tr>
                        <th width="3%">#</th>
                        <th width="5%">Tipo</th>
                        <th>Descripcion</th>
                        <th width='5%'>Suc.</th>
                        <th width="10%">F. Captura</th>
                        <th width="10%">F. Libera</th>
                        <th width="5%">Duración</th>
                        <th width="20%">Comentario</th>
                        <th width="5%">Solicita</th>
                        <th width="5%">Libera</th>
                        <th width='5%'>Encargado</th>
                        <th width="5%">Status</th>
                      </tr>
                    </thead>
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
    <?php include 'modal_comentario.php'; ?>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script>
    $(document).ready(function() {
      cargar_tabla();
    })

    function cargar_tabla() {
      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();

      $('#lista_cambios').dataTable().fnDestroy();
      $('#lista_cambios').DataTable({
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
            title: 'Cambios-Bitacora',
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
          },
        ],
        "ajax": {
          "type": "POST",
          "url": "lista_bitacora.php",
          "dataSrc": "",
          "data": {
            'fecha1': fecha1,
            'fecha2': fecha2
          },
        },
        "columns": [{
            "data": "id"
          },
          {
            "data": "tipo"
          },
          {
            "data": "descripcion"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "fecha_captura"
          },
          {
            "data": "fecha_libera"
          },
          {
            "data": "duracion"
          },
          {
            "data": "comentario"
          },
          {
            "data": "solicita"
          },
          {
            "data": "libera"
          },
          {
            "data": "encargado"
          },
          {
            "data": "estatus"
          }
        ]
      });
    }
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