<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_seguridad/verificar_sesion.php';
	//include '../global_settings/conexion_pruebas.php';
	include '../global_settings/conexion_oracle.php';
	$id_mapeo = $_POST['id_mapeo'];
	$codigo= $_POST['codigo'];
	$descripcion = $_POST['descripcion'];
	$cantidad_nueva = $_POST['cantidad_nueva'];
	$cantidad_antig = $_POST['cantidad_antig'];
	$cantidad = $cantidad_nueva - $cantidad_antig;
	$id_renglon = $_POST['id_renglon'];



	$sql = "INSERT INTO inv_detalle_mapeo(id_mapeo, consecutivo_mueble, estante, codigo_producto, fecha, hora, descripcion) VALUES('$id_mapeo', '0', '2000', '$codigo', CURRENT_DATE, CURRENT_TIME, '$descripcion')";
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
					)";
					echo "$insertar";
	$sql_ins = mysqli_query($conexion, $insertar);



	$sql_update = "UPDATE AuditoriaConteo SET Estatus = 2 WHERE Id = $id_renglon";
	$update = mysqli_query($conexion, $insertar);
	if ($row[0] == "") {
		echo "false";
	}else{
		echo "$row[0]";	
	}
	
	//echo "$sql";
	
 ?>