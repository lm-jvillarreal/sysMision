<?php
	include '../global_seguridad/verificar_sesion.php';
	
	$examen  = $_POST['examen'];
	$persona = $_POST['persona'];

	$cadena = mysqli_query($conexion,"INSERT INTO examenes_asignados (id_examen, empleado, estatus, fecha, hora, activo, id_usuario) VALUES ('$examen','$persona', '1','$fecha','$hora','1','$id_usuario')");

	echo "ok";
?>