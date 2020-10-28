<?php
include '../global_seguridad/verificar_sesion.php';

$id     = $_POST['id_promotor_vacaciones'];
$cadena = mysqli_query($conexion,"SELECT CONCAT(nombre,' ', ap_paterno, ' - ', compañia) FROM promotores WHERE id = '$id'");
$row    = mysqli_fetch_array($cadena);

$array2 = array(
	$row[0] //datos_caja
	);

$array = json_encode($array2);
echo "$array";
?>