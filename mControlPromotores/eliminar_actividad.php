<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_actividad = $_POST['id_actividad'];
	$cadena = mysqli_query($conexion,"UPDATE actividades_promotor SET activo = '0' WHERE id = '$id_actividad'");
	echo "ok";
?>