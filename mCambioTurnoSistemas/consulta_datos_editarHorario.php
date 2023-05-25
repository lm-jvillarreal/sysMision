<?php
	include '../global_settings/conexion.php';
	Include '../global_settings/consulta_sqlsrvr.php';

	$id = $_POST['id'];

	$cadena_consulta = "SELECT
	id,
	empleado,
	turno_actual,
	turno_nuevo,
	horario_inicio,
	horario_final,
	comentario,
	activo
FROM
	cambio_turnoSistemas
WHERE
	activo = '1' and id='$id'"; 

	$consulta_editar = mysqli_query($conexion, $cadena_consulta);
	$row_editar = mysqli_fetch_array($consulta_editar);

	$cadena_persona = "SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_editar[1]'";

	$consulta_persona = sqlsrv_query($conn, $cadena_persona);
	$row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);

	$nombre = $row['nombre'];
	$array = array(
	$row_editar[0],//id
	$row_editar[1],//nombre mysql
	$nombre,//nombre sql
	$row_editar[2],//turno_actual
	$row_editar[3],//turno_nuevo
	$row_editar[4],//horario_inicio
	$row_editar[5],//horario_final
	$row_editar[6]);//comentario
	$array_datos = json_encode($array);
	echo $array_datos;
?>