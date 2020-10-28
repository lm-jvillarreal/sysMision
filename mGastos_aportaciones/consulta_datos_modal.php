<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];
$cadena_folio = "SELECT id, fecha_pago, tipo_pago, no_comprobante, comentarios FROM gastos_aportaciones WHERE id = '$id'";
$consulta_folio = mysqli_query($conexion, $cadena_folio);

$row_folio = mysqli_fetch_array($consulta_folio);

$array = array(
	$row_folio[0],
	$row_folio[1],
	$row_folio[2],
	$row_folio[3],
	$row_folio[4]
	);

$array_folio = json_encode($array);
echo "$array_folio";
?>