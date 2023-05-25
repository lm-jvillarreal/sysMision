<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$codigo = $_POST['codigo'];
$um = $_POST['unidad_medida'];
$depto = $_POST['depto'];

$cadenaValidar="SELECT COUNT(*) FROM cp_productos WHERE artc_articulo='$codigo'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);
if($rowValidar[0]>0){
  echo "ya_existe";
}else{
  $cadenaInsertar = "INSERT INTO cp_productos (departamento, artc_articulo, um, fecha, hora, activo, usuario)VALUES('$depto','$codigo', '$um', '$fecha', '$hora', '1', '$id_usuario')";
  $insertar = mysqli_query($conexion, $cadenaInsertar);
  echo "ok";
}
?>