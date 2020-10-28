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
    <?php include 'menuV3.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger" <?php echo $solo_lectura?>>
          <!-- <div class="box box-danger"> -->
          <div class="box-header">
            <h3 class="box-title">Reporte por Actividad</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descripcion_modulo">*Check-List:</label>
                    <select name="checklist" id="checklist" class="form-control"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nombre_carpeta">*Sucursal:</label>
                    <select name="sucursal" id="sucursal" class="form-control"></select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descripcion_modulo">*Desde:</label>
                    <div class="form-group">
                      <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha1" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha?>" readonly id="fecha1" name="fecha1">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="descripcion_modulo">*Hasta:</label>
                    <div class="form-group">
                      <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha2" data-link-format="yyyy-mm-dd">
                        <input class="form-control" size="16" type="text" value="<?php echo $fecha?>" readonly id="fecha2" name="fecha2">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button type="button" class="btn btn-danger" id="guardar" onclick="cargar_tabla()">Generar Resultados</button>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Resultados</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_checklist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th whidth="5%">#</th>
                        <th>Acividad</th>
                        <th>Promedio</th>
                        <th>Descripcion</th>
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

<?php include '../footer.php';?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
  $(function(){
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combo_sucursal.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function (response) {
          return {
            results: response
          };
        },
        cache: true
      }
    })
  })
  $('#checklist').select2({
    placeholder: 'Seleccione una opcion',
    lenguage: 'es',
    //minimumResultsForSearch: Infinity
    ajax: { 
      url: "combo_checklist.php",
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term // search term
        };
      },
      processResults: function (response) {
        return {
          results: response
        };
      },
      cache: true
    }
  })
   function cargar_tabla() {
    var checklist = $('#checklist').val();
    var sucursal  = $('#sucursal').val();

    var fecha1  = $('#fecha1').val();
    var fecha2  = $('#fecha2').val();
    $('#lista_checklist').dataTable().fnDestroy();
    $('#lista_checklist').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
            title: 'Reporte por Actividad',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Reporte por Actividad',
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
        "url": "tabla_r3.php",
        "dataSrc": "",
        "data":{'checklist':checklist,'sucursal':sucursal,'fecha1':fecha1,'fecha2':fecha2}
      },
      "columns": [
        { "data": "#" , "width": "5%"},
        { "data": "Actividad" },
        { "data": "Promedio" , "width": "5%"},
        { "data": "Descripcion" },
      ]
    });
  } 
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
