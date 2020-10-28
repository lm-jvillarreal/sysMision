<?php
include '../global_seguridad/verificar_sesion.php';
$cadenaFolio = "SELECT IFNULL(MAX(folio),0)+1 FROM monitoreo_teoricos";
$consultaFolio = mysqli_query($conexion, $cadenaFolio);
$rowFolio = mysqli_fetch_array($consultaFolio);

$array = array(
  $rowFolio[0]
);

$array_datos = json_encode($array);
echo $array_datos;
?>