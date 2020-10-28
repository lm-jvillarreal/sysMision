<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];
$repartidor = $_POST['repartidor'];

$cadenaAsignar = "UPDATE pv_pedidos SET ID_REPARTEPEDIDO = '$repartidor', FECHA_REPARTEPEDIDO='$fecha', ESTATUS_PEDIDO='3', ESTATUS_REPARTO='1' WHERE ID ='$folio'";
$asignaPedido = mysqli_query($conexion,$cadenaAsignar);
echo $folio;
?>