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
      <form action="rpt_mercados.php" method="POST" id="frm-mercados">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Reporte de Faltante de Mercados</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="folio_desde">*De</label>
                  <input type="number" class="form-control" id="folio_desde" name="folio_desde">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="folio_desde">*Hasta</label>
                  <input type="number" class="form-control" id="folio_hasta" name="folio_hasta">
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="generar_reporte">Generar Reporte</button>
          </div>
        </div>
      </form>
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
