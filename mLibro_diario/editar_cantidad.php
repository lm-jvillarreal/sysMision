<?php
include '../global_seguridad/verificar_sesion.php';
$cantidad=$_POST['cantidad'];
$id_escarg=$_POST['id_escarg'];

$cadenaActualizar="UPDATE recibo_escarg SET ARTC_CANTIDAD='$cantidad' WHERE ID='$id_escarg'";
$actualizarCantidad=mysqli_query($conexion,$cadenaActualizar);
echo "ok";
?>