<?php
include '../global_seguridad/verificar_sesion.php';
$id = $_POST['id'];
$cadenaEliminar = "DELETE FROM pv_renglonespedido WHERE ID = '$id'";
$eliminarRenglon = mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>