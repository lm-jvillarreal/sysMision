<?php
include '../global_seguridad/verificar_sesion.php';
$cadenaConsulta="SELECT
                  ZONA
                  FROM
                  inv_muebles 
                  WHERE
                  USUARIO = '$id_usuario'
                  AND ID=(SELECT MAX(ID) FROM inv_muebles WHERE USUARIO='$id_usuario')";
$consultaZona=mysqli_query($conexion,$cadenaConsulta);
$rowZona=mysqli_fetch_array($consultaZona);

$array_datos=json_encode(
  array(
    $rowZona[0],
    $rowZona[1]
  )
);

echo $array_datos;
?>