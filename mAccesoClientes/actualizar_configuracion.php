<?php
include '../global_seguridad/verificar_sesion.php';
$limite_permitido=$_POST['limite_permitido'];
$limite_real=$_POST['limite_real'];
$conteo_clientes=$_POST['conteo_clientes'];

if($limite_real<$conteo_clientes){
  echo "mayor";
}else{
  $cadenaActualizar="UPDATE covid_conteo_clientes SET LIMITE_PERMITIDO='$limite_permitido', LIMITE_REAL='$limite_real' WHERE SUCURSAL='$id_sede'";
  $actualizarConfig=mysqli_query($conexion,$cadenaActualizar);
  echo "ok";
}
?>