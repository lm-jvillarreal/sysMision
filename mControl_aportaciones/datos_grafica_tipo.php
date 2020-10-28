<?php
include '../global_settings/conexion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2019';
$anio = $_POST['anio'];
$concepto = $_POST['concepto'];

$cadena_desglose = "select tipo_movimiento, SUM(total) from aportaciones WHERE anio = '$anio' AND concepto = '$concepto' GROUP BY tipo_movimiento";

$consulta_desglose = mysqli_query($conexion, $cadena_desglose);

$cuerpo = "";

while ($row_desglose=mysqli_fetch_array($consulta_desglose)) {
	$renglon = "
	{
		\"name\": \"$row_desglose[0]\",
		\"y\": $row_desglose[1],
		\"drilldown\": null
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = $cuerpo2;
echo $tabla;
?>