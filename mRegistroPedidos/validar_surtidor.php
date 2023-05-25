<?php
include '../global_seguridad/verificar_sesion.php';
$id_pedido=$_POST['pedido'];
$cadenaSurtidor="SELECT ifnull(ID_SURTEPEDIDO,'NO') FROM pv_pedidos WHERE ID='$id_pedido'";
$consultaSurtidor=mysqli_query($conexion,$cadenaSurtidor);
$rowSurtidor=mysqli_fetch_array($consultaSurtidor);
echo $rowSurtidor[0];
?>