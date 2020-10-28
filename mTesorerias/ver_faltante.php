<?php
  include '../global_seguridad/verificar_sesion.php';
  $folio = $_GET['folio'];

  $ejecutar = mysqli_query($conexion,"SELECT SUM(faltante),ROUND(SUM(valor),1) FROM faltantes WHERE folio = '$folio'");
  $row_faltante = mysqli_fetch_array($ejecutar);
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
            <h3 class="box-title">Reporte de Faltantes de Morralla</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_morralla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Moneda</th>
                          <th>Faltante</th>
                          <th >Valor</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                      </tbody>  
                    </table>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-2 col-md-offset-5">
                <h4>Faltante Total:</h4>
                <input type="text" class="form-control" value="<?php echo $row_faltante[0]?>" readonly>
              </div>
              <div class="col-md-2 col-md-offset-2">
                <h4>Valor Total:</h4>
                <input type="text" class="form-control" value="$<?php echo $row_faltante[1]?>0" readonly>
              </div>
            </div>
            <br>
            <div class="box-footer text-right">
              <div class="col-md-12">
                <a href="reporte_excel.php?folio=<?php echo $folio;?>" class="btn btn-warning">Generar Reporte Excel</a>
              </div>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Lista de Faltantes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12" id="tabla">
                <div class="table-responsive">
                  <table id="lista_faltante" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">#</th>
                        <th>Folio</th>
                        <th>Usuario</th>
                        <th>Sucursal</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <th>Ver</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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
  $('#faltante'+1).focus();
</script>
<script>
  function cargar_tabla(folio){
    $('#lista_faltante').dataTable().fnDestroy();
    $('#lista_faltante').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
        "dom": 'Bfrtip',
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
      "ajax": {
          "type": "POST",
          "url": "tabla_morralla.php",
          "dataSrc": "",
          "data": {'folio':folio}
      },
      "columns": [
          { "data": "#" },
          { "data": "Folio" },
          { "data": "Usuario" },
          { "data": "Sucursal" },
          { "data": "Fecha" },
          { "data": "Hora" },
          { "data": "Editar" },
          { "data": "Eliminar" },
          { "data": "Ver" },
      ]
   });
  }
  function cargar_tabla_faltante(folio){
    $('#lista_morralla').dataTable().fnDestroy();
    $('#lista_morralla').DataTable( {
      'paging'    : false,
      'lengthChange'  : false,
      'searching'   : false,
      'ordering'    : true,
      'info'      : false,
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      "ajax": {
          "type": "POST",
          "url": "tabla_faltante.php",
          "dataSrc": "",
          "data": {'folio':folio}
      },
      "columns": [
          { "data": "#" },
          { "data": "Moneda" },
          { "data": "Faltante" },
          { "data": "Valor" }
      ]
   });
  }
</script>
<script>
  cargar_tabla(<?php echo $folio?>);
  cargar_tabla_faltante(<?php echo $folio;?>)
</script>
</body>
</html>