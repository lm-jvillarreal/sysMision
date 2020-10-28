<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';
	$id_mapeo = $_POST['id_mapeo'];
	$codigo= $_POST['codigo'];
	$cantidad = $_POST["cantidad"];
//consulta infofin
	$sql_o = "SELECT descripcion FROM productos WHERE codigo_producto = '$codigo'";
	$exsql = mysqli_query($conexion, $sql_o);
	$row = mysqli_fetch_row($exsql);

	if ($row[0] == "") {
		echo "false";
	}else{
		$sql = "INSERT INTO inv_detalle_mapeo(id_mapeo, consecutivo_mueble, estante, codigo_producto, fecha, hora, descripcion) VALUES('$id_mapeo', '1', '1', '$codigo', CURRENT_DATE, CURRENT_TIME, '$row[0]')";
		$exSql = mysqli_query($conexion, $sql);
		//echo "$sql";
		$sql_max = "SELECT MAX(id) FROM inv_detalle_mapeo";
		$e = mysqli_query($conexion, $sql_max);
		$r_max = mysqli_fetch_row($e);
		//Agregar datos a tabla de captura
		$sql_captura = "INSERT INTO inv_captura(id_mapeo, id_detalle_mapeo, cod_producto, cantidad, usuario) VALUES('$id_mapeo', '$r_max[0]', '$codigo', '$cantidad', '1')";
		
		$exCaptura = mysqli_query($conexion, $sql_captura);
		echo "$row[0]";	
	}
 ?>