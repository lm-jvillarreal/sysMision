<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_actividad = $_POST['i'];

	$cadena1 = mysqli_query($conexion,"SELECT id,actividad FROM actividades_promotor  WHERE id = '$id_actividad' AND principal != '1'");
	$cant   = mysqli_num_rows($cadena1);
	$row    = mysqli_fetch_array($cadena1);
	
	$array  = array($row[0],$row[1]);
	$array1 = json_encode($array);
	
	echo $array1;
?>