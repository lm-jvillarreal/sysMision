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
                <h3 class="box-title">Incidencias | Lista</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="lista_incidencias" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th width="5%">ID</th>
                            <th width="35%">Incidencia</th>
                            <th width="10%">Gravedad</th>
                            <th width="15%">Categoría</th>
                            <th width="5%">Activo</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>ID</th>
                            <th>Incidencia</th>
                            <th>Gravedad</th>
                            <th>Categoría</th>
                            <th>Activo</th>
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
        $( document ).ready( function () {
        cargar_tabla();
        });
        function cargar_tabla()
        {
          $('#lista_incidencias').dataTable().fnDestroy();
          $('#lista_incidencias').DataTable( 
            {
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "paging":   false,
              "dom": 'Bfrtip',
              "buttons": 
              [
                'copy', 'csv', 'excel', 'pdf', 'print'
              ],
              "ajax": 
              {
                "type": "POST",
                "url": "tabla_incidencias.php",
                "dataSrc": ""
              },
              "columns": 
              [
                { "data": "id_incidencia" },
                { "data": "nombre" },
                { "data": "gravedad" },
                { "data": "clasificacion" }
                { "data": "activo"}
              ]
            });
        }
      </script>
  </html>
