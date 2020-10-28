<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_detalle = "SELECT id, cve_articulo, descripcion_articulo FROM faltantes_pasven WHERE folio = '$folio'";
$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {

	$eliminar = "<center><a href='#' class='btn btn-danger' onclick='eliminar($row_detalle[0])'><i class='fa fa-trash-o fa-lg' aria-hidden='true'></a></center>";
	$renglon = "
	{
		\"no\": \"$row_detalle[0]\",
		\"codigo\": \"$row_detalle[1]\",
		\"descripcion\": \"$row_detalle[2]\",
		\"cantidad\": \"$eliminar\"
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