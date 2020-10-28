<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_agenda = $_POST['id_agenda']; 
	$row2 = "";

	$cadena = mysqli_query($conexion,"SELECT agenda_promotores.id,agenda_promotores.id_promotor,CONCAT(promotores.nombre,' ',promotores.ap_paterno),promotores.compañia,
										 agenda_promotores.hora_inicio,agenda_promotores.hora_fin
									FROM agenda_promotores
									INNER JOIN promotores ON promotores.id = agenda_promotores.id_promotor
									WHERE agenda_promotores.id = '$id_agenda'");
	$row = mysqli_fetch_array($cadena);

	$verificar= mysqli_query($conexion,"SELECT id FROM registro_entrada WHERE id_promotor = '$row[1]' AND fecha = '$fecha' AND id_sucursal = '$id_sede'");
	$existe = mysqli_num_rows($verificar);
	if($existe == 0){
		$registro_entrada = mysqli_query($conexion,"INSERT INTO registro_entrada (id_promotor,hora_entrada,fecha,hora,activo,id_usuario,id_sucursal)
		VALUES('$row[1]','$hora','$fecha','$hora','1','$id_usuario','$id_sede')");
	}
	$cadena = mysqli_query($conexion,"SELECT
	registro_entrada.hora_entrada, SEC_TO_TIME(((TIME_TO_SEC(registro_entrada.hora_entrada))+(TIME_TO_SEC(agenda_promotores.hora_fin)- TIME_TO_SEC(agenda_promotores.hora_inicio)))) AS Salida
FROM registro_entrada 
INNER JOIN agenda_promotores ON agenda_promotores.id_promotor = registro_entrada.id_promotor
WHERE registro_entrada.id_promotor = '$row[1]' AND agenda_promotores.dia = registro_entrada.fecha AND agenda_promotores.id_sucursal = registro_entrada.id_sucursal AND (registro_entrada.fecha = '$fecha' AND agenda_promotores.dia = '$fecha') AND registro_entrada.id_sucursal = '$id_sede' AND agenda_promotores.activo = '1'");
		$row2 = mysqli_fetch_array($cadena);
	

	$array = array($row[0], //id_agenda
					$row[1], //id_promotor	
					$row[2], //nombre_promotor	
					$row[3], //compañia
					$row2[0],  //hora_inicio
					$row2[1]  //hora_fin
				);
	echo json_encode($array);
?>