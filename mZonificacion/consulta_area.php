<?php
include '../global_seguridad/verificar_sesion.php';
$id=1;
$cadenaArea="SELECT
              A.ID,
              A.ID_SUCURSAL,
              (SELECT nombre FROM sucursales WHERE ID=A.ID_SUCURSAL) as Sucursal,
              A.AREA 
              FROM
              inv_areas AS A 
              WHERE
              ID = '$id'";
$consultaArea=mysqli_query($conexion,$cadenaArea);
$rowArea=mysqli_fetch_array($consultaArea);
$datos=array(
  $rowArea[0],
  $rowArea[1],
  $rowArea[2],
  $rowArea[3]
);
$datos=json_encode($datos);
echo $datos;
?>