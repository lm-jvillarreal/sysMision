<?php
include '../global_settings/conexion_oracle.php';
$fecha_i='20200625';
$fecha_fin="20200626";
$artc_articulo="7501027209542";
function dev_venta($cadena_conexion,$almn_almacen,$artc_articulo,$fecha_a, $fecha_b){
  $qry_devolucion_venta = "SELECT NVL(SUM(DETALLE.ARTN_CANTIDAD),'0')
                            FROM
                                PV_ARTICULOSTICKET detalle
                            INNER JOIN PV_TICKETS tik ON CONCAT(TIK.TICN_AAAAMMDDVENTA,TIK.TICN_FOLIO) = CONCAT(DETALLE.TICN_AAAAMMDDVENTA,DETALLE.TICN_FOLIO)
                            AND tik.TICC_SUCURSAL=detalle.ticc_sucursal
                            WHERE
                                DETALLE.ARTC_ARTICULO = '$artc_articulo'
                            AND TIK.ticn_aaaammddventa BETWEEN '$fecha_a'
                            AND '$fecha_b'
                            AND (
                                TIK.TICN_ESTATUS = 2
                                OR TIK.TICN_ESTATUS = 3
                            )
                            AND tik.TICC_SUCURSAL = '$almn_almacen'
                            AND DETALLE.TICC_SUCURSAL = '$almn_almacen'
                            AND tik.ticn_tipomov='-1'";
  $st_dev_venta = oci_parse($cadena_conexion, $qry_devolucion_venta);
  oci_execute($st_dev_venta);
  $row_dev_venta = oci_fetch_row($st_dev_venta);

  $devolucion_venta=$row_dev_venta[0];
  return $devolucion_venta;
}
$dev_do=dev_venta($conexion_central,'1',$artc_articulo,$fecha_i,$fecha_fin);
$dev_arb=dev_venta($conexion_central,'2',$artc_articulo,$fecha_i,$fecha_fin);
$dev_vill=dev_venta($conexion_central,'3',$artc_articulo,$fecha_i,$fecha_fin);
$dev_all=dev_venta($conexion_central,'4',$artc_articulo,$fecha_i,$fecha_fin);
$dev_pet=dev_venta($conexion_central,'5',$artc_articulo,$fecha_i,$fecha_fin);

echo $dev_do;
echo $dev_arb;
?>