<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT
catalogo_incidencias.id_incidencia,
catalogo_incidencias.nombre AS incidencia,
catalogo_formatos.id,
catalogo_formatos.nombre AS categoria,
catalogo_incidencias.gravedad,
sanciones_incidencias.id,
sanciones_incidencias.nombre,
catalogo_formatos.nombre 
FROM
catalogo_incidencias,
catalogo_formatos ,
sanciones_incidencias
WHERE
catalogo_incidencias.id_incidencia = '$id' 
AND catalogo_incidencias.categoria = catalogo_formatos.id 
AND id_incidencia = '$id'
AND sanciones_incidencias.id= catalogo_incidencias.accion";


$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],//id_incidencia
	$row_editar[1],//incidencia
	$row_editar[2],//id_categoria
	$row_editar[3],//categoria
	$row_editar[4],//gravedad
	$row_editar[5],//id_sanciones
	$row_editar[6],//accion
	$row_editar[7]//formato
);
$array_datos = json_encode($array);
echo $array_datos;
?>