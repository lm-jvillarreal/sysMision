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
            <h3 class="box-title">Generar tarjeta de presentación</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <img src="generar_tarjeta.php" alt="" width="100%" class="img-thumbnail">
              </div>
              <div class="col-md-6">
                <img src="generar_qr.php" alt="" width="56%" class="img-thumbnail">
                <img src="generar_qr2.php" alt="" width="56%" class="img-thumbnail" style='display: none'>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
          <a href='anverso.php' class="btn btn-warning"><i class="fa fa-cloud-download"></i> Descargar anverso</a>
          <a href='descargar_tarjeta.php' class="btn btn-danger"><i class="fa fa-cloud-download"></i> Descargar reverso</a>
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
</body>

</html>