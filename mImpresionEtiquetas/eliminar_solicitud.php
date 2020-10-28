<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$id_solicitud = $_POST['id_solicitud'];

$cadena_eliminar = "DELETE FROM solicitud_etiquetas WHERE id = '$id_solicitud'";
$eliminar_solicitud = mysqli_query($conexion, $cadena_eliminar);

$cadena_detalle = "DELETE FROM detalle_solicitud WHERE id_solicitud = '$id_solicitud'";
$eliminar_detalle = mysqli_query($conexion, $cadena_detalle);

echo "ok";
?>