<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT id_persona,
						CONCAT(
							personas.nombre,
							' ',
							personas.ap_paterno,
							' ',
							personas.ap_materno
						),
						actividad,
						fecha_realizacion
				FROM actividades_usuario
				INNER JOIN personas on personas.id = actividades_usuario.id_persona
				WHERE actividades_usuario.id = '$id'");
	$row = mysqli_fetch_array($cadena);

	$array = array( $row[0], //id_persona
					$row[1], //nombre
					$row[2], //actividad
					$row[3], //fecha
				);
	echo json_encode($array);
?>