<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['pedido'];
$total = $_POST['total'];
$cantidad = $_POST['cantidad'];
$cambio = $cantidad-$total;
$fechahora = $fecha.' '.$hora;

if($cantidad<$total){
  echo "menor";
}else{
$cadenaFinaliza = "UPDATE pv_pedidos SET MONTO_PEDIDO='$total', MONTO_LIQUIDA='$cantidad', MONTO_CAMBIO='$cambio', HORA_FINALPEDIDO='$fechahora', ESTATUS_PEDIDO='1' WHERE ID  ='$folio'";
$consultaFinaliza = mysqli_query($conexion,$cadenaFinaliza);
echo $folio;
}
?>