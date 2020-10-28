<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_agenda = $_POST['id_agenda'];

	$cadena = mysqli_query($conexion,"SELECT agenda_promotores.id,agenda_promotores.id_promotor,CONCAT(promotores.nombre,' ',promotores.ap_paterno),promotores.compañia,
										 agenda_promotores.hora_inicio,agenda_promotores.hora_fin
									FROM agenda_promotores
									INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
									WHERE agenda_promotores.id = '$id_agenda'");
	$row = mysqli_fetch_array($cadena);

	$verificar= mysqli_query($conexion,"SELECT id FROM registro_entrada WHERE id_promotor = '$row[1]' AND fecha = '$fecha'");
	$existe = mysqli_num_rows($verificar);
	if($existe == 0){
		$registro_entrada = mysqli_query($conexion,"INSERT INTO registro_entrada (id_promotor,hora_entrada,fecha,hora,activo,id_usuario)
		VALUES('$row[1]','$hora','$fecha','$hora','1','$id_usuario')");
	}

	$array = array($row[0], //id_agenda
					$row[1], //id_promotor	
					$row[2], //nombre_promotor	
					$row[3], //compañia
					$row[4],  //hora_inicio
					$row[5]  //hora_fin
				);
	echo json_encode($array);
?>