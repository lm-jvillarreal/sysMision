<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_consulta = "SELECT DISTINCT(detalle_usuario.id_categoria), categorias_modulos.nombre FROM detalle_usuario INNER JOIN categorias_modulos ON detalle_usuario.id_categoria = categorias_modulos.id AND detalle_usuario.id_usuario = '$id_usuario' order by detalle_usuario.id_categoria ASC";
$consulta_categorias = mysqli_query($conexion, $cadena_consulta);
?>
<!DOCTYPE html>
<html>

<head>
  <?php include '../head.php'; ?>
  <link rel="stylesheet" href="efecto.css">
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
        <h2>Panel de Control | Lista de Módulos</h2>
        <?php
        $estado = "collapse-box";
        while ($row_categorias = mysqli_fetch_row($consulta_categorias)) {
          ?>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning <?php echo $estado; ?> box-solid">
                <div class="box-header with-border" data-widget="collapse">
                  <h3 class="box-title"><?php echo $row_categorias[1] ?></h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                    $cadena_modulos = "SELECT modulos.id, modulos.nombre, modulos.descripcion, modulos.nombre_carpeta, modulos.icono, modulos.tema FROM modulos INNER JOIN detalle_usuario ON modulos.id = detalle_usuario.id_modulo AND detalle_usuario.id_usuario = '$id_usuario' AND detalle_usuario.id_categoria = '$row_categorias[0]' AND modulos.activo = '1' ORDER BY  orden ASC";

                    $consulta_modulos = mysqli_query($conexion, $cadena_modulos);
                    while ($row_modulos = mysqli_fetch_row($consulta_modulos)) {
                      ?>
                    <a href="<?php echo '../' . $row_modulos[3]; ?>">
                      <div class="col-lg-3 col-xs-6">
                        <div class="carta-box">
                          <div class="carta">
                            <div class="cara">
                              <div class="small-box <?php echo $row_modulos[5] ?>">
                                <div class="inner">
                                  <br><br>
                                  <p><?php echo $row_modulos[1]; ?></p>
                                </div>
                                <div class="icon">
                                  <i class="ion <?php echo $row_modulos[4] ?>"></i>
                                </div>
                                <div class="small-box-footer">
                                  Ingresar al Módulo <i class="fa fa-arrow-circle-right"></i>
                                </div>
                              </div>
                            </div>
                            <div class="cara detras">
                              <img src="https://placeimg.com/200/250/animals" width="200" height="250px">
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  <?php
                    }
                    ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
        <?php
          $estado = "collapsed-box";
        }
        ?>
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