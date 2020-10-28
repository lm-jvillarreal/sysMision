<?php
include '../global_settings/conexion.php';

$cadena_desglose = "SELECT aportaciones.id_comprador, CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno), SUM(aportaciones.total)
FROM aportaciones INNER JOIN usuarios  ON aportaciones.id_comprador = usuarios.id
INNER JOIN personas ON usuarios.id_persona = personas.id
GROUP BY id_comprador";

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