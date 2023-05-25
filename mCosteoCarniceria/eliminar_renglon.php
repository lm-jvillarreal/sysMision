<?php
include '../global_seguridad/verificar_sesion.php';
$id_renglon=$_POST['id_renglon'];

$cadenaEliminar="DELETE FROM carniceria_catalogorenglones WHERE ID='$id_renglon'";
$eliminar=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>