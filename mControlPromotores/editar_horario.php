<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_horario = $_POST['id_horario'];

	$cadena = mysqli_query($conexion,"SELECT id,id_sucursal,(SELECT nombre FROM sucursales WHERE sucursales.id = agenda_promotores.id_sucursal),hora_inicio,hora_fin,dia FROM agenda_promotores WHERE id = '$id_horario'");
	$row = mysqli_fetch_array($cadena);

	$array = array( $row[0], //id
					$row[1], //id_sucursal
					$row[2], //nombre_sucursal
					$row[3], //hora_inicio
					$row[4], //hora_fin
					$row[5]); //fecha
	echo json_encode($array);
?>