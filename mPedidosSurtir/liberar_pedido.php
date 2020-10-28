<?php
include '../global_seguridad/verificar_sesion.php';
$cantidad = $_POST['cantidad'];
$id_pedido = $_POST['id_pedido'];

$cadenaCantidad = "SELECT MONTO_LIQUIDA FROM pv_pedidos WHERE ID ='$id_pedido'";
$consultaCantidad = mysqli_query($conexion,$cadenaCantidad);
$rowCantidad = mysqli_fetch_array($consultaCantidad);

if($cantidad<$rowCantidad[0]){
  echo "menor";
}else{
  $cadenaFinalizar = "UPDATE pv_pedidos SET HORA_FINALREPARTO='$fecha', ESTATUS_REPARTO='2', PEDIDO_CORTE='1', CANTIDAD_CORTE='$cantidad' WHERE ID='$id_pedido'";
  $consultaFinaliza = mysqli_query($conexion, $cadenaFinalizar);
  echo $id_pedido;
} 
?>