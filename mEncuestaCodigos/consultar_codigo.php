<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$codigo_producto = $_POST['codigo'];

$cadena_consulta = "SELECT ARTC_DESCRIPCION FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$codigo_producto'";
$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);
$row_producto = oci_fetch_row($st);

$array = array(
	$row_producto[0]
	);

$array_datos = json_encode($array);
echo "$array_datos"; 
?>