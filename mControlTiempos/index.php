<?php
  //include '../global_seguridad/verificar_sesion.php';
  include '../global_settings/conexion.php';
  error_reporting(E_ALL^ E_NOTICE);
 ?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <script src="funciones.js"></script>
</head>
<body class="hold-transition skin-red sidebar-mini" onload="javascript:cargar_tabla()">
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
      <form action="" id="frmDatos">
        <div class=" box box-danger">
          <div class="row">
            <div class="box-header">
              <div class="col-lg-12">
                <h3 class="box-title">Control de Tiempos | Registro</h3>
              </div>
            </div>
            <div class="box-body">
              <div class="col-lg-2">
                <input type="hidden"  id="ctb_usuario" name="ctb_usuario">
                <label for="">Usuario</label>
                <select name="usuario" id="cmb_residente" class="form-control">
                  <option disabled selected value="">Seleccione...</option>
                  <?php 
                    $sql = "SELECT id, nombre_usuario FROM usuarios WHERE id_perfil = 11";
                    $exSql = mysqli_query($conexion, $sql);
                    while ($row = mysqli_fetch_row($exSql)) {
                      echo "<option value=$row[0]>$row[1]</option>";
                    }
                   ?>
                </select>
              </div>
              <div class="col-lg-2">
                <label for="">Fecha:</label>
                <input  name="fecha" type="date" class="form-control">
              </div>
              <div class="col-lg-2">
                <label for="">Hora Inicio:</label>
                <input type="time" name="hora_inicio" class="form-control">
              </div>
              <div class="col-lg-2">
                <label for="">Hora Final</label>
                <input type="time" name="hora_final" class="form-control">
              </div>
              <div class="col-lg-2">
                <label for="">Tipo registro</label> <br>
                <input type="radio" name="tipo" value="1">Extra <br>
                <input type="radio" name="tipo" value="2">Permiso
              </div>
              <div class="col-lg-2">
                <label for="">Comentarios</label>
                <textarea name="comentarios" id="" class="form-control" cols="10" rows="1"></textarea>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="box-footer text-right">
                <a href="javascript:guardar()" class="btn btn-danger">Guardar</a>
              </div>
            </div>
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
                <h3 class="box-title">Control de tiempos | Lista de registros</h3>
              </div>
            </div>
            <div class="box-body">
              <div class="col-lg-12">
                <div id="contenedor"></div>
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
  <script>
      $("#cmb_residente").select2({
        allowClear: true
    });
  </script>

</body>
</html>
