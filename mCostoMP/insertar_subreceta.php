<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");

$clave_receta=$_POST['clave_subreceta'];
$nombre_receta=$_POST['nombre_subreceta'];
$rendimiento=$_POST['rendimiento'];
$unidad_medida=$_POST['unidad_medida'];

$cadenaValidar="SELECT COUNT(*) FROM perecederos_subrecetas WHERE CLAVE_RECETA='$clave_receta'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
if($rowValidar[0]>0){
  echo "existe";
}else{
  $cadenaInsertar="INSERT INTO perecederos_subrecetas (CLAVE_RECETA, NOMBRE_RECETA, RENDIMIENTO, UNIDAD_MEDIDA, FECHAHORA, ACTIVO, USUARIO)VALUES('$clave_receta','$nombre_receta','$rendimiento','$unidad_medida','$fechahora','1','$id_usuario')";
  $consultaInsertar=mysqli_query($conexion,$cadenaInsertar);
  echo "ok";
}
?>