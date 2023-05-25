<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaAreas="SELECT ID, AREA FROM vidvig_areas";
$consultaAreas=mysqli_query($conexion,$cadenaAreas);
while($rowAreas=mysqli_fetch_array($consultaAreas)){
  $ver = "<center><a href='#' class='btn btn-success' onclick='editar($rowAreas[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'id'=>$rowAreas[0],
    'area'=>$rowAreas[1],
    'opciones'=>$ver
  ));
}
echo utf8_encode(json_encode($datos));
?>