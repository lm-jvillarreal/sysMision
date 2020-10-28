<?php
include '../global_seguridad/verificar_sesion.php';

$id = $_POST['id'];
$cadena_video = "SELECT url_video FROM registroIncidencias_vidvig WHERE id = '$id'";
$consulta_video = mysqli_query($conexion, $cadena_video);

$row_video = mysqli_fetch_array($consulta_video);
echo $row_video[0];
?>