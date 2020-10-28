<?php
include '../global_seguridad/verificar_sesion.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$fecha_format = $newDate = date("d/m/Y", strtotime($fecha));

$cadena_folio = "SELECT MAX(a.id), (SELECT folio_movimiento from aportaciones where id=MAX(a.id))
					FROM aportaciones as a
					WHERE a.tipo_movimiento = 'MANUAL'";
$consulta_folio = mysqli_query($conexion, $cadena_folio);

$row_folio = mysqli_fetch_array($consulta_folio);

$folio = $row_folio[1]+1;

$array = array(
	$folio,
	$fecha_format
	);

$array_folio = json_encode($array);
echo "$array_folio";
?>