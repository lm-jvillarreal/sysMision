<?php
include '../global_settings/conexion_oracle.php';
$fechaInicio=$_POST['fecha_inicio'];
$fechaFin=$_POST['fecha_fin'];
$artc_articulo=$_POST['artc_articulo'];
$almn_almacen=$_POST['ticc_sucursal'];
$cadenaConsulta="SELECT
                NVL(sum(ARTN_CANTIDAD),0)
                FROM
                PV_VENTAS_REPORTE_VW 
                WHERE
                TICC_SUCURSAL = '$almn_almacen' 
                AND ( TICN_AAAAMMDDVENTA BETWEEN '$fechaInicio' AND '$fechaFin' ) 
                AND ARTC_ARTICULO = '$artc_articulo' 
                AND (
                TICN_TIPOMOV = '1' 
                OR TICN_TIPOMOV = '9')";

$consulta_ventas=oci_parse($conexion_central, $cadenaConsulta);
oci_execute($consulta_ventas);
$rowVentas=oci_fetch_array($consulta_ventas);
$datos[]=["ventas"=>$rowVentas[0]];
echo utf8_encode(json_encode($datos));

?>