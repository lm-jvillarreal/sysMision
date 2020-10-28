<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$codigo_prod = $_POST['codigo_prod'];
$desc_prod = $_POST['desc_prod'];
$catalogo = $_POST['catalogo'];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$cadena_articulo = "SELECT ARTC_DESCRIPCION, ARTC_FAMILIA FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$codigo_prod'";
$consulta_articulo = oci_parse($conexion_central, $cadena_articulo);
oci_execute($consulta_articulo);
$row_articulo=oci_fetch_row($consulta_articulo);

$cadena_validar = "SELECT * FROM cp_catalogos WHERE cve_producto = '$codigo_prod'";
$consulta_validar = mysqli_query($conexion, $cadena_validar);
$row_validar = mysqli_fetch_array($conexion, $cadena_validar);
$conteo_validar = mysqli_num_rows($consulta_validar);

if ($conteo_validar>0) {
	echo "repetido";
}else{
	$cadena_consulta = "SELECT nombre_catalogo  FROM cp_catalogos WHERE id = '$catalogo'";
	$consulta_catalogo = mysqli_query($conexion, $cadena_consulta);
	$row_catalogo = mysqli_fetch_array($consulta_catalogo);

	$cadena_insertar = "INSERT INTO cp_catalogos(no_catalogo, nombre_catalogo, cve_producto, desc_producto, familia_producto, sucursal, fecha, hora, activo, usuario)VALUES('$catalogo', '$row_catalogo[0]', '$codigo_prod', '$desc_prod', '$row_articulo[1]', '$id_sede', '$fecha', '$hora', '1', '$id_usuario')";

	$inserta_codigo = mysqli_query($conexion, $cadena_insertar);
	echo "ok";
}
?>