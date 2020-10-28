<?php
include '../global_seguridad/verificar_sesion.php';

$id_cambio = $_POST['id_cambio'];
$comentario = $_POST['coment_cambio'];

$cadena_comentario = "UPDATE bitacora_cambios SET comentario_libera = '$comentario' WHERE id = '$id_cambio'";
$inserta_comentatio = mysqli_query($conexion, $cadena_comentario);
echo "ok";
?>