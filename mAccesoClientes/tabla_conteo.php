<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$cadena_folios = "SELECT SUCURSAL, LIMITE_PERMITIDO, LIMITE_REAL, CONTEO_CLIENTES FROM covid_conteo_clientes";
$consulta_folios = mysqli_query($conexion, $cadena_folios);

$cuerpo ="";

while ($row_folios = mysqli_fetch_array($consulta_folios)) {
	$ceros = "<a href='#' class='btn btn-danger' onclick='ceros($row_folios[0])'>Cero</a>";
  $renglon = "
		{
			\"sucursal\": \"$row_folios[0]\",
			\"l_permitido\": \"$row_folios[1]\",
			\"l_real\": \"$row_folios[2]\",
			\"clientes\": \"$row_folios[3]\",
			\"ceros\": \"$ceros\"
		},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>