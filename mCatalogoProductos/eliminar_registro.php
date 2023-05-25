<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro=$_POST['id_registro'];
$cadenaEliminar="DELETE FROM cp_productos WHERE id='$id_registro'";
$eliminar=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>