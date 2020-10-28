<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_encuesta   = $_POST['id_encuesta'];
	$id_trabajador = $_POST['id_trabajador'];
	$sucursal      = $_POST['sucursal'];
	$departamento  = $_POST['departamento'];

	$cadena2 = mysqli_query($conexion,"INSERT INTO n_invitados (codigo_trabajador, id_encuesta, sucursal, departamento, fecha, hora, id_usuario, activo) VALUES ('$id_trabajador','$id_encuesta','$sucursal','$departamento','$fecha','$hora','$id_usuario','1')");
	echo "ok";
?>
