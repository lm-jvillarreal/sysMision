<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT id, tipo_mov, folio_mov, id_sucursal, ctb_usuario, nombre_usuario, comentarios,(SELECT comentarios_errores.nombre FROM comentarios_errores WHERE comentarios_errores.id = me_control_errores.comentarios) AS Comm FROM me_control_errores WHERE id = '$id'";
$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],
	$row_editar[1],
	$row_editar[2],
	$row_editar[3],
	$row_editar[4],
	$row_editar[5],
	$row_editar[6], //id_comentario
	$row_editar[7] //comentario
);
$array_datos = json_encode($array);
echo $array_datos;
?>