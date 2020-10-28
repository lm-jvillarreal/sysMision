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
  <link rel="stylesheet" type="text/css" href="estilo_imagen.css">
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
          <h3 class="box-title">Ver Ressultados de Encuestas</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-4">
                <div class="form-group">
                  <label>*Encuesta</label>
                  <select id="id_encuesta" name="id_encuesta" class="form-control"></select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>*Usuario</label>
                  <select id="id_usuario" name="id_usuario" class="form-control"></select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>*Usuario Sin Responder</label>
                  <select id="id_usuario" name="id_usuario_sr" class="form-control"></select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="guardar" onclick="estilo_tablas()">Ver Respuestas</button>
          </div>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Respuestas</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_respuesta" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Pregunta</th>
                      <th>Respuesta</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th width="5%">#</th>
                      <th>Pregunta</th>
                      <th>Respuesta</th>
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
 <?php include 'modal2.php'?>
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
  function estilo_tablas() {
    var id_encuesta = $('#id_encuesta').val();
    var id_usuario = $('#id_usuario').val();

    $('#lista_respuesta').dataTable().fnDestroy();
    $('#lista_respuesta').DataTable( {'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "buttons": [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      "ajax": {
        "type": "POST",
        "url": "tabla_respuestas.php",
        "dataSrc": "",
        "data":{'id_encuesta':id_encuesta,'id_usuario':id_usuario},
      },
      "columns": [
        { "data": "#" },
        { "data": "Pregunta" },
        { "data": "Respuesta" }
      ]
    });
  }
  $(function () {
    $('#id_encuesta').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combos_encuestas.php",
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
    });
    $('#id_usuario').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
        url: "combos_usuarios.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          id_encuesta = $('#id_encuesta').val();
          return {
            searchTerm: params.term, // search term
            id_encuesta: id_encuesta
          };
        },
      processResults: function (response) {
        return {
          results: response
        };
      },
      cache: true
    }
    });
  });
</script>
</body>
</html>
