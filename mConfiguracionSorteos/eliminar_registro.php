<?php
include "../global_seguridad/verificar_sesion.php";

$id_registro = $_POST['id_registro'];

$cadena_eliminar = "DELETE FROM configuracion_sorteos WHERE id = '$id_registro'";
$eliminar_registro = mysqli_query($conexion, $cadena_eliminar);
echo "ok";
?>