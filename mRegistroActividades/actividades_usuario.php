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
    <style>
      .modal {
        text-align: center;
        padding: 0!important;
      }
       
      .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
      }
       
      .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
      }
    </style>
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
      <div class="box box-danger" <?php echo $solo_lectura; ?>>
        <div class="box-header">
          <h3 class="box-title">Actividades por Usuario</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            </a>
          </div>
        </div>
        <div class="box-body">
          <!-- <form id="form-datos" method="POST"> -->
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="actividad">*Usuario</label>
                  <select name="usuario" id="usuario" class="form-control" onchange='estilo_tablas()'></select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="actividad">*Fecha 1</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha1" id="fecha1" onchange='estilo_tablas()'>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="actividad">*Fecha 2</label>
                  <div class="input-group date form_date" data-date="<?php echo $fecha ?>" data-date-format="yyyy-mm-dd" data-link-field="fecha_llegada" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha ?>" readonly name="fecha2" id="fecha2" onchange='estilo_tablas()'>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-6">
                <div class="form-group">
                  <label for="descripcion">*Descripcion</label>
                  <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion de Actividad">
                </div>
              </div> -->
            </div>
            <!-- <div class="box-footer text-right">
              <button type="submit" class="btn btn-warning" id="guardar">Guardar</button>
            </div> -->
          <!-- </form> -->
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Actividades</h3>
          <br>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_actividades" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th width="5%">Tiempo</th>
                      <th width="5%">Estatus</th>
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
                  <tfoot>
                    <tr>
                      <th width="5%">#</th>
                      <th>Nombre</th>
                      <th width="10%">Tiempo</th>
                      <th width="5%">Estatus</th>
                    </tr>
                  </tfoot>  
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
    function estilo_tablas() {
      var usuario = $('#usuario').val();
      var fecha1  = $('#fecha1').val();
      var fecha2  = $('#fecha2').val();
      $('#lista_actividades').dataTable().fnDestroy();
      $('#lista_actividades').DataTable( {
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
              title: 'ListaActividades',
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'pdf',
              text: 'Exportar a PDF',
              className: 'btn btn-default',
              title: 'ListaActividades',
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
          "url": "tabla.php",
          "dataSrc": "",
          "data": {'usuario':usuario,'fecha1':fecha1,'fecha2':fecha2},
        },
        "columns": [
          { "data": "#" },
          { "data": "Nombre" },
          { "data": "Tiempo" },
          { "data": "Estatus" }
        ]
      });
    }  
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
    $(function () {
      $('#usuario').select2({
        placeholder: 'Seleccione una opcion',
        lenguage: 'es',
        //minimumResultsForSearch: Infinity
        ajax: { 
         url: "consulta_usuarios.php",
         type: "post",
         dataType: 'json',
         delay: 250,
         data: function (params) {
          return {
            searchTerm: params.term
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
    });    
  </script>
</body>
</html>