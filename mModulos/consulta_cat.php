<?php
include '../global_seguridad/verificar_sesion.php';

$modulo = $_POST['modulo'];

$cadena_categoria = "SELECT cat.id, cat.nombre FROM categorias_modulos as cat INNER JOIN modulos ON cat.id = modulos.categoria AND modulos.id = '$modulo'";
$consulta_categoria = mysqli_query($conexion, $cadena_categoria);

$row_categoria = mysqli_fetch_array($consulta_categoria);

$array = array(
	$row_categoria[0],
	$row_categoria[1]
);
$array_datos = json_encode($array);
echo $array_datos;
?>