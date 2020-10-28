<?php
	include '../global_seguridad/verificar_sesion.php';

	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT tipo_bodega.nombre, detalle_tbodega_usuarios.tipo
	FROM tipo_bodega 
	INNER JOIN detalle_tbodega_usuarios ON detalle_tbodega_usuarios.id_bodega = tipo_bodega.id
	WHERE tipo_bodega.id = '$id'");
	$row = mysqli_fetch_array($cadena);
	$array = array($row[0],$row[1]);
	echo json_encode($array);