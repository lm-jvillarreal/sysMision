<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro = $_POST['id_registro'];
$cantidad = $_POST['cantidad'];

$cadenaValidar = "SELECT CANTIDAD FROM pv_renglonespedido WHERE ID = '$id_registro'";
$consultaValidar = mysqli_query($conexion,$cadenaValidar);
$rowValidar = mysqli_fetch_array($consultaValidar);
if($cantidad>$rowValidar[0]){
  echo "mayor";
}else{
  $cadenaConsulta = "UPDATE pv_renglonespedido SET CANTIDAD_SURTIDA = '$cantidad' WHERE ID = '$id_registro'";
  $editarCantidad = mysqli_query($conexion,$cadenaConsulta);
  echo "ok";
}
?>