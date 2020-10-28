<?php
  include '../global_seguridad/verificar_sesion.php';
  //Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y'))); 
  $hora=date ("h:i:s");
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
              <h3 class="box-title">Consultar Medicamentos</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_inicio">Folio:</label>
                      <input   type="text" id="folio" name="folio" class="form-control">
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button id="btn-guardar" class="btn btn-danger">Ver Receta</button>
            </div>
          </div>
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Consultar Medicamentos</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="surtido" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Nombre Generico</th>
                          <th>Nombre Farmacia</th>
                          <th width="10%">Surtido</th>
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
    function cargar_tabla(){
      var folio = $("#folio").val();
      $('#surtido').dataTable().fnDestroy();
      $('#surtido').DataTable({
          'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   true,
              "dom": 'Bfrtip',
              "buttons": [
              'copy', 'csv', 'excel', 'pdf', 'print'
              ],
          "ajax": {
              "type": "POST",
              "url": "tabla.php",
              "dataSrc": "",
              "data":{folio: folio}
          },
          "columns": [
              { "data": "nombre_generico" },
              { "data": "nombre_farmacia" },
              { "data": "surtido" }
          ]
      });
    };
    $( document ).ready(function() {
      cargar_tabla();
  });
  $("#btn-guardar").click(function(){
    cargar_tabla();
  });
  function surtido(registro){
      var id_registro = registro;
      var url = 'surtido.php';
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {id_registro: id_registro},
        success: function(respuesta) {
          if (respuesta=="ok") {
          alertify.success("Surtido correctamente");
        }
        },
        error: function(xhr, status) {
            alert("error");
            //alert(xhr);
        },
    });
    }
  </script> 
  <script type="text/javascript">
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
  </script>
  </body>
  </html>
