<?php
	include '../global_settings/conexion.php';
	   
	if(!isset($_POST['searchTerm'])){ 
		$cadena = "SELECT id_tipo, nombre FROM tipos_equipos WHERE activo = '1'";
	}else{ 
		$search = $_POST['searchTerm'];   
		$cadena = "SELECT id_tipo,nombre FROM tipos_equipos WHERE activo = '1' AND nombre LIKE '%$search%'";
	}
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row = mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]);
	}
	echo json_encode($data);
?>
