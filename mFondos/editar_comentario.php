<?php
include '../global_settings/conexion.php';

$id_aportacion = $_POST['id_aportacion'];
$comentario = $_POST['area_comentario'];

$cadena_editar = "UPDATE fondos SET comentarios = '$comentario' WHERE id = '$id_aportacion'";
$consulta_editar = mysqli_query($conexion, $cadena_editar);

echo "ok";
?>