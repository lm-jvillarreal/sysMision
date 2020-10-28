<?php
include '../global_settings/conexion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = $_POST["anio"];
$concepto = $_POST["concepto"];

$cadena_gastos = "SELECT SUM(total) FROM gastos_aportaciones WHERE anio = '$anio' AND concepto = 'GASTO POR ANIVERSARIO'";
$consulta_gastos = mysqli_query($conexion, $cadena_gastos);
$row_gastos = mysqli_fetch_array($consulta_gastos);

$cadena_aportaciones = "SELECT SUM(total) FROM aportaciones WHERE anio = '$anio' AND concepto = '$concepto'";
$consulta_aportaciones = mysqli_query($conexion, $cadena_aportaciones);
$row_aportaciones = mysqli_fetch_array($consulta_aportaciones);

$gastos = $row_gastos[0];
$aportaciones = $row_aportaciones[0];
$restante = $gastos - $aportaciones;

$aportado=(empty($aportaciones))?"0":"$aportaciones";
$resto=(empty($restante))?"0":"$restante";

	$renglon = "
		[\"Aportaciones\", $aportado],
		[\"Gastos\", $resto]";

echo $renglon;
?>