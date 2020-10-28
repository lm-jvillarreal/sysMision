<?php
include '../global_seguridad/verificar_sesion.php';
$id_escarg=$_POST['id_escarg'];
$cadenaEliminar = "DELETE FROM recibo_escarg WHERE ID='$id_escarg'";
$eliminarEscar=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>