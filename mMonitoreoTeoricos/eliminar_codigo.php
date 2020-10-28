<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];
$cadena_eliminar = "DELETE FROM monitoreo_teoricos WHERE id = '$folio'";
$eliminar_folio = mysqli_query($conexion, $cadena_eliminar);
echo "ok";
?>