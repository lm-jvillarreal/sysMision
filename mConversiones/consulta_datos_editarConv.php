<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT id, conversion, medida, masa, tortillas, resultado
FROM
conversiones_tor
WHERE
id = '$id' 
AND activo = '1'";


$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],//id
	$row_editar[1],//conversion
	$row_editar[2],//medida
	$row_editar[3],//masa
	$row_editar[4],//tortillas
	$row_editar[5]//resultado
);
$array_datos = json_encode($array);
echo $array_datos;
?>