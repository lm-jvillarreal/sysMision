<?php
include '../global_seguridad/verificar_sesion.php';
$cadenaConsulta="SELECT
                  ID_AREA,
                  (SELECT AREA FROM inv_areas WHERE ID=inv_muebles.ID_AREA)
                  FROM
                  inv_muebles 
                  WHERE
                  USUARIO = '$id_usuario'
                  AND ID=(SELECT MAX(ID) FROM inv_muebles WHERE USUARIO='$id_usuario')";
$consultaArea=mysqli_query($conexion,$cadenaConsulta);
$rowArea=mysqli_fetch_array($consultaArea);

$array_datos=json_encode(
  array(
    $rowArea[0],
    $rowArea[1]
  )
);

echo $array_datos;
?>