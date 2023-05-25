<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena = mysqli_query($conexion,"SELECT
marcas.id,
marcas.marca 
FROM
marcas
WHERE
marcas.activo = 1 
AND marcas.id = '$id'");
//7SELECT
//modelos.id,
//marcas.marca,
//modelos.id_marca 
//FROM
//modelos
//INNER JOIN marcas ON marcas.id = modelos.id_marca 
//WHERE
//marcas.id = '11'

$row = mysqli_fetch_array($cadena);

$array2 = array(
	$row[0], //id_marca
	$row[1]//marca
	);

$array = json_encode($array2);
echo "$array";
?>