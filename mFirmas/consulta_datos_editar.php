<?php
include '../global_settings/conexion.php';
// include '../global_settings/consulta_sqlsrvr.php';

$id_registro = $_POST['id_registro'];

$cadena_consulta = "SELECT
id_permiso,
nombre,
activo
FROM
permisos
where id_permiso='$id_registro'";

$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

// $cadena_persona = "SELECT codigo, (cast(codigo as varchar) + ' - ' + nombre + ' ' + ap_paterno + ' ' + ap_materno) AS 'nombre' FROM empleados WHERE activo = 'S' AND codigo = '$row_editar[1]'";

// $consulta_persona = sqlsrv_query($conn, $cadena_persona);
// $row = sqlsrv_fetch_array( $consulta_persona, SQLSRV_FETCH_ASSOC);

$array = array(
	$row_editar[0],//id
	$row_editar[1]//nombre mysql
	// $row['nombre'],//nombre sql
	// $row_editar[2],//departamento
	// $row_editar[3],//sucursal
	// $row_editar[4],//hora_inicio
	// $row_editar[5],//hora_final
	// $row_editar[6],//tiempo
	// $row_editar[7],//motivo
	// $row_editar[8],//motivoOtro
	// $row_editar[9]//comentario
);
$array_datos = json_encode($array);
// echo $id_registro;
echo $array_datos;
?>