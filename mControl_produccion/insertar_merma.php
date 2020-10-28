<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$cod_prod = $_POST['cod_prod'];
$cant_merma = $_POST['cant_merma'];
$desc_prod = $_POST['desc_prod'];
$conteo = count($cod_prod);

for ($i=0; $i < $conteo; $i++) { 
	 
	 //Cadena de insercion en tabla de mermas
	$cadena_insertar = "INSERT INTO cp_historial_mermas (cve_producto, desc_producto, cantidad_merma, fecha_merma, hora_merma, sucursal, activo, usuario)VALUES('$cod_prod[$i]', '$desc_prod[$i]', '$cant_merma[$i]', '$fecha', '$hora', '$id_sede', '1', '$id_usuario')";
	$insertar_merma = mysqli_query($conexion, $cadena_insertar);

	$cadena_existencias = "SELECT MAX(id), baja_merma FROM cp_historial_movimientos WHERE cve_producto = '$cod_prod[$i]' ORDER BY id DESC LIMIT 1";
	$consulta_existencias = mysqli_query($conexion, $cadena_existencias);
	$row_existencias = mysqli_fetch_array($consulta_existencias);
	$existencias = $row_existencias[1];

	$merma_actual = $existencias + $cant_merma[$i];

	$cadena_actualizar = "UPDATE cp_historial_movimientos SET baja_merma = '$merma_actual' WHERE id = '$row_existencias[0]'";
	$actualizar_existencia = mysqli_query($conexion, $cadena_actualizar);
}
echo "ok";
?>