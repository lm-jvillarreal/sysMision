<?php
include '../global_seguridad/verificar_sesion.php';
$id=$_POST['id'];
$cadenaAreas="SELECT ID, AREA FROM vidvig_areas WHERE ID='$id'";
$consultaAreas=mysqli_query($conexion,$cadenaAreas);
$rowAreas=mysqli_fetch_array($consultaAreas);
$array=json_encode(array(
  $rowAreas[0],
  $rowAreas[1]
));
echo $array;
?>