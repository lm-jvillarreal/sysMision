<?php
include '../global_settings/conexion_oracle.php';
include '../global_seguridad/verificar_sesion.php';
$almacen=$_POST['almacen'];
$tipomov=$_POST['tipomov'];
$foliomov=$_POST['foliomov'];
$datos=array();

$cadenaEntrada="SELECT
                  ARTC_ARTICULO,
                  (SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO=R.ARTC_ARTICULO) ARTC_DESCRIPCION,
                  RMOC_UNIMEDIDA,
                  RMON_CANTSURTIDA,
                  TO_CHAR(RMON_ULTIMOPRECIO,'$999,999.00') CU,
                  TO_CHAR(RMON_COSTO_RENGLON_MB ,'$999,999.00') CR
                FROM
                  INV_RENGLONES_MOVIMIENTOS R
                WHERE
                  ALMN_ALMACEN='$almacen'
                  AND MODC_TIPOMOV='$tipomov'
                  AND MODN_FOLIO='$foliomov'";
$consultaEntrada = oci_parse($conexion_central, $cadenaEntrada);
oci_execute($consultaEntrada);
while($row = oci_fetch_row($consultaEntrada)){
  array_push($datos,array(
    'artc_articulo'=>$row[0],
    'artc_descripcion'=>$row[1],
    'um'=>$row[2],
    'cantidad'=>$row[3],
    'cu'=>$row[4],
    'total'=>$row[5]
  ));
}
echo utf8_encode(json_encode($datos));
?>