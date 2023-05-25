<?php
include '../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2022';

$cadena_gastos = "select SUM(total) from aportaciones GROUP BY anio ORDER BY anio ASC";
$consulta_gastos = mysqli_query($conexion, $cadena_gastos);

$valores = "";
while ($row_gastos = mysqli_fetch_array($consulta_gastos)) {
	$valores = $valores.$row_gastos[0].",";
}
$valores = trim($valores, ',');

echo $valores;
?>