<?php 	
	error_reporting(E_ALL ^ E_NOTICE);
	include '../global_seguridad/verificar_sesion.php';
	//include '../global_settings/conexion_pruebas.php';
	include '../global_settings/conexion_oracle.php';
	// $id_mapeo = $_POST['id_mapeo'];
	// $codigo= $_POST['codigo'];
	// $descripcion = $_POST['descripcion'];
	// $cantidad_nueva = $_POST['cantidad_nueva'];
	// $cantidad_antig = $_POST['cantidad_antig'];
	// $cantidad = $cantidad_nueva - $cantidad_antig;
	// $id_renglon = $_POST['id_renglon'];




	$sql_select = "SELECT 
					A.Id, 
					IdDetalleMapeo, 
					IdCaptura, 
					CantidadAnterior, 
					CantidadNueva, 
					A.Usuario,
					D.id_mapeo,
					(CantidadNueva - CantidadAnterior) as Cantidad,
					D.codigo_producto,
					D.descripcion
				FROM AuditoriaConteo A
				INNER JOIN inv_detalle_mapeo D ON D.id = A.IdDetalleMapeo
				WHERE Estatus = 1
				";
	$exSelect = mysqli_query($conexion, $sql_select);

	while ($row_sel = mysqli_fetch_row($exSelect)) {
		
		$sql = "INSERT INTO inv_detalle_mapeo(id_mapeo, consecutivo_mueble, estante, codigo_producto, fecha, hora, descripcion) VALUES('$row_sel[6]', '0', '2000', '$row_sel[8]', CURRENT_DATE, CURRENT_TIME, '$row_sel[9]')";
		//echo "$sql";
		$exSql = mysqli_query($conexion, $sql);
		$max = "SELECT MAX(id) FROM inv_detalle_mapeo";
		$exMax = mysqli_query($conexion, $max);
		$row = mysqli_fetch_row($exMax);


		$sql_captura = "INSERT INTO inv_captura (
					id_mapeo,
					id_detalle_mapeo,
					cod_producto,
					cantidad,
					usuario
				)
				VALUES
					(
						'$row_sel[6]',
						'$row[0]',
						'$row_sel[8]',
						'$row_sel[7]',
						'$id_usuario'
					)";
					$ex_captura = mysqli_query($conexion, $sql_captura);


		$sql_update = "UPDATE AuditoriaConteo SET Estatus = 2 WHERE Id = $row_sel[0]";
		$update = mysqli_query($conexion, $sql_update);
	}

	


	

	
	



	
	if ($row[0] == "") {
		echo "false";
	}else{
		echo "$row[0]";	
	}
	
	//echo "$sql";
	
 ?>