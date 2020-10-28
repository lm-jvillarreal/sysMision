<?php
include '../global_seguridad/verificar_sesion.php';
include '../funciones/detalle_articulo.php';

$artc_articulo = $_POST['codigo'];
$detalle = json_decode(detalle_articulo($id_sede,$artc_articulo));

$array = array(
  $detalle[1],
  $detalle[5]
);
$array = json_encode($array);
echo $array;
?>