<?php
include '../global_seguridad/verificar_sesion.php';
$id=$_POST['registro'];
$cadenaEliminar="DELETE FROM devoluciones WHERE id='$id'";
$eliminarFolio=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>