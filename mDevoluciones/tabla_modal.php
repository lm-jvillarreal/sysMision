<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$datos=array();
$sucursal=$_POST['sucursal'];
$foliomov=$_POST['foliomov'];
$tipomov=$_POST['tipomov'];
$cadenaDetalle = "SELECT
                  ARTC_ARTICULO,
                  (SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO=INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO) ARTC_DESCRIPCION,
                  RMON_CANTSURTIDA,
                  RMON_COSTO_PROMEDIO_ALM,
                  RMOC_UNIMEDIDA
                  FROM
                  INV_RENGLONES_MOVIMIENTOS 
                  WHERE
                  ALMN_ALMACEN = '$sucursal' 
                  AND MODC_TIPOMOV = '$tipomov' 
                  AND MODN_FOLIO = '$foliomov'";
$parametros_consulta = oci_parse($conexion_central, $cadenaDetalle);
oci_execute($parametros_consulta);
while ($rowDetalle=oci_fetch_row($parametros_consulta)) {
	array_push($datos,array(
		'artc_articulo'=>$rowDetalle[0],
    'artc_descripcion'=>$rowDetalle[1],
    'cant_surtida'=>$rowDetalle[2],
    'costo_promedio'=>$rowDetalle[3],
    'unidad_medida'=>$rowDetalle[4]
	));
}
echo utf8_encode(json_encode($datos));
?>