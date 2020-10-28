<?php
include '../global_settings/conexion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
//$anio = '2019';
$anio = $_POST['anio'];
$concepto = $_POST['concepto'];

$cadena_desglose = "SELECT id, nombre_proveedor, SUM(total) FROM aportaciones WHERE anio = '$anio' AND concepto = '$concepto' group by cve_proveedor order by SUM(total) ASC";

$consulta_desglose = mysqli_query($conexion, $cadena_desglose);

$cuerpo = "";

while ($row_desglose=mysqli_fetch_array($consulta_desglose)) {
	$renglon = "
	{
		\"name\": \"$row_desglose[1]\",
		\"y\": $row_desglose[2],
		\"drilldown\": null
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = $cuerpo2;
echo $tabla;
?>