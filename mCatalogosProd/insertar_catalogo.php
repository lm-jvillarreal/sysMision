<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$nombre_catalogo = $_POST['nombre_catalogo'];
$cantidad_codigos = $_POST['cantidad_codigos'];
$codigo = $_POST['cantidad'];
$descripcion = $_POST['descripcion'];

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$cadena_noCat = "SELECT MAX(no_catalogo) FROM cp_catalogos";
$consulta_noCat = mysqli_query($conexion, $cadena_noCat);
$row_noCat = mysqli_fetch_array($consulta_noCat);
$noCat = $row_noCat[0] + 1;

for ($i=0; $i < $cantidad_codigos ; $i++) {
	$cadena_articulo = "SELECT ARTC_DESCRIPCION, ARTC_FAMILIA FROM PV_ARTICULOS WHERE ARTC_ARTICULO = '$codigo[$i]'";
	$consulta_articulo = oci_parse($conexion_central, $cadena_articulo);
	oci_execute($consulta_articulo);
	$row_articulo=oci_fetch_row($consulta_articulo);

	$cadena_insertar = "INSERT INTO cp_catalogos (no_catalogo, nombre_catalogo, cve_producto, desc_producto, familia_producto, sucursal, fecha, hora, activo, usuario)VALUES('$noCat','$nombre_catalogo', '$codigo[$i]', '$descripcion[$i]', '$row_articulo[1]', '$id_sede', '$fecha', '$hora', '1', '$id_usuario')";
	$insertar_catalogo = mysqli_query($conexion, $cadena_insertar);

	//echo $cadena_insertar;
}
echo "ok";
?>