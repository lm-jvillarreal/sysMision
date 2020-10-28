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
            <h3 class="box-title">Firmas Autorizadas | Lista</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_firma" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th width="35%">Nombre</th>
                        <th width="10%">Puesto</th>
                        <th width="10%"> Permisos</th>
                        <th width="10%">Firma</th>
                        <th>Activo</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Permisos</th>
                        <th>Firma</th>
                        <th>Activo</th>
                        <th>Eliminar</th>
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
<?php include 'modal_firmas.php'; ?>
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
  function cargar_tabla(){
    $('#lista_firma').dataTable().fnDestroy();
    $('#lista_firma').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "paging":   false,
      "dom": 'Bfrtip',
      "buttons": [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      "ajax": {
        "type": "POST",
        "url": "tabla_firmas.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "id" },
        { "data": "nombre" },
        { "data": "puesto" },
        { "data": "permisos" },
        { "data": "firma" },
        { "data": "activo" },
        { "data": "eliminar" }

        //{ "data": "actualizado" }
      ]
    });
  }
</script>
</html>
