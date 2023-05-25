<?php
include '../global_seguridad/verificar_sesion.php';
$folio_pedido=$_POST['folio_pedido'];
$fechahora=$fecha.' '.$hora;
$cadenaFinalizar="UPDATE pv_pedidos SET HORA_FINALPEDIDO='$fechahora', ESTATUS_PEDIDO='1' WHERE ID='$folio_pedido'";
$finalizarPedido=mysqli_query($conexion,$cadenaFinalizar);
echo "ok";
?>