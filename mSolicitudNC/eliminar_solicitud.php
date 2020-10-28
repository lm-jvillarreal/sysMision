<?php
include '../global_seguridad/verificar_sesion.php';

$id_solicitud = $_POST['id_solicitud'];
$cadena_eliminar = "DELETE FROM solicitud_nc WHERE id = '$id_solicitud'";
$eliminar_solicitud = mysqli_query($conexion, $cadena_eliminar);
echo "ok";
?>