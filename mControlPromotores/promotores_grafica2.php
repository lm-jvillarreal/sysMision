<?php
	include '../global_settings/conexion.php';

	$cadena = mysqli_query($conexion,"SELECT id, CONCAT(nombre,'-',compañia) FROM promotores WHERE promotores.activo = '1' ORDER BY id");
	$promotores = "";
	while ($row = mysqli_fetch_array($cadena)) {
		$promotores .= "'".$row[1]."'," ;
	}
	$cuerpo2 = trim($promotores,','); ///Quitarle la coma
	echo $cuerpo2;
?>