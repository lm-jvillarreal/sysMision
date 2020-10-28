<?php
  	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];

	$cadena = mysqli_query($conexion,"SELECT nombre,id_subdepartamento,
											(SELECT nombre FROM sub_departamentos WHERE sub_departamentos.id = detalle_checklist.id_subdepartamento) 
											FROM detalle_checklist WHERE id = '$id'");
	$row = mysqli_fetch_array($cadena);

	$array = array( $row[0],
					$row[1],
					$row[2]);

	echo json_encode($array);
?>