<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$id_modelo = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT id_marca, (SELECT marca FROM marcas WHERE marcas.id = modelos.id_marca),modelo,tipo,CASE tipo
	WHEN '1' THEN
	  'PINPAD'
	WHEN '2' THEN
	  'DUAL-UP'
	WHEN '3' THEN
	  'GRPS'
	ELSE
	  'Ninguno'
	END AS tipo FROM modelos WHERE id = '$id_modelo'");

	$row = mysqli_fetch_array($cadena);

	$array = array($row[0],$row[1],$row[2],$row[3],$row[4]);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>