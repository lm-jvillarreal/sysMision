<?php
include '../global_seguridad/verificar_sesion.php';
$artc_articulo=$_POST['artc_articulo'];
$validar =substr($artc_articulo, 0, 2);
if($validar=='SR'){
  $cadenaDescripcion="SELECT NOMBRE_RECETA FROM tortilleria_subrecetas WHERE CLAVE_RECETA='$artc_articulo' AND ACTIVO=1";
  $consultaDescripcion=mysqli_query($conexion,$cadenaDescripcion);
  $row=mysqli_fetch_array($consultaDescripcion);
  $conteo=count($row[0]);
  $subreceta=1;
}else{
  $cadenaDescripcion="SELECT ARTC_DESCRIPCION FROM tortilleria_articulos WHERE ARTC_ARTICULO='$artc_articulo' AND ACTIVO=1";
  $consultaDescripcion=mysqli_query($conexion,$cadenaDescripcion);
  $row=mysqli_fetch_array($consultaDescripcion);
  $conteo=count($row[0]);
  $subreceta=0;
}
if($conteo==0){
  echo "no_existe";
}else{
  echo utf8_encode(json_encode(array($row[0],$subreceta)));
}
?>