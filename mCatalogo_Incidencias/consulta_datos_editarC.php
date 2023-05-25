<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT id, categoria FROM categorias WHERE activo ='1'and id='$id'";

$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],//id
	$row_editar[1]//categoria
);
$array_datos = json_encode($array);
echo $array_datos;
?>