<?php
	include '../global_seguridad/verificar_sesion.php';
	date_default_timezone_set('America/Monterrey');
	$fecha=date("Y-m-d"); 
	$hora=date ("h:i:s");

	$id_marca = $_POST['id'];
	
	$cadena = "SELECT
	id,
	marca,
	id_equipo, ( SELECT nombre FROM tipos_equipos WHERE tipos_equipos.id_tipo = marcas.id_equipo ) 
FROM
	marcas 
WHERE
	id = '$id_marca'";
	$inserta = mysqli_query($conexion,$cadena);

	$row = mysqli_fetch_array($inserta);

	$array = array(
		$row[0],//id_registro
		$row[1],//marca
		$row[2],//id_equipo
		$row[3]//nombre equipo
	);
	$array1 = json_encode($array);
	
	echo $array1;
	
?>