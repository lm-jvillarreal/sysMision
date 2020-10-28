<?php
include '../global_seguridad/verificar_sesion.php';
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
        <div class="box box-danger" <?php echo $solo_lectura ?>>
          <div class="box-header">
            <h3 class="box-title">Reporte Actividades | Filtros</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>*Fecha 1:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_uno" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha1" name="fecha1">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>*Fecha 2:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_uno" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha2" name="fecha2">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>*Area:</label>
                  <select name="area" id="area" class="form-control" style="width:100%"></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>*Tipo Actividad:</label>
                  <select name="tipo_actividad" id="tipo_actividad" class="form-control" style="width:100%"></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>*Sucursal:</label>
                  <select name="sucursal" id="sucursal" class="form-control" style="width:100%"></select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>*Empleado:</label>
                  <select name="id_usuario" id="id_usuario" class="form-control" style="width:100%"></select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="guardar">Consultar</button>
          </div>
        </div>
        <div class="box box-danger" id="tabla_principal">
          <div class="box-header">
            <h3 class="box-title">Reporte Traspasos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_existencia" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width='5%'>#</th>
                        <th width='17%'>Realiza</th>
                        <th>Actividad</th>
                        <th width='10%'>Area</th>
                        <th width='5%'>Actividad</th>
                        <th width='10%'>Sucursal</th>
                        <th width='5%'>Tiempo</th>
                        <th width='8%'>Fecha</th>
                      </tr>
                    </thead>
                    <tbody>
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
  <!-- Page script -->
  <script>
    $('#area').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_areas.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term
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
    $('#tipo_actividad').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_tipos_actividad.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term
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
            searchTerm: params.term
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
    $('#id_usuario').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "combo_usuarios.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term
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

    function cargar_tabla() {
      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();
      var area = $('#area').val();
      var tipo_actividad = $('#tipo_actividad').val();
      var id_usuario = $('#id_usuario').val();
      var sucursal = $('#sucursal').val();

      $('#lista_existencia').dataTable().fnDestroy();
      $('#lista_existencia').DataTable({
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
            title: 'Control Equipos',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Control Equipos',
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
          "url": "tabla6.php",
          "dataSrc": "",
          "data": {
            'fecha1': fecha1,
            'fecha2': fecha2,
            'area': area,
            'tipo_actividad': tipo_actividad,
            'ide_usuario': id_usuario,
            'sucursal': sucursal
          }
        },
        "columns": [{
            "data": "#"
          },
          {
            "data": "realiza"
          },
          {
            "data": "Actividad"
          },
          {
            "data": "Area"
          },
          {
            "data": "TActividad"
          },
          {
            "data": "Sucursal"
          },
          {
            "data": "Tiempo"
          },
          {
            "data": "Fecha"
          }
        ]
      });
    }
    $('#guardar').click(function() {
      cargar_tabla();
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
  </script>
</body>

</html>