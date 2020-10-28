<?php
include '../global_seguridad/verificar_sesion.php';

$cadenaInterno = "SELECT COUNT(codigo_interno)+1 FROM catalogo_piezas";
$consultaInterno = mysqli_query($conexion,$cadenaInterno);
$rowInterno = mysqli_fetch_array($consultaInterno);
$interno =$rowInterno[0];
$array =array(
  $interno
);
$array_datos = json_encode($array);
echo $array_datos;

?>