<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_horario = $_POST['id_horario'];
	// echo "UPDATE agenda_promotores SET activo = '0' WHERE id = '$id_horario'";
	$cadena = mysqli_query($conexion,"UPDATE agenda_promotores SET activo = '0' WHERE id = '$id_horario'");
	echo "ok";
?>