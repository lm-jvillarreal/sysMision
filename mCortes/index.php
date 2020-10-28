<?php
  //include '../global_seguridad/verificar_sesion.php';
error_reporting(0);

 ?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script src="funciones.js"></script>
</head>
<body class="hold-transition skin-red sidebar-mini" onload="">
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
      <form id="frmDatos" action="rpt_analisis.php" method="POST">
        <div class=" box box-danger">
          <div class="row">
            <div class="box-header">
              <div class="col-lg-12">
                <h1>Faltantes y sobrantes de cajeros</h1>
              </div>
            </div>
            <div class="box-body">
              <div class="col-lg-2">
                <input type="hidden"  id="ctb_usuario" name="ctb_usuario">
                <label for="">Fecha Inicial</label>
                <input name="fecha_inicial" type="date" class="form-control">
              </div>
              <div class="col-lg-2">
                <label for="">Fecha Final:</label>
                <input type="date" class="form-control" name="fecha_final">
              </div>
              <div class="col-lg-2">
                <label for="">Sucursal:</label>
                <select name="sucursal" " id="" class="form-control">
                  <option value="" disabled selected>Seleccione...</option>
                  <option value="1">Diaz Ordaz</option>
                  <option value="2">Arboledas</option>
                  <option value="3">Villegas</option>
                  <option value="4">Allende</option>
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="box-footer text-right">
                <a href="javascript:consulta();" class="btn btn-danger">Consultar</a>
                <input type="submit" class="btn btn-danger" value="Generar excel">
                
              </div>
            </div>


            <hr>
          </div>
        </div>
      </form>
    </section>
    <section class="content">
      <form action="" id="frmDatos">
        <div class=" box box-danger">
          <div class="row">
            <div class="box-header">
              <div class="col-lg-12">
                <h1>Reporte</h1>
              </div>
            </div>
            <div class="box-body">
              <div class="col-lg-12">
                <div id="contenedor_tabla"></div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="box-footer text-right">
                
              </div>
            </div>
            <hr>
          </div>
        </div>
      </form>
    </section>



    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include '../footer2.php'; ?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <!-- <div class="control-sidebar-bg"></div> -->
</div>
<!-- ./wrapper -->

<?php include '../footer.php'; ?>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>

</body>
</html>
