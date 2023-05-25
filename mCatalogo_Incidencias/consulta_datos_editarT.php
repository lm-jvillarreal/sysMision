<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT
tipos_incidencias.id,
tipos_incidencias.tipo,
categorias.id,
categorias.categoria 
FROM
tipos_incidencias,
categorias 
WHERE
tipos_incidencias.activo = '1' 
and
categorias.id = tipos_incidencias.categoria and tipos_incidencias.id='$id'";

$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],//id
	$row_editar[1],//tipo
	$row_editar[2],//id_categoria
	$row_editar[3]//categoria
);
$array_datos = json_encode($array);
echo $array_datos;
?>