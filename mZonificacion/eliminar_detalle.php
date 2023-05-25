<?php
include '../global_seguridad/verificar_sesion.php';
$id_detalle=$_POST['id_detalle'];
$cadenaEliminar="DELETE FROM inv_detallemuebles WHERE ID='$id_detalle'";
$consultaEliminar=mysqli_query($conexion,$cadenaEliminar);
echo "ok";
?>