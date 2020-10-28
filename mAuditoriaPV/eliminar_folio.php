<?php
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];

$cadenaEliminar = "DELETE FROM auditoria_pv WHERE folio = '$folio'";
$eliminarFolio = mysqli_query($conexion, $cadenaEliminar);
echo "ok";
?>