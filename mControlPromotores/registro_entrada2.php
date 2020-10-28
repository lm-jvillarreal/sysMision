<?php
	include '../global_settings/conexion.php';

	$fecha_inicio=$_POST['fecha_inicio'];
	$fecha_fin=$_POST['fecha_fin'];

	$cadena1 = mysqli_query($conexion,"SELECT
	promotores.id,
	IFNULL(SEC_TO_TIME(AVG((TIME_TO_SEC(hora_salida))- (TIME_TO_SEC(hora_entrada)))),'00:00:00')
FROM
	registro_entrada
	INNER JOIN promotores on promotores.id = registro_entrada.id_promotor
	WHERE promotores.activo = '1' AND registro_entrada.id_sucursal = '1'
	AND (registro_entrada.fecha>='$fecha_inicio' AND registro_entrada.fecha<='$fecha_fin')
GROUP BY id_promotor");
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