<?php
include '../global_seguridad/verificar_sesion.php';
$id=$_POST['id'];
$cadenaEliminar ="DELETE FROM notas_entrada WHERE id='$id'";
$eliminarNota=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>