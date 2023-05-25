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
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Cambios de Turno | Bitácora</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_registros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="">ID</th>
                        <th width="">Empleado</th>
                        <th width="">Sucursal</th>
                        <th width="">Turno Actual</th>
                        <th width="">Turno Nuevo</th>
                        <th width="">Horario Nuevo</th>
                        <th width="">Comentario</th>
                        <th width="">Registra</th>
                        <th width="">Autoriza</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th width="">ID</th>
                        <th width="">Empleado</th>
                        <th width="">Sucursal</th>
                        <th width="">Turno Actual</th>
                        <th width="">Turno Nuevo</th>
                        <th width="">Horario Nuevo</th>
                        <th width="">Comentario</th>
                        <th width="">Registra</th>
                        <th width="">Autoriza</th>
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
  function cargar_tabla(){
    $('#lista_registros').dataTable().fnDestroy();
    $('#lista_registros').DataTable( {
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
        "url": "tablaCambios_Sistemas.php",
        "dataSrc": ""
      },
      "columns": [
        { "data": "id" },
        { "data": "nombre" },
        { "data": "sucursal" },
        { "data": "turno_actual" },
        { "data": "turno_nuevo" },
        { "data": "horario" },
        { "data": "comentario"},
        { "data": "registra"},
        { "data": "activo"}
      ]
    });
  }
</script>
</html>
