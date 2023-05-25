<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fechahora=date("Y-m-d H:i:s");
$id=$_POST['id'];
$sucursal=$_POST['sucursal'];
$area=$_POST['area'];

if(empty($id)){
  $cadenaInsertar="INSERT INTO inv_areas (ID_SUCURSAL, AREA, FECHAHORA, ACTIVO, USUARIO)VALUES('$sucursal','$area','$fechahora','1','$id_usuario')";
  $insertarArea=mysqli_query($conexion,$cadenaInsertar);
  echo "ok_insert";
}else{
  $cadenaUpdate="UPDATE inv_areas SET ID_SUCURSAL='$sucursal',AREA='$area',FECHAHORA='$fechahora' WHERE ID='$id'";
  $actualizaArea=mysqli_query($conexion,$cadenaUpdate);
  echo "ok_update";
}
?>