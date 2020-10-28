<?php
	include '../global_settings/conexion.php';

	$cadena1 = mysqli_query($conexion,"SELECT promotores.id,SEC_TO_TIME((TIME_TO_SEC(hora_fin) - TIME_TO_SEC(hora_inicio)))
	FROM agenda_promotores
	INNER JOIN promotores on promotores.id = agenda_promotores.id_promotor
	WHERE promotores.activo = '1' AND agenda_promotores.id_sucursal = '1'
	GROUP BY id_promotor ORDER BY id_promotor");
	$horario = "";
	$hora = "";
	while ($row1 = mysqli_fetch_array($cadena1)) {
		$hora = str_replace(":", ".", $row1[1]);
		$hora = substr($hora, 1,4);
		$horario .= $hora.',';
	}
	$cuerpo = trim($horario,','); ///Quitarle la coma
	echo $cuerpo;
?>