<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT id, clave, nombre FROM claves_apsi WHERE activo ='1'and id='$id'";

$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],//id
	$row_editar[1],//CLAVE
	$row_editar[2]//nombre
);
$array_datos = json_encode($array);
echo $array_datos;
?>