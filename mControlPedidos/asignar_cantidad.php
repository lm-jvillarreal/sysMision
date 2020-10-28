<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];
$cantidad = $_POST['cantidad'];
$fechahora = date('Y-m-d H:i:s');

$cadenaValida = "SELECT CANTIDAD_SOLICITA FROM solicitud_traspasos WHERE ID  = '$id_registro'";
$consultaValida = mysqli_query($conexion,$cadenaValida);
$rowValida = mysqli_fetch_array($consultaValida);
if($cantidad>$rowValida[0]){
  $cadenaCantidad = "UPDATE solicitud_traspasos SET CANTIDAD_SURTIDA = '$cantidad', ID_SURTEPEDIDO='$id_usuario', FECHAHORA_SURTEPEDIDO='$fechahora', SUCURSAL_SURTEPEDIDO='$id_sede' WHERE ID='$id_registro'";
  $actualizarCantidad = mysqli_query($conexion,$cadenaCantidad);
  echo "ok";
}else{
  $cadenaCantidad = "UPDATE solicitud_traspasos SET CANTIDAD_SURTIDA = '$cantidad', ID_SURTEPEDIDO='$id_usuario', FECHAHORA_SURTEPEDIDO='$fechahora', SUCURSAL_SURTEPEDIDO='$id_sede' WHERE ID='$id_registro'";
  $actualizarCantidad = mysqli_query($conexion,$cadenaCantidad);
  echo "ok";
}
?>