<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];

$cadenaPedido="SELECT ID FROM solicitud_traspasos WHERE FOLIO_PEDIDO='$folio' AND isnull(CANTIDAD_SURTIDA)";
$consultaPedido=mysqli_query($conexion,$cadenaPedido);
$rowPedido=mysqli_fetch_array($consultaPedido);
$conteo=count($rowPedido[0]);
if($conteo>0){
  echo "nulo";
}else{
  $cadenaFinaliza = "UPDATE solicitud_traspasos SET ESTATUS = '2' WHERE FOLIO_PEDIDO = '$folio'";
  $finalizaPedido=mysqli_query($conexion,$cadenaFinaliza);
  echo "ok";
}
?>