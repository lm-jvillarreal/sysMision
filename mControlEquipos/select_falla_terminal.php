<?php
	include '../global_settings/conexion.php';
	   
	if(!isset($_POST['searchTerm'])){ 
		$cadena = "SELECT
		fe.id,
		fe.nombre,
		fe.equipo,
		te.id_tipo,
		te.nombre 
	FROM
		fallas_equipos fe
		INNER JOIN tipos_equipos te ON fe.equipo = te.id_tipo 
	WHERE
		fe.activo = '1' 
		AND fe.equipo = '1' 
		OR fe.equipo = '0'";
	}else{ 
		$search = $_POST['searchTerm'];   
		$cadena = "SELECT
		fe.id,
		fe.nombre,
		fe.equipo,
		te.id_tipo,
		te.nombre 
	FROM
		fallas_equipos fe
		INNER JOIN tipos_equipos te ON fe.equipo = te.id_tipo 
	WHERE
		fe.activo = '1' 
		AND fe.equipo = '1' 
		OR fe.equipo = '0' AND fe.nombre LIKE '%$search%'";
	}
	$consulta = mysqli_query($conexion, $cadena);
	$data = array();
	while ($row = mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]);
	}
	echo json_encode($data);
?>
