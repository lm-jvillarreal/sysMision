<?php
include '../global_seguridad/verificar_sesion.php';
$folio_pedido=$_POST['folio_pedido'];
$cadenaCancelar="UPDATE pv_pedidos SET ESTATUS_PEDIDO='99' WHERE  ID='$folio_pedido'";
$cancelarPedido=mysqli_query($conexion,$cadenaCancelar);
echo "ok";
?>