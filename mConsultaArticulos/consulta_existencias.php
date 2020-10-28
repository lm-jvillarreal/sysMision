<?php
	include '../global_settings/conexion_oracle.php';
	$codigo = $_POST['codigo'];
	date_default_timezone_set('America/Monterrey');
	$fecha = date('Y-m-d');	
	$qry_nombre = "SELECT
	spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 1, '$codigo'), 
	spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 2, '$codigo'), 
	spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 3, '$codigo'), 
	spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 4, '$codigo'),
	spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 5, '$codigo'),
	spin_articulos.fn_existencia_disponible_todos (13, NULL, NULL, 1, 1, 99, '$codigo')
FROM
	dual";
	$st_nombre = oci_parse($conexion_central, $qry_nombre);
	oci_execute($st_nombre);
	$row_nombre = oci_fetch_row($st_nombre);
	$array_datos  = array($row_nombre[0], $row_nombre[1], $row_nombre[2], $row_nombre[3], $row_nombre[4], $row_nombre[5]);
	$array_json = json_encode($array_datos);
	echo "$array_json";
 ?>