<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora = date("h:i:s");
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
        <form method="POST" id="form_datoss" action="lista_movimientos.php">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Auditoría de movimientos | Filtros</h3>
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
                      <option value="5">La Petaca</option>
                      <option value="99">CEDIS</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="estatus_movimiento">*Status:</label>
                    <select name="estatus_movimiento" id="estatus_movimiento" class="form-control select">
                      <option value=""></option>
                      <option value="1">Capturado (Sin Contabilizar)</option>
                      <option value="2">Afectado (Contabilizado)</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <a href="#" class="btn btn-success" onclick="resumen();"><i class="fa fa-search"></i> Ver resumen</a>
              <a href="#" class="btn btn-danger" onclick="reporte();"><i class="fa fa-file-excel-o"></i> Generar Reporte</a>
              <button class="btn btn-warning"><i class="fa fa-search"></i> Visualizar Información</button>
            </div>
          </div>
        </form>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resumen | Auditoría de Movimientos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_movimientos" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='20%'>Movimiento</th>
                        <th>Retraso</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Movimiento</th>
                        <th>Retraso</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">

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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
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
    $(function() {
      $('.select').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        minimumResultsForSearch: Infinity
      })
    });

    function reporte() {
      fecha_inicial = $("#fecha_inicial").val();
      fecha_final = $("#fecha_final").val();
      sucursal = $("#sucursal").val();
      var page = 'generar_reporte.php?fi=' + fecha_inicial + '&ff=' + fecha_final + '&suc=' + sucursal;
      $.ajax({
        url: page,
        type: 'POST',
        //data: {fecha_inicial:fecha_inicial, fecha_final:fecha_final, sucursal:sucursal},
        success: function() {
          window.location = page; //you can use window.open also
        }
      });
    }
    $(document).ready(function(e) {
      //cargar_tabla();
    });

    function cargar_tabla() {
      var fi = $("#fecha_inicial").val();
      var ff = $("#fecha_final").val();
      var suc = $("#sucursal").val();
      $('#lista_movimientos').dataTable().fnDestroy();
      $('#lista_movimientos').DataTable({
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
            title: 'FaltantesLista',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'FaltantesLista',
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
          "url": "tabla_movimientos.php",
          "dataSrc": "",
          "data": {
            fi: fi,
            ff: ff,
            suc: suc
          }
        },
        "columns": [{
            "data": "movimiento"
          },
          {
            "data": "retraso"
          }
        ]
      });
    }

    function resumen() {
      cargar_tabla();
    }
  </script>
</body>

</html>