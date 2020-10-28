<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_seguridad/verificar_sesion.php';
	//include '../global_settings/conexion_pruebas.php';
	include '../global_settings/conexion_oracle.php';
	$id_mapeo = $_POST['id_mapeo'];
	$codigo= $_POST['codigo'];
	$descripcion = $_POST['descripcion'];
	$cantidad = $_POST['cantidad'];


	$sql = "INSERT INTO inv_detalle_mapeo(id_mapeo, consecutivo_mueble, estante, codigo_producto, fecha, hora, descripcion) VALUES('$id_mapeo', '0', '1000', '$codigo', CURRENT_DATE, CURRENT_TIME, '$descripcion')";
	//echo "$sql";
	$exSql = mysqli_query($conexion, $sql);


	$max = "SELECT MAX(id) FROM inv_detalle_mapeo";
	$exMax = mysqli_query($conexion, $max);
	$row = mysqli_fetch_row($exMax);

	
	$insertar = "INSERT INTO inv_captura (
					id_mapeo,
					id_detalle_mapeo,
					cod_producto,
					cantidad,
					usuario
				)
				VALUES
					(
						'$id_mapeo',
						'$row[0]',
						'$codigo',
						'$cantidad',
						1
						'$id_usuario'
					)";
					echo "$insertar";
	$sql_ins = mysqli_query($conexion, $insertar);

	if ($row[0] == "") {
		echo "false";
	}else{
		echo "$row[0]";	
	}
	
	//echo "$sql";
	
 ?>