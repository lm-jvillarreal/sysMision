<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro=$_POST['id_registro'];

$cadenaElimina="DELETE FROM libro_diario WHERE id='$id_registro'";
$elimina=mysqli_query($conexion,$cadenaElimina);
echo "ok";
?>