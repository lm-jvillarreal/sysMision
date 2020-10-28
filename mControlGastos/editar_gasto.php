<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_gasto = $_POST['id_gasto'];

	$cadena = mysqli_query($conexion,"SELECT concepto, monto,id_detalle_gasto,( SELECT nombre_emisor FROM detalle_control_gastos 
	WHERE detalle_control_gastos.id = gastos.id_detalle_gasto ),id_rublo,(SELECT nombre FROM rublos WHERE rublos.id = gastos.id_rublo ),id_rancho,ranchos.nombre_rancho,CASE municipio WHEN '1' THEN 'Linares' WHEN '2' THEN 'Gral. Teran' ELSE 'Villagran' END AS municipio
FROM gastos INNER JOIN ranchos ON ranchos.id = gastos.id_rancho WHERE gastos.id = '$id_gasto'");
	$row = mysqli_fetch_array($cadena);
	$array = array($row[0], // Concepto
					$row[1],	// monto
					$row[2],	// id_detalle
					$row[3],	// nombre_emisor
					$row[4],	// id_rublo
					$row[5],	// rublo
					$row[6],	// id_rancho
					$row[7],	// rancho
					$row[8],	// municipio
				);
	echo json_encode($array);
?>