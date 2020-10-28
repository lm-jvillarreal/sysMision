<?php
include '../global_seguridad/verificar_sesion.php';
$numero_proveedor =$_POST['id_proveedor'];
$cadenaProveedor="SELECT id FROM proveedores WHERE id='$numero_proveedor' AND escarg='1'";
$consultaProveedor=mysqli_query($conexion,$cadenaProveedor);
$rowProveedor=mysqli_fetch_array($consultaProveedor);
$conteo=count($rowProveedor[0]);
if($conteo>0){
  echo "si";
}elseif($conteo==0){
  echo "no";
}
?>