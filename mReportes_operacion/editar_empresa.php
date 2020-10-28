<?php
  include "../global_seguridad/verificar_sesion.php";

  $id = $_GET['id'];
  $cadena_consulta = "SELECT id, nombre, direccion, telefono, giro, sector, nombre_representante, puesto_representante, email_representante FROM empresas WHERE id = '$id'";

  $ejecutar_consulta = mysqli_query($conexion, $cadena_consulta);
  $row = mysqli_fetch_array($ejecutar_consulta);
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
</head>
<body class="hold-transition skin-green-light sidebar-mini">
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
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Registro de M&oacute;dulos del Sistema</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_datos" action="insertar_modulo.php">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nombre_modulo">*Nombre del M&oacute;dulo</label>
                  <input type="hidden" value='<?php echo "$row[0]" ?>'>
                  <input type="text" name="nombre_modulo" id="nombre_modulo" class="form-control" placeholder="Nombre del m&oacute;dulo" value='<?php echo "$row[1]" ?>'>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="nombre_carpeta">*Nombre de la carpeta</label>
                  <input type="text" name="nombre_carpeta" id="nombre_carpeta" class="form-control" placeholder="Nombre de la carpeta">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="descripcion_modulo">*Descripci&oacute;n</label>
                  <input type="text" name="descripcion_modulo" id="descripcion_modulo" class="form-control" placeholder="A&ntilde;ade una descripci&oacute;n">
                </div>
              </div>
            </div>
            <div class="box-footer text-right">
              <button type="submit" class="btn btn-success" id="btn-guardar">Guardar</button>
            </div>
            </form>
          </div>
        </div>
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Lista de Módulos Existentes</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <?php include 'tabla_modulos.php'; ?>
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
<script>
  $(function () {
    $('#lista_modulos').DataTable({
      'paging'    : true,
      'lengthChange'  : true,
      'searching'   : true,
      'ordering'    : true,
      'info'      : true,
      'autoWidth'   : false,
      'language'    : {"url": "../plugins/DataTables/Spanish.json"}

    })  
  })
</script>
</body>
</html>
