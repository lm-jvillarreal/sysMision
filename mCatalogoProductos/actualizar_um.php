<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$um = $_POST['folio'];
$id_registro = $_POST['id_registro'];

$cadenaCosto = "SELECT costo_um, impuesto, artc_articulo FROM cp_productos where id = '$id_registro'";
$consultaCosto = mysqli_query($conexion, $cadenaCosto);
$rowCosto = mysqli_fetch_array($consultaCosto);

$cadenaUC = "SELECT * FROM (SELECT
                detalle.rmon_ultimoprecio
              FROM
              INV_RENGLONES_MOVIMIENTOS detalle
              INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
              AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
              AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
              WHERE
              ARTC_ARTICULO = '$rowCosto[2]'
              AND movs.MOVD_FECHAAFECTACION IS NOT NULL
              AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC' OR detalle.MODC_TIPOMOV = 'ETRANS')
              ORDER BY
              movs.MOVD_FECHAAFECTACION DESC),
              (SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO = '$rowCosto[2]')
              WHERE ROWNUM <=1";
  
$st = oci_parse($conexion_central, $cadenaUC);
oci_execute($st);
$rowUC = oci_fetch_row($st);

$uc = $rowUC[0];
$uc = round($uc,2);
$impuesto = 0.00;
$costo_unitario = $uc/$um;
$costo_unitario = round($costo_unitario,2);
$costo_total = $costo_unitario + $impuesto;
$costo_total = round($costo_total,2);

$cadenaUpdate = "UPDATE cp_productos SET um = '$um', costo_um = '$uc', costo_unitario = '$costo_unitario', impuesto = '$impuesto', costo_total = '$costo_total', artc_descripcion = '$rowUC[1]' WHERE id = '$id_registro'";
$actualizar = mysqli_query($conexion, $cadenaUpdate);
echo "ok";
?>