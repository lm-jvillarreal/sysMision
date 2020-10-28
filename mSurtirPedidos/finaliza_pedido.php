<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];
$fechahora = $fecha.' '.$hora;
$cadenaDetalle = "SELECT CANTIDAD, IFNULL(CANTIDAD_SURTIDA,0) FROM pv_renglonespedido WHERE ID_PEDIDO = '$folio' AND CANTIDAD_SURTIDA='0'";
$consultaDetalle = mysqli_query($conexion,$cadenaDetalle);
$rowDetalle = mysqli_fetch_array($consultaDetalle);
if($rowDetalle[1]<$rowDetalle[0]){
  $estatus='3';
}else{
  $estatus='4';
}
$cadenaFinalizar = "UPDATE pv_pedidos SET ESTATUS_SURTIDO = '$estatus', HORA_FINALSURTIDO = '$fechahora' WHERE ID='$folio'";
$finalizarPedido = mysqli_query($conexion,$cadenaFinalizar);
echo "ok";
?>