<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];

	$cadena = mysqli_query($conexion,"SELECT MIN(fecha_vacaciones),MAX(fecha_vacaciones),comentarios FROM historico_vacaciones WHERE folio = '$folio' AND activo ='1'");
	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1],$row[2]);

	echo json_encode($array);
?>