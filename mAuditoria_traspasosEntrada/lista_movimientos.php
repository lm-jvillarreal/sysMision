<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];

switch ($sucursal) {
  case '1':
    $nombre_sucursal = 'Díaz Ordaz';
    break;

  case '2':
    $nombre_sucursal = 'Arboledas';
    break;

  case '3':
    $nombre_sucursal = 'Villegas';
    break;

  case '4':
    $nombre_sucursal = 'Allende';
    break;

  case '5':
    $nombre_sucursal = 'Petaca';
    break;
  default:
    $nombre_sucursal = '';
    break;
}
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
          <h2>Auditoría de Movimientos | Succ. <?php echo $nombre_sucursal ?></h2>
          <div class="row">
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">MERMA CARNICERIA (SXMCAR)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMCAR'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxmcar = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxmcar);
                  while ($row_sxmcar = oci_fetch_row($consulta_sxmcar)) {
                    if ($row_sxmcar[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxmcar[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxmcar[1] ?>" data-mov="SXMCAR" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmcar[1] . ' - ' . $status . ' ' . $row_sxmcar[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxmcar = oci_num_rows($consulta_sxmcar);
                  if ($cantidad_sxmcar == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">MERMA FRUTAS/VERDURAS (SXMFTA)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMFTA'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxmfta = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxmfta);
                  while ($row_sxmfta = oci_fetch_row($consulta_sxmfta)) {
                    if ($row_sxmfta[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxmfta[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxmfta[1] ?>" data-mov="SXMFTA" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmfta[1] . ' - ' . $status . ' ' . $row_sxmfta[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxmfta = oci_num_rows($consulta_sxmfta);
                  if ($cantidad_sxmfta == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">MERMA PANADERÍA (SXMPAN)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMPAN'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxmpan = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxmpan);
                  while ($row_sxmpan = oci_fetch_row($consulta_sxmpan)) {
                    if ($row_sxmpan[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxmpan[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxmpan[1] ?>" data-mov="SXMPAN" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmpan[1] . ' - ' . $status . ' ' . $row_sxmpan[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxmpan = oci_num_rows($consulta_sxmpan);
                  if ($cantidad_sxmpan == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">MERMA TORTILLERÍA (SXMTOR)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMTOR'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxmtor = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxmtor);
                  while ($row_sxmtor = oci_fetch_row($consulta_sxmtor)) {
                    if ($row_sxmtor[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxmtor[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxmtor[1] ?>" data-mov="SXMTOR" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmtor[1] . ' - ' . $status . ' ' . $row_sxmtor[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxmtor = oci_num_rows($consulta_sxmtor);
                  if ($cantidad_sxmtor == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">MERMA BODEGA (SXMBOD)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMBOD'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxmbod = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxmbod);
                  while ($row_sxmbod = oci_fetch_row($consulta_sxmbod)) {
                    if ($row_sxmbod[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxmbod[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxmbod[1] ?>" data-mov="SXMBOD" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmbod[1] . ' - ' . $status . ' ' . $row_sxmbod[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxmbod = oci_num_rows($consulta_sxmbod);
                  if ($cantidad_sxmbod == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">MERMA MAL ESTADO (SXMEDO)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMEDO'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxmedo = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxmedo);
                  while ($row_sxmedo = oci_fetch_row($consulta_sxmedo)) {
                    if ($row_sxmedo[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxmedo[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxmedo[1] ?>" data-mov="SXMEDO" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmedo[1] . ' - ' . $status . ' ' . $row_sxmedo[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxmedo = oci_num_rows($consulta_sxmedo);
                  if ($cantidad_sxmedo == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">MERMA VARIEDADES (SXMVAR)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMVAR'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxmvar = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxmvar);
                  while ($row_sxmvar = oci_fetch_row($consulta_sxmvar)) {
                    if ($row_sxmvar[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxmvar[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxmvar[1] ?>" data-mov="SXMVAR" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmvar[1] . ' - ' . $status . ' ' . $row_sxmvar[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxmvar = oci_num_rows($consulta_sxmvar);
                  if ($cantidad_sxmvar == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">SALIDA POR ROBO (SXROB)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXROB'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxrob = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxrob);
                  while ($row_sxrob = oci_fetch_row($consulta_sxrob)) {
                    if ($row_sxrob[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxrob[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxrob[1] ?>" data-mov="SXROB" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxrob[1] . ' - ' . $status . ' ' . $row_sxrob[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxrob = oci_num_rows($consulta_sxrob);
                  if ($cantidad_sxrob == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">MERMA FARMACIA (SXMFCI)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMFCI'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sxmfci = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sxmfci);
                  while ($row_sxmfci = oci_fetch_row($consulta_sxmfci)) {
                    if ($row_sxmfci[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sxmfci[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sxmfci[1] ?>" data-mov="SXMFCI" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmfci[1] . ' - ' . $status . ' ' . $row_sxmfci[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sxmfci = oci_num_rows($consulta_sxmfci);
                  if ($cantidad_sxmfci == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">SALIDA FARM. ACCIDENTES (SFAACC)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SFAACC'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sfaacc = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sfaacc);
                  while ($row_sfaacc = oci_fetch_row($consulta_sfaacc)) {
                    if ($row_sfaacc[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sfaacc[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sfaacc[1] ?>" data-mov="SFAACC" data-toggle="modal" data-target="#modal-default"><?php echo $row_sfaacc[1] . ' - ' . $status . ' ' . $row_sfaacc[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sfaacc = oci_num_rows($consulta_sfaacc);
                  if ($cantidad_sfaacc == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">SALIDA FARM. BOTIQUÍN (SFCBOT)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SFCBOT'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_sfcbot = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_sfcbot);
                  while ($row_sfcbot = oci_fetch_row($consulta_sfcbot)) {
                    if ($row_sfcbot[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_sfcbot[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_sfcbot[1] ?>" data-mov="SFCBOT" data-toggle="modal" data-target="#modal-default"><?php echo $row_sfcbot[1] . ' - ' . $status . ' ' . $row_sfcbot[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_sfcbot = oci_num_rows($consulta_sfcbot);
                  if ($cantidad_sfcbot == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">ENTRADA POR VIGILANCIA (EXVIGI)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'EXVIGI'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_exvigi = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_exvigi);
                  while ($row_exvigi = oci_fetch_row($consulta_exvigi)) {
                    if ($row_exvigi[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_exvigi[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_exvigi[1] ?>" data-mov="EXVIGI" data-toggle="modal" data-target="#modal-default"><?php echo $row_exvigi[1] . ' - ' . $status . ' ' . $row_exvigi[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_exvigi = oci_num_rows($consulta_exvigi);
                  if ($cantidad_exvigi == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">ENT. CONV. CHORIZO (ECHORI)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'ECHORI'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_echori = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_echori);
                  while ($row_echori = oci_fetch_row($consulta_echori)) {
                    if ($row_echori[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_echori[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_echori[1] ?>" data-mov="ECHORI" data-toggle="modal" data-target="#modal-default"><?php echo $row_echori[1] . ' - ' . $status . ' ' . $row_echori[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_echori = oci_num_rows($consulta_echori);
                  if ($cantidad_echori == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">SAL. CONV. CHORIZO (SCHORI)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SCHORI'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_schori = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_schori);
                  while ($row_schori = oci_fetch_row($consulta_schori)) {
                    if ($row_schori[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_schori[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_schori[1] ?>" data-mov="SCHORI" data-toggle="modal" data-target="#modal-default"><?php echo $row_schori[1] . ' - ' . $status . ' ' . $row_schori[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_schori = oci_num_rows($consulta_schori);
                  if ($cantidad_schori == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">TRANS. ENTRE DEPTOS. (TRADEP)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'TRADEP'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_tradep = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_tradep);
                  while ($row_tradep = oci_fetch_row($consulta_tradep)) {
                    if ($row_tradep[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_tradep[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_tradep[1] ?>" data-mov="TRADEP" data-toggle="modal" data-target="#modal-default"><?php echo $row_tradep[1] . ' - ' . $status . ' ' . $row_tradep[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_tradep = oci_num_rows($consulta_tradep);
                  if ($cantidad_tradep == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-3">
              <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">ENTR. CONVER. ARTS. (EXCONV)</h3>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <?php
                  $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'EXCONV'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'";
                  //echo $cadena_consulta;
                  $consulta_exconv = oci_parse($conexion_central, $cadena_consulta);
                  oci_execute($consulta_exconv);
                  while ($row_exconv = oci_fetch_row($consulta_exconv)) {
                    if ($row_exconv[3] != '4') {
                      $status = 'Capturado (Sin Contabilizar)';
                    } elseif ($row_exconv[3] == '4') {
                      $status = 'Afectado (Contabilizado)';
                    }
                    ?>
                    <a href="#" data-id="<?php echo $row_exconv[1] ?>" data-mov="EXCONV" data-toggle="modal" data-target="#modal-default"><?php echo $row_exconv[1] . ' - ' . $status . ' ' . $row_exconv[2]; ?></a><br>
                  <?php
                  }
                  $cantidad_exconv = oci_num_rows($consulta_exconv);
                  if ($cantidad_exconv == 0) {
                    echo "<p style='color:#FF0000';>No existen registros</p>";
                  }
                  ?>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
      </div>
      <?php include 'modal.php'; ?>
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
      $(document).ready(function(e) {
        $('#modal-default').on('show.bs.modal', function(e) {
          var id = $(e.relatedTarget).data().id;
          var mov = $(e.relatedTarget).data().mov;
          //alert(id);
          var url = "tabla.php"; // El script a dónde se realizará la petición.
          $.ajax({
            type: "POST",
            url: url,
            data: {
              ide: id,
              movi: mov
            }, // Adjuntar los campos del formulario enviado.
            success: function(respuesta) {
              $('#tabla').html(respuesta);
            }
          });
        });
      });
    </script>
  </body>

  </html>