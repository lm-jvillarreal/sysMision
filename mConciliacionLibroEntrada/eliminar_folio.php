<?php
include '../global_seguridad/verificar_sesion.php';
$id_folio = $_POST['id_folio'];
$cadenaEliminar = "DELETE FROM alb_foliomov WHERE id = '$id_folio'";
$eliminarFolio = mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>