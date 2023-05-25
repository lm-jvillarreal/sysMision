<?php
include '../global_seguridad/verificar_sesion.php';
$id=$_POST['id'];
$cadenaVigilante="SELECT ID, AP_PATERNO, AP_MATERNO, NOMBRE, ID_SUCURSAL FROM vidvig_vigilantes WHERE ID='$id'";
$consultaVigilante=mysqli_query($conexion,$cadenaVigilante);
$rowVigilante=mysqli_fetch_array($consultaVigilante);
$array=json_encode(array(
  $rowVigilante[0],
  $rowVigilante[1],
  $rowVigilante[2],
  $rowVigilante[3],
  $rowVigilante[4]
));

echo $array;
?>