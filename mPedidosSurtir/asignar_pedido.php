<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];
$usuarios = $_POST['usuarios'];

$cadenaAsignar = "UPDATE pv_pedidos SET ID_SURTEPEDIDO = '$usuarios', ID_ASIGNA='$id_usuario', FECHA_SURTEPEDIDO='$fecha', ESTATUS_PEDIDO='2', ESTATUS_SURTIDO='1' WHERE ID ='$folio'";
$asignaPedido = mysqli_query($conexion,$cadenaAsignar);
echo $folio;
?>