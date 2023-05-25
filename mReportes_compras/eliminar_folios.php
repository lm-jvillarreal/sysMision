<?php
include '../global_seguridad/verificar_sesion.php';
$folio=$_POST['folio'];
$cadenaEliminar="DELETE FROM com_detalleArticulos WHERE FOLIO='$folio'";
$eliminar=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>