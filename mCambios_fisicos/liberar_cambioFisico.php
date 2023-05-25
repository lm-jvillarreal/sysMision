<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
$id_cambio = $_POST['id_cambio'];
$cantidad = $_POST['cantidad'];

if (!empty($cantidad)) {

	$cadena_conteo = "SELECT cantidad FROM cambios WHERE id = '$id_cambio'";
	$consulta_conteo = mysqli_query($conexion, $cadena_conteo);
	$row_conteo = mysqli_fetch_array($consulta_conteo);

	if ($cantidad<$row_conteo[0]) {
		$cantidad=$row_conteo[0]-$cantidad;
		$cadena_descontar = "UPDATE cambios SET cantidad = '$cantidad' WHERE id = '$id_cambio'";
		$consulta_descontar = mysqli_query($conexion, $cadena_descontar);
		echo "descuento";
	}elseif ($cantidad==$row_conteo[0]) {
		$cadena_liberar = "UPDATE cambios SET estatus='1', fecha_liberacion = '$fecha', hora_liberacion = '$hora' WHERE id = '$id_cambio'";
		$consulta_liberar = mysqli_query($conexion, $cadena_liberar);

		echo "ok";
	}elseif($cantidad>$row_conteo[0]){
		echo "overflow";
	}
}
?>