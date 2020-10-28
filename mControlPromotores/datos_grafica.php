<?php
	include '../global_settings/conexion.php';

	// $fecha1 = $_POST['fecha1'];
	// $fecha2 = $_POST['fecha2'];

	$fecha1 = '2019-07-26';
	$fecha2 = '2019-07-26';

	$cadena = mysqli_query($conexion,"SELECT id, CONCAT(nombre,'-',compañia) FROM promotores ORDER BY id");
	$promotores = "";
	$numero = 1;
	$cuerpo = "";
	$texto = "$"."id";
	while ($row = mysqli_fetch_array($cadena)) {
		$valor = (int)1;
		$cuerpo .= "{\"$texto\":$numero,\"Cantidad de Horas\":$row[0],\"Promotores\":$valor},";
		$numero ++;
	}
	$cuerpo2 = trim($cuerpo,','); ///Quitarle la coma
	$tabla = "
    ["
    .$cuerpo2.
    "]
    ";
  	echo $tabla;

	// $cadena = mysqli_query($conexion,"SELECT promotores.id,SEC_TO_TIME(AVG((TIME_TO_SEC(hora_salida))- (TIME_TO_SEC(hora_entrada))))
	// FROM registro_entrada
	// INNER JOIN promotores on promotores.id = registro_entrada.id_promotor
	// GROUP BY id_promotor");
	// $horario = "";
	// $hora = "";
	// while ($row = mysqli_fetch_array($cadena)) {
	// 	$hora = str_replace(":", ".", $row[1]);
	// 	$hora = substr($hora, 1,4);
	// 	$horario .= $hora.',';
	// }
	// $cuerpo = trim($horario,','); ///Quitarle la coma
	// echo $cuerpo;


	// $cadena1 = mysqli_query($conexion,"SELECT promotores.id,SEC_TO_TIME((TIME_TO_SEC(hora_fin) - TIME_TO_SEC(hora_inicio)))
	// FROM agenda_promotores
	// INNER JOIN promotores on promotores.id = agenda_promotores.id_promotor
	// GROUP BY id_promotor ORDER BY id_promotor");
	// $horario = "";
	// $hora = "";
	// while ($row1 = mysqli_fetch_array($cadena1)) {
	// 	$hora = str_replace(":", ".", $row1[1]);
	// 	$hora = substr($hora, 1,4);
	// 	$horario .= $hora.',';
	// }
	// $cuerpo = trim($horario,','); ///Quitarle la coma
	// echo $cuerpo;
?>