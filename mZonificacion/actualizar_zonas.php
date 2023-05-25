<?php
include '../global_seguridad/verificar_sesion.php';
$id=$_POST['id'];
$cantidad=$_POST['cantidad'];
$cadenaZonas="UPDATE sucursales SET inv_zonas='$cantidad' WHERE id='$id'";
$actualizarZonas=mysqli_query($conexion,$cadenaZonas);
echo "ok";
?>