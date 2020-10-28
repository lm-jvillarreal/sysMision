<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$sucursal = $_POST['sucursal'];

$cadena_detalle = "SELECT DISTINCT(d.codigo), d.descripcion, count(d.codigo) FROM detalle_solicitud as d inner join solicitud_etiquetas as s ON d.id_solicitud = s.id  where d.fecha between '$fecha_inicio' and '$fecha_fin' and s.sucursal = '$sucursal' and d.codigo != '' and s.tipo='0' group by (d.codigo) order by count(d.codigo) desc ";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);

$cuerpo ="";
$consecutivo = 1;

while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {
  $escape_descripcion = mysqli_real_escape_string($conexion, $row_detalle[1]);
	$renglon = "
	{
		\"consecutivo\": \"$consecutivo\",
		\"codigo\": \"$row_detalle[0]\",
		\"descripcion\": \"$escape_descripcion\",
		\"conteo\": \"$row_detalle[2]\"
	},";
  $cuerpo = $cuerpo.$renglon;
  $consecutivo = $consecutivo+1;
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