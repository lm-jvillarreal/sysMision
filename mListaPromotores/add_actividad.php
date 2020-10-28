<?php
	include '../global_seguridad/verificar_sesion.php';

	$actividad   = $_POST['actividad'];
	$id_promotor = $_POST['id_promotor'];

	$cadena = mysqli_query($conexion,"INSERT INTO actividades_promotor (actividad, id_promotor, fecha, hora, id_usuario, activo, principal,temporal) VALUES ('$actividad', '$id_promotor','$fecha','$hora','$id_usuario','1','0','1')");
	echo "ok";

?>