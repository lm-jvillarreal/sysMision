<?php
include '../global_seguridad/verificar_sesion.php';
$folio=$_POST['folio'];
$cadenaEliminar="DELETE FROM com_kardexMovimientos WHERE FOLIO='$folio'";
$eliminarFolio=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>