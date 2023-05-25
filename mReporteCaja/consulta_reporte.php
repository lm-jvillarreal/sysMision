<?php
	include '../global_settings/conexion.php';

    $cant_reporte = "SELECT id_caja FROM reportes_cajas WHERE id_caja = id_caja AND activo = '1' GROUP BY id_caja";
    $consulta_reporte = mysqli_query($conexion, $cant_reporte);
	$data = array();

	while ($row=mysqli_fetch_array($consulta_reporte)) {
	 $data[] = array($row[0]); 
	}

	echo json_encode($data);
?>
