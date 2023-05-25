<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
</head>
<style>
  #modal_kardex {
    width: 100% !important;
  }
</style>

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
            <div class="row">
              <div class="col-md-6 text-left">
                <h3 class="box-title">Compras | Reporte de existencias</h3>
              </div>
              <div class="col-md-6 text-right">

              </div>
            </div>
          </div>
          <div class="box-body">
          <div class="row">
            <form action="reportes/rpt_teoricos_baja.php" method="POST">
              <div class="col-md-2 text-center">
                <button id="btn-reporte_baja" class="btn btn-danger">Generar reporte (Baja)</button>
              </div>
            </form>
            <form action="reportes/rpt_teoricos_restaurant.php" method="POST">
              <div class="col-md-2 text-center">
                <button id="btn-reporte_baja" class="btn btn-success">Generar reporte (Restaurant)</button>
              </div>
            </form>
            <form action="reportes/rpt_teoricos.php" method="POST">
              <div class="col-md-2 text-center">
                <button id="btn-reporte" class="btn btn-warning">Generar reporte (Alta)</button>
              </div>
            </form>
            <form action="reportes/rpt_teoricos_separados.php" method="POST">
              <div class="col-md-2 text-center">
                <button id="btn-reporte_separados" class="btn btn-primary">Generar reporte (Separados)</button>
              </div>
            </form>
            <form action="reportes/rpt_teoricos_cedisRopa.php" method="POST">
              <div class="col-md-2 text-center">
                <button id="btn-reporte_separados" class="btn btn-default">Generar reporte (203 - Ropa)</button>
              </div>
            </form>
          </div>
        </div>
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <?php include 'modal_kardex.php'; ?>
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
    $("#btn-reporte").click(function() {
      $("#form-existencias").submit();
    });
    $("#btn-reporte_baja").click(function() {
      $("#form-existencias_baja").submit();
    });
    $("#btn-reporte_separados").click(function() {
      $("#form-existencias_separados").submit();
    });
  </script>
</body>

</html>