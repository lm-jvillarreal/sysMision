<?php
include '../global_seguridad/verificar_sesion.php';
$articulo = $_POST['articulo'];

$cadenaDescripcion = "SELECT artc_descripcion FROM cp_productos WHERE artc_articulo = '$articulo'";
$consultaDescripcion = mysqli_query($conexion, $cadenaDescripcion);
$rowDescripcion = mysqli_fetch_array($consultaDescripcion);
$conteo = count($rowDescripcion[0]);
if($conteo==0){
  echo "no_existe";
}else{
  echo $rowDescripcion[0];
}
?>