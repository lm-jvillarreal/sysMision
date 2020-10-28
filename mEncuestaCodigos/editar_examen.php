<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];

$cadena = mysqli_query($conexion,"SELECT nombre, tipo_examen, id_categoria, (SELECT nombre FROM categoria_codigos WHERE examenes.id_categoria = categoria_codigos.id) FROM examenes WHERE id = '$id'");

$row = mysqli_fetch_array($cadena);

$array2 = array(
	$row[0], //nombre
	$row[1], //tipo_examen
	$row[2], //id_categoria
	$row[3] //catalogo
);

$array = json_encode($array2);
echo "$array";
?>