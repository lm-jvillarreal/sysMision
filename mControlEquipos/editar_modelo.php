<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$id_modelo = $_POST['id'];
	
	$cadena = mysqli_query($conexion,"SELECT
	modelos.id,
	marcas.marca,
	modelos.modelo,
	modelos.tipo,
CASE
		tipo 
		WHEN '1' THEN
		'PINPAD' 
		WHEN '2' THEN
		'DUAL-UP' 
		WHEN '3' THEN
		'GRPS' ELSE 'Ninguno' 
	END AS tipo 
FROM
	modelos,
	marcas 
WHERE
	modelos.id = '$id_modelo' 
	AND modelos.id_marca = marcas.id");

	$row = mysqli_fetch_array($cadena);

	$array = array(
		$row[0],//id_modelo
		$row[1],//marca
		$row[2],//modelo
		$row[3],//tipo
		$row[4]);//nombre_tipo
	$array1 = json_encode($array);
	
	echo $array1;
	
?>