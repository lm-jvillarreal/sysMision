<?php
include '../global_seguridad/verificar_sesion.php';

$cadenaResto="SELECT COUNT(id) FROM registro_boletos2 WHERE estatus='1' AND usuario='$id_usuario'";
$consultaResto=mysqli_query($conexion,$cadenaResto);
$rowResto=mysqli_fetch_array($consultaResto);
$resto_boletos=$rowResto[0];

$array = array(
  $resto_boletos
);
$array_datos = json_encode($array);
echo $array_datos;
?>