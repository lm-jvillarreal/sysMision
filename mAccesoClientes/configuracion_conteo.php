<?php
include '../global_seguridad/verificar_sesion.php';
$cadenaConsulta="SELECT LIMITE_PERMITIDO, LIMITE_REAL, CONTEO_CLIENTES FROM covid_conteo_clientes WHERE SUCURSAL='$id_sede'";
$consultaConfiguracion=mysqli_query($conexion,$cadenaConsulta);
$rowConfiguracion=mysqli_fetch_array($consultaConfiguracion);

$array=array(
  $rowConfiguracion[0],
  $rowConfiguracion[1],
  $rowConfiguracion[2]
);

$array=json_encode($array);
echo $array;
?>