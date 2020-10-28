<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_settings/conexion_supsys.php';
	$id_caja = $_POST['id_caja'];
	$fecha_i=str_replace("-","",$fecha_inicial);
	$fecha_fin=str_replace("-","",$fecha_final);
	ini_set('max_execution_time', 1000); 
	$sql =  "SELECT
					id,
					codigo,
					descripcion 
				FROM
					cajas_articulos
				WHERE id = '$id_caja'";
	$exSql = mysqli_query($conexion, $sql);
	$row = mysqli_fetch_row($exSql);
		$array_datos = array($row[0], $row[1], $row[2]);
		$array_encode = json_encode($array_datos);
	echo "$array_encode";
 ?>