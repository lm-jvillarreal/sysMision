<?php
include '../global_settings/conexion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$sucursal = $_POST['sucursal'];

$cadena_desglose = "SELECT DISTINCT(inc.tipo_incidencia), COUNT(inc.id), cat.incidencia FROM registroIncidencias_vidvig as inc INNER JOIN incidencias_vidvig as cat ON inc.tipo_incidencia = cat.id
                    WHERE (fecha_incidencia BETWEEN '$fecha_inicio' AND '$fecha_fin') AND inc.id_sucursal = '$sucursal' group by inc.tipo_incidencia";

$consulta_desglose = mysqli_query($conexion, $cadena_desglose);

$cuerpo = "";

while ($row_desglose=mysqli_fetch_array($consulta_desglose)) {
	$renglon = "
	{
		\"name\": \"$row_desglose[2]\",
		\"y\": $row_desglose[1],
		\"drilldown\": null
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = $cuerpo2;
echo $tabla;
?>