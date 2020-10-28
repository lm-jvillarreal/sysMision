<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_actividades = "SELECT a.id, a.actividad, d.nombre, CONCAT(a.inicio_do, ' - ',a.fin_do), CONCAT(a.inicio_arb, ' - ',a.fin_arb), CONCAT(a.inicio_vill, ' - ',a.fin_vill), CONCAT(a.inicio_all, ' - ',a.fin_all),CONCAT(a.inicio_pet, ' - ',a.fin_pet)
FROM catalogoActividades_vidvig as a INNER JOIN departamentos as d ON a.id_area = d.id";

$consulta_actividades = mysqli_query($conexion, $cadena_actividades);
$cuerpo ="";
while ($row_actividades = mysqli_fetch_array($consulta_actividades)) {
    $escape_actividad = mysqli_real_escape_string($conexion, $row_actividades[1]);
    $escape_area = mysqli_real_escape_string($conexion, $row_actividades[2]);
	$renglon = "
	{
        \"id\": \"$row_actividades[0]\",
        \"actividad\": \"$escape_actividad\",
        \"area\": \"$escape_area\",
        \"rango_do\": \"$row_actividades[3]\",
        \"rango_arb\": \"$row_actividades[4]\",
        \"rango_vill\": \"$row_actividades[5]\",
        \"rango_all\": \"$row_actividades[6]\",
        \"rango_pet\": \"$row_actividades[7]\"
		
	},";
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');
$tabla = "
["
.$cuerpo2.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>