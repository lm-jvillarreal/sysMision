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
            <h3 class="box-title">Mapeos | Filtros</h3>
          </div>
          <div class="box-body">

          </div>
          <div class="box-footer text-right">
            <button id="btn-SinImprimir" class="btn btn-warning">Mostrar Sin Imprimir</button>
            <button id="btn-impresos" class="btn btn-danger">Mostrar Impresos</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Mapeos | Listado de Mapeos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="collapse multi-collapse" id="multiCollapseExample1">
                  <div class="card card-body" id="contenedor_sin">
                    <?php include 'mapeos_admin.php'; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="collapse multi-collapse" id="multiCollapseExample2">
                  <div class="card card-body" id="contenedor_ya">
                    <?php include 'tabla_impresos.php'; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer"></div>
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
  <script>

  </script>
</body>

</html>