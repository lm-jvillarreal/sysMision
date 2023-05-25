<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];	
	$cadena = mysqli_query($conexion,"SELECT fe.nombre, fe.equipo, te.nombre  FROM fallas_equipos fe, tipos_equipos te WHERE te.id_tipo=fe.equipo and fe.id = '$id'");
	$row = mysqli_fetch_array($cadena);
	$array = array(
		$row[0],
		$row[1],
		$row[2]);
	$array1 = json_encode($array);
	echo $array1;	
?>