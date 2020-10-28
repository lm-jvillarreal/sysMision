<?php
include '../global_seguridad/verificar_sesion.php';
$id_registro=$_POST['id_registro'];
$cadenaProveedor = "SELECT cedis FROM proveedores WHERE id ='$id_registro'";
$consultaProveedor = mysqli_query($conexion,$cadenaProveedor);
$rowProveedor = mysqli_fetch_array($consultaProveedor);
if($rowProveedor[0]=='0'){
  $estatus='1';
}else{
  $estatus='0';
}
$cadenaCambiar = "UPDATE proveedores SET cedis='$estatus' WHERE id='$id_registro'";
$cambiarProveedor = mysqli_query($conexion,$cadenaCambiar);
echo "ok";
?>