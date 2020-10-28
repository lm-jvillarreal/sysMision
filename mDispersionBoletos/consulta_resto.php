<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_rangoDO = "SELECT folio_inicial, folio_final FROM dispersion_boletos WHERE activo = '1' AND sucursal = '1'";
$consulta_rangoDO = mysqli_query($conexion,$cadena_rangoDO);
$row_rangoDO = mysqli_fetch_array($consulta_rangoDO);

$cadena_boletosDO = "SELECT COUNT(id) FROM registro_boletos WHERE folio_boleto >= '$row_rangoDO[0]' AND folio_boleto <= '$row_rangoDO[1]' AND sucursal = '1'";
$consulta_boletosDO = mysqli_query($conexion, $cadena_boletosDO);
$row_boletosDO = mysqli_fetch_array($consulta_boletosDO);

$total_DO = $row_rangoDO[1] - $row_rangoDO[0] + 1;
$resto_DO = $total_DO - $row_boletosDO[0];
$porcentajeDO = ($row_boletosDO[0]/$total_DO)* 100;
$porcentajeDO = round($porcentajeDO,2);

$cadena_rangoARB = "SELECT folio_inicial, folio_final FROM dispersion_boletos WHERE activo = '1' AND sucursal = '2'";
$consulta_rangoARB = mysqli_query($conexion,$cadena_rangoARB);
$row_rangoARB = mysqli_fetch_array($consulta_rangoARB);

$cadena_boletosARB = "SELECT COUNT(id) FROM registro_boletos WHERE folio_boleto >= '$row_rangoARB[0]' AND folio_boleto <= '$row_rangoARB[1]' AND sucursal = '2'";
$consulta_boletosARB = mysqli_query($conexion, $cadena_boletosARB);
$row_boletosARB = mysqli_fetch_array($consulta_boletosARB);

$total_ARB = $row_rangoARB[1] - $row_rangoARB[0] + 1;
$resto_ARB = $total_ARB - $row_boletosARB[0];
$porcentajeARB = ($row_boletosARB[0]/$total_ARB)* 100;
$porcentajeARB = round($porcentajeARB,2);

$cadena_rangoVILL = "SELECT folio_inicial, folio_final FROM dispersion_boletos WHERE activo = '1' AND sucursal = '3'";
$consulta_rangoVILL = mysqli_query($conexion,$cadena_rangoVILL);
$row_rangoVILL = mysqli_fetch_array($consulta_rangoVILL);

$cadena_boletosVILL = "SELECT COUNT(id) FROM registro_boletos WHERE folio_boleto >= '$row_rangoVILL[0]' AND folio_boleto <= '$row_rangoVILL[1]' AND sucursal = '3'";
$consulta_boletosVILL = mysqli_query($conexion, $cadena_boletosVILL);
$row_boletosVILL = mysqli_fetch_array($consulta_boletosVILL);

$total_VILL = $row_rangoVILL[1] - $row_rangoVILL[0] + 1;
$resto_VILL = $total_VILL - $row_boletosVILL[0];
$porcentajeVILL = ($row_boletosVILL[0]/$total_VILL)* 100;
$porcentajeVILL = round($porcentajeVILL,2);

$cadena_rangoALL = "SELECT folio_inicial, folio_final FROM dispersion_boletos WHERE activo = '1' AND sucursal = '4'";
$consulta_rangoALL = mysqli_query($conexion,$cadena_rangoALL);
$row_rangoALL = mysqli_fetch_array($consulta_rangoALL);

$cadena_boletosALL = "SELECT COUNT(id) FROM registro_boletos WHERE folio_boleto >= '$row_rangoALL[0]' AND folio_boleto <= '$row_rangoALL[1]' AND sucursal = '4'";
$consulta_boletosALL = mysqli_query($conexion, $cadena_boletosALL);
$row_boletosALL = mysqli_fetch_array($consulta_boletosALL);

$total_ALL = $row_rangoALL[1] - $row_rangoALL[0] + 1;
$resto_ALL = $total_ALL - $row_boletosALL[0];
$porcentajeALL = ($row_boletosALL[0]/$total_ALL)* 100;
$porcentajeALL = round($porcentajeALL,2);

$array = array(
  $resto_DO,
  $porcentajeDO,
  $resto_ARB,
  $porcentajeARB,
  $resto_VILL,
  $porcentajeVILL,
  $resto_ALL,
  $porcentajeALL
);

$array_datos = json_encode($array);
echo $array_datos;
?>