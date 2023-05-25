<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena_consulta = "SELECT id, turno, subreceta, produccion_teorica, harina_utilizada, merma_masa, merma_tortilla
FROM
tor_bitacora_produccion
WHERE
id = '$id' 
AND activo = '1'";


$consulta_editar = mysqli_query($conexion, $cadena_consulta);

$row_editar = mysqli_fetch_array($consulta_editar);

$array = array(
	$row_editar[0],//id
	$row_editar[1],//turno
	$row_editar[2],//subreceta
	$row_editar[3],//produccion_teorica
	$row_editar[4],//harina_utilizada
	$row_editar[5],//merma_masa
	$row_editar[6]//merma_tortilla
);
$array_datos = json_encode($array);
echo $array_datos;
?>