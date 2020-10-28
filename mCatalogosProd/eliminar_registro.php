<?php
include '../global_seguridad/verificar_sesion.php';

$cve_catalogo = $_POST['cve_catalogo'];
$id_registro = $_POST['id_registro'];

$cadena_eliminar = "DELETE FROM cp_catalogos WHERE id = '$id_registro'";
$eliminar_registro = mysqli_query($conexion, $cadena_eliminar);

echo "ok";
?>