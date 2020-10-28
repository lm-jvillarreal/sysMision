<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_fin = $_POST['fecha_final'];
$sucursal = $_POST['sucursal'];
$estatus_movimiento = $_POST['estatus_movimiento'];

if ($estatus_movimiento == '1') {
  $filtro_estatus = " AND MOVN_ESTATUS <> '4'";
} elseif ($estatus_movimiento == '2') {
  $filtro_estatus = " AND MOVN_ESTATUS = '4'";
} else {
  $filtro_estatus = "";
}
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
    $nombre_sucursal = 'La Petaca';
    break;
  case '99':
    $nombre_sucursal = 'CEDIS';
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
        <h2>Auditoría de Movimientos | Suc. <?php echo $nombre_sucursal ?></h2>
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMCAR'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxmcar[1] ?>" data-mov="SXMCAR" data-suc="<?php echo $row_sxmcar[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmcar[1] . ' - ' . $status . ' ' . $row_sxmcar[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxmcar[4]);
                  $now = new DateTime();
                }
                //$fecha_ultimoMov = date("Y-m-d", strtotime($row_sxmcar[2]));
                $cantidad_sxmcar = oci_num_rows($consulta_sxmcar);
                if ($cantidad_sxmcar == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxmcar . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMFTA'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxmfta[1] ?>" data-mov="SXMFTA" data-suc="<?php echo $row_sxmfta[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmfta[1] . ' - ' . $status . ' ' . $row_sxmfta[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxmfta[4]);
                  $now = new DateTime();
                }
                $cantidad_sxmfta = oci_num_rows($consulta_sxmfta);
                if ($cantidad_sxmfta == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxmfta . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMPAN'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND MOVN_ESTATUS<>'3'
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxmpan[1] ?>" data-mov="SXMPAN" data-suc="<?php echo $row_sxmpan[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmpan[1] . ' - ' . $status . ' ' . $row_sxmpan[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxmpan[4]);
                  $now = new DateTime();
                }
                $cantidad_sxmpan = oci_num_rows($consulta_sxmpan);
                if ($cantidad_sxmpan == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxmpan . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMTOR'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxmtor[1] ?>" data-mov="SXMTOR" data-suc="<?php echo $row_sxmtor[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmtor[1] . ' - ' . $status . ' ' . $row_sxmtor[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxmtor[4]);
                  $now = new DateTime();
                }
                $cantidad_sxmtor = oci_num_rows($consulta_sxmtor);
                if ($cantidad_sxmtor == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxmtor . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMBOD'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxmbod[1] ?>" data-mov="SXMBOD" data-toggle="modal" data-suc="<?php echo $row_sxmbod[0] ?>" data-target="#modal-default"><?php echo $row_sxmbod[1] . ' - ' . $status . ' ' . $row_sxmbod[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxmbod[4]);
                  $now = new DateTime();
                }
                $cantidad_sxmbod = oci_num_rows($consulta_sxmbod);
                if ($cantidad_sxmbod == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxmbod . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMEDO'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxmedo[1] ?>" data-mov="SXMEDO" data-suc="<?php echo $row_sxmedo[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmedo[1] . ' - ' . $status . ' ' . $row_sxmedo[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxmedo[4]);
                  $now = new DateTime();
                }
                $cantidad_sxmedo = oci_num_rows($consulta_sxmedo);
                if ($cantidad_sxmedo == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxmedo . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMVAR'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxmvar[1] ?>" data-mov="SXMVAR" data-toggle="modal" data-suc="<?php echo $row_sxmvar[0] ?>" data-target="#modal-default"><?php echo $row_sxmvar[1] . ' - ' . $status . ' ' . $row_sxmvar[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxmvar[4]);
                  $now = new DateTime();
                }
                $cantidad_sxmvar = oci_num_rows($consulta_sxmvar);
                if ($cantidad_sxmvar == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxmvar . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXROB'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxrob[1] ?>" data-mov="SXROB" data-toggle="modal" data-suc="<?php echo $row_sxrob[0] ?>" data-target="#modal-default"><?php echo $row_sxrob[1] . ' - ' . $status . ' ' . $row_sxrob[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxrob[4]);
                  $now = new DateTime();
                }
                $cantidad_sxrob = oci_num_rows($consulta_sxrob);
                if ($cantidad_sxrob == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxrob . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SXMFCI'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sxmfci[1] ?>" data-mov="SXMFCI" data-suc="<?php echo $row_sxmfci[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_sxmfci[1] . ' - ' . $status . ' ' . $row_sxmfci[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sxmfci[4]);
                  $now = new DateTime();
                }
                $cantidad_sxmfci = oci_num_rows($consulta_sxmfci);
                if ($cantidad_sxmfci == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sxmfci . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SFAACC'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sfaacc[1] ?>" data-mov="SFAACC" data-suc="<?php echo $row_sfaacc[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_sfaacc[1] . ' - ' . $status . ' ' . $row_sfaacc[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sfaacc[4]);
                  $now = new DateTime();
                }
                $cantidad_sfaacc = oci_num_rows($consulta_sfaacc);
                if ($cantidad_sfaacc == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sfaacc . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SFCBOT'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_sfcbot[1] ?>" data-mov="SFCBOT" data-suc="<?php echo $row_sfcbot[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_sfcbot[1] . ' - ' . $status . ' ' . $row_sfcbot[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_sfcbot[4]);
                  $now = new DateTime();
                }
                $cantidad_sfcbot = oci_num_rows($consulta_sfcbot);
                if ($cantidad_sfcbot == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_sfcbot . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'EXVIGI'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
                //echo $cadena_consulta;
                $consulta_exvigi = oci_parse($conexion_central, $cadena_consulta);
                oci_execute($consulta_exvigi);
                while ($row_exvigi = oci_fetch_row($consulta_exvigi)) {
                  if ($row_exvigi[3] != '4' && $row_exvigi[3]!='99') {
                    $status = 'Capturado (Sin Contabilizar)';
                  } elseif ($row_exvigi[3] == '4') {
                    $status = 'Afectado (Contabilizado)';
                  } elseif ($row_exvigi[3] == '99'){
                    $status = 'Cancelado';
                  }
                ?>
                  <a href="#" data-id="<?php echo $row_exvigi[1] ?>" data-mov="EXVIGI" data-suc="<?php echo $row_exvigi[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_exvigi[1] . ' - ' . $status . ' ' . $row_exvigi[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_exvigi[4]);
                  $now = new DateTime();
                }
                $cantidad_exvigi = oci_num_rows($consulta_exvigi);
                if ($cantidad_exvigi == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_exvigi . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'ECHORI'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
                //echo $cadena_consulta;
                $consulta_echori = oci_parse($conexion_central, $cadena_consulta);
                oci_execute($consulta_echori);
                while ($row_echori = oci_fetch_row($consulta_echori)) {
                  if ($row_echori[3] != '4' AND $row_echori[3] != '99') {
                    $status = 'Capturado (Sin Contabilizar)';
                  } elseif ($row_echori[3] == '4') {
                    $status = 'Afectado (Contabilizado)';
                  } elseif ($row_echori[3]=='99'){
                    $status = 'Eliminado';
                  }
                ?>
                  <a href="#" data-id="<?php echo $row_echori[1] ?>" data-mov="ECHORI" data-suc="<?php echo $row_echori[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_echori[1] . ' - ' . $status . ' ' . $row_echori[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_echori[4]);
                  $now = new DateTime();
                }
                $cantidad_echori = oci_num_rows($consulta_echori);
                if ($cantidad_echori == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_echori . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'SCHORI'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_schori[1] ?>" data-mov="SCHORI" data-suc="<?php echo $row_schori[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_schori[1] . ' - ' . $status . ' ' . $row_schori[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_schori[4]);
                  $now = new DateTime();
                }
                $cantidad_schori = oci_num_rows($consulta_schori);
                if ($cantidad_schori == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_schori . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'TRADEP'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
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
                  <a href="#" data-id="<?php echo $row_tradep[1] ?>" data-mov="TRADEP" data-suc="<?php echo $row_tradep[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_tradep[1] . ' - ' . $status . ' ' . $row_tradep[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_tradep[4]);
                  $now = new DateTime();
                }
                $cantidad_tradep = oci_num_rows($consulta_tradep);
                if ($cantidad_tradep == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_tradep . "<br>" . $interval;
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
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'EXCONV'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal'" . $filtro_estatus;
                //echo $cadena_consulta;
                $consulta_exconv = oci_parse($conexion_central, $cadena_consulta);
                oci_execute($consulta_exconv);
                while ($row_exconv = oci_fetch_row($consulta_exconv)) {
                  if ($row_exconv[3] != '4' AND $row_exconv[3] != '99') {
                    $status = 'Capturado (Sin Contabilizar)';
                  } elseif ($row_exconv[3] == '4') {
                    $status = 'Afectado (Contabilizado)';
                  } elseif ($row_exconv[3]=='99'){
                    $status = 'Eliminado';
                  }
                ?>
                  <a href="#" data-id="<?php echo $row_exconv[1] ?>" data-mov="EXCONV" data-suc="<?php echo $row_exconv[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_exconv[1] . ' - ' . $status . ' ' . $row_exconv[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_exconv[4]);
                  $now = new DateTime();
                }
                $cantidad_exconv = oci_num_rows($consulta_exconv);
                if ($cantidad_exconv == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_exconv . "<br>" . $interval;
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
                <h3 class="box-title">DEV. PROVEEDOR (DEVPRO)</h3>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'DEVPRO'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal' AND MOVN_ESTATUS = '1'" . $filtro_estatus;
                //echo $cadena_consulta;
                $consulta_devctr = oci_parse($conexion_central, $cadena_consulta);
                oci_execute($consulta_devctr);
                while ($row_devctr = oci_fetch_row($consulta_devctr)) {
                  if ($row_devctr[3] != '4') {
                    $status = 'Capturado (Sin Contabilizar)';
                  } elseif ($row_devctr[3] == '4') {
                    $status = 'Afectado (Contabilizado)';
                  }
                ?>
                  <a href="#" data-id="<?php echo $row_devctr[1] ?>" data-mov="DEVPRO" data-suc="<?php echo $row_devctr[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_devctr[1] . ' - ' . $status . ' ' . $row_devctr[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_devctr[4]);
                  $now = new DateTime();
                }
                $cantidad_devctr = oci_num_rows($consulta_devctr);
                if ($cantidad_devctr == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_devctr . "<br>" . $interval;
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
                <h3 class="box-title">DEV. MVA. PROVEEDOR (DMPROV)</h3>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'DMPROV'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal' AND MOVN_ESTATUS = '1'" . $filtro_estatus;
                //echo $cadena_consulta;
                $consulta_devctr = oci_parse($conexion_central, $cadena_consulta);
                oci_execute($consulta_devctr);
                while ($row_devctr = oci_fetch_row($consulta_devctr)) {
                  if ($row_devctr[3] != '4') {
                    $status = 'Capturado (Sin Contabilizar)';
                  } elseif ($row_devctr[3] == '4') {
                    $status = 'Afectado (Contabilizado)';
                  }
                ?>
                  <a href="#" data-id="<?php echo $row_devctr[1] ?>" data-mov="DMPROV" data-suc="<?php echo $row_devctr[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_devctr[1] . ' - ' . $status . ' ' . $row_devctr[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_devctr[4]);
                  $now = new DateTime();
                }
                $cantidad_devctr = oci_num_rows($consulta_devctr);
                if ($cantidad_devctr == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_devctr . "<br>" . $interval;
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
                <h3 class="box-title">DEV. CENTRALIZADA (DEVCTR)</h3>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'DEVCTR'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal' AND MOVN_ESTATUS = '1'" . $filtro_estatus;
                //echo $cadena_consulta;
                $consulta_devctr = oci_parse($conexion_central, $cadena_consulta);
                oci_execute($consulta_devctr);
                while ($row_devctr = oci_fetch_row($consulta_devctr)) {
                  if ($row_devctr[3] != '4') {
                    $status = 'Capturado (Sin Contabilizar)';
                  } elseif ($row_devctr[3] == '4') {
                    $status = 'Afectado (Contabilizado)';
                  }
                ?>
                  <a href="#" data-id="<?php echo $row_devctr[1] ?>" data-mov="DEVCTR" data-suc="<?php echo $row_devctr[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_devctr[1] . ' - ' . $status . ' ' . $row_devctr[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_devctr[4]);
                  $now = new DateTime();
                }
                $cantidad_devctr = oci_num_rows($consulta_devctr);
                if ($cantidad_devctr == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_devctr . "<br>" . $interval;
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
                <h3 class="box-title">DEV. CORRECCIÓN (DEVCO)</h3>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php
                $cadena_consulta = "SELECT ALMN_ALMACEN, MODN_FOLIO, TO_CHAR(MOVD_FECHAELABORACION,'DD/MM/YYYY'), MOVN_ESTATUS, TO_CHAR(MOVD_FECHAELABORACION,'YYYY-MM-DD')
                                        FROM INV_MOVIMIENTOS
                                        WHERE MODC_TIPOMOV = 'DEVCO'
                                        AND MOVD_FECHAELABORACION >= TRUNC(TO_DATE('$fecha_inicio','YYYY-MM-DD'))
                                        AND MOVD_FECHAELABORACION <= TRUNC(TO_DATE('$fecha_fin', 'YYYY-MM-DD'))
                                        AND ALMN_ALMACEN = '$sucursal' AND MOVN_ESTATUS = '1'" . $filtro_estatus;
                //echo $cadena_consulta;
                $consulta_devctr = oci_parse($conexion_central, $cadena_consulta);
                oci_execute($consulta_devctr);
                while ($row_devctr = oci_fetch_row($consulta_devctr)) {
                  if ($row_devctr[3] != '4') {
                    $status = 'Capturado (Sin Contabilizar)';
                  } elseif ($row_devctr[3] == '4') {
                    $status = 'Afectado (Contabilizado)';
                  }
                ?>
                  <a href="#" data-id="<?php echo $row_devctr[1] ?>" data-mov="DEVCO" data-suc="<?php echo $row_devctr[0] ?>" data-toggle="modal" data-target="#modal-default"><?php echo $row_devctr[1] . ' - ' . $status . ' ' . $row_devctr[2]; ?></a><br>
                <?php
                  $fecha_ultimoMov = new DateTime($row_devctr[4]);
                  $now = new DateTime();
                }
                $cantidad_devctr = oci_num_rows($consulta_devctr);
                if ($cantidad_devctr == 0) {
                  echo "<p style='color:#FF0000';>No existen registros</p>";
                } else {
                  $interval = $fecha_ultimoMov->diff($now)->format("%d días de retraso");
                  echo "Total.- " . $cantidad_devctr . "<br>" . $interval;
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
        var suc = $(e.relatedTarget).data().suc;
        //alert(id);
        var url = "tabla.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: {
            ide: id,
            movi: mov,
            suc: suc
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