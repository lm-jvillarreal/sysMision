<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	//include '../configuracion/conexion_servidor.php';
	include '../global_seguridad/verificar_sesion.php';
	$codigo = $_POST['codigo'];
	$descripcion = $_POST['descripcion'];

	$select = "SELECT id FROM cajas_articulos WHERE codigo = '$codigo'";
	$exSelect = mysqli_query($conexion, $select);
	$row_cajas = mysqli_fetch_row($exSelect);

	if ($row_cajas != "") {
		echo "false";
	}else{
			$insert = "INSERT INTO cajas_articulos (codigo, descripcion) VALUES ('$codigo', '$descripcion')";
		$exInsert = mysqli_query($conexion, $insert);

		$sql = "SELECT MAX(id) FROM cajas_articulos";
		$exSql = mysqli_query($conexion, $sql);
		$row = mysqli_fetch_row($exSql);
		echo "$row[0]";
	}

	
	

 ?>