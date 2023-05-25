<?php
	include '../global_settings/conexion.php';
	Include '../global_settings/consulta_sqlsrvr.php';

	$errorMovimiento = $_POST['errorMovimiento'];
	$comentarioError = $_POST['comentarioError'];
	$id_modal = $_POST['id_registro'];

	$cadena_consulta = "SELECT id, tipo_movimiento, sucursal, nombre_genera FROM formatos_movimientos WHERE id = '$id_modal'";

	$consulta_editar = mysqli_query($conexion, $cadena_consulta);
	$row_editar = mysqli_fetch_array($consulta_editar);

	$cadena_persona = "SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_editar[1]'";

	$consulta_persona = sqlsrv_query($conn, $cadena_persona);
	$row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);

	$nombre = $row['nombre'];
	$array = array(
	$row_editar[0],//id
	$row_editar[1],//tipo_movimiento
	$row_editar[2],//sucursal
	$row_editar[3]);//nombre_genera
	$array_datos = json_encode($array);
	echo $array_datos;
?>