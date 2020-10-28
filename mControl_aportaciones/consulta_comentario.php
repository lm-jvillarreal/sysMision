<?php
include "../global_settings/conexion.php";

$id = $_POST['id'];

$cadena_comentario = "SELECT id, comentarios FROM aportaciones WHERE id = '$id'";
$consulta_comentario = mysqli_query($conexion, $cadena_comentario);
$row_comentario = mysqli_fetch_array($consulta_comentario);

$array = array(
	$row_comentario[0],
	$row_comentario[1]
	);

$array_datos = json_encode($array);
echo "$array_datos"; 
?>