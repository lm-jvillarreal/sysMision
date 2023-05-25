<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT
catalogo_incidencias.id AS ID,
catalogo_incidencias.incidencia AS Incidencia,
catalogo_incidencias.categoria,
( SELECT categoria FROM categorias WHERE categorias.id = catalogo_incidencias.categoria ) AS categoria,
catalogo_incidencias.accion_sugerida,
( SELECT nombre FROM sanciones_incidencias WHERE sanciones_incidencias.id = catalogo_incidencias.accion_sugerida ) AS accion,
catalogo_incidencias.gravedad,
( SELECT gravedad FROM gravedad_incidencias WHERE gravedad_incidencias.id = catalogo_incidencias.gravedad ) AS gravedad,
activo,
catalogo_incidencias.tipo,
(SELECT tipo FROM tipos_incidencias WHERE tipos_incidencias.id = catalogo_incidencias.tipo) AS tipo
FROM
catalogo_incidencias where catalogo_incidencias.id='$id'";

$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],//id
	$row_editar[1],//incidencia
	$row_editar[2],//id_categoria
	$row_editar[3],//categoria
	$row_editar[4],//id_accion
	$row_editar[5],//accion
	$row_editar[6],//id_gravedad
	$row_editar[7],//gravedad
	$row_editar[8],//activo
	$row_editar[9],//id_tipo
	$row_editar[10]//tipo
);
$array_datos = json_encode($array);
echo $array_datos;
?>