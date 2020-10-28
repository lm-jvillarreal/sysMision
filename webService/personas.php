<?php
include '../global_settings/conexion.php';

$cadenaPersonas = "SELECT id, nombre, ap_paterno, ap_materno FROM ejemplo_insertar";
$consultaPersonas = mysqli_query($conexion,$cadenaPersonas);
$datos=array();
while($rowPersonas=mysqli_fetch_array($consultaPersonas)){
  array_push($datos,array(
    'id'=>$rowPersonas[0],
    'nombre'=>$rowPersonas[1],
    'ap_paterno'=>$rowPersonas[2],
    'ap_materno'=>$rowPersonas[3]
  ));
}
echo utf8_encode(json_encode($datos));
?>