<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_rango = "SELECT folio_inicial, folio_final FROM dispersion_boletos WHERE activo = '1' AND sucursal = '$id_sede'";
$consulta_rango = mysqli_query($conexion,$cadena_rango);
$row_rango = mysqli_fetch_array($consulta_rango);

$cadena_boletos = "SELECT COUNT(id) FROM registro_boletos WHERE folio_boleto >= '$row_rango[0]' AND folio_boleto <= '$row_rango[1]' AND sucursal = '$id_sede'";
$consulta_boletos = mysqli_query($conexion, $cadena_boletos);
$row_boletos = mysqli_fetch_array($consulta_boletos);

$total_boletos = $row_rango[1] - $row_rango[0] + 1;

$resto_boletos = $total_boletos - $row_boletos[0];

$array = array(
  $resto_boletos
);
$array_datos = json_encode($array);
echo $array_datos;
?>