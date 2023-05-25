<?php
include '../global_seguridad/verificar_sesion.php';
$id_pedido=$_POST['pedido'];
$surtidor = $_POST['surtidor'];
if($surtidor==""){
  echo "vacio";
}else{
  $cadenaSurtidor="UPDATE pv_pedidos SET ID_SURTEPEDIDO='$surtidor' WHERE ID='$id_pedido'";
  $consultaSurtidor=mysqli_query($conexion,$cadenaSurtidor);
  echo "ok";
}
?>