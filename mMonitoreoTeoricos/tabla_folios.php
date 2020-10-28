<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_folios = "SELECT DISTINCT(m.folio), m.folio_desc, count(m.id), m.fecha, m.hora, u.nombre_usuario FROM monitoreo_teoricos as m inner join usuarios as u ON m.usuario = u.id group by m.folio";
$consulta_folios = mysqli_query($conexion, $cadena_folios);

$cuerpo ="";

while ($row_folios = mysqli_fetch_array($consulta_folios)) {
  $link = "<center><a href='#' class='btn btn-danger' onclick='eliminar($row_folios[0])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
	$ver = "<center><a href='#' data-folio = '$row_folios[0]' data-toggle = 'modal' data-target = '#modal-teoricos' class='btn btn-primary' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
	$compartir = "<center><a href='#' data-folio = '$row_folios[0]' data-toggle = 'modal' data-target = '#modal-compartir' class='btn btn-success' target='blank'><i class='fa fa-share fa-lg' aria-hidden='true'></i></a></center>";
	$renglon = "
		{
		\"folio\": \"$row_folios[0]\",
		\"descripcion\": \"$row_folios[1]\",
		\"cantidad\": \"$row_folios[2]\",
    \"fecha\": \"$row_folios[3]\",
    \"usuario\": \"$row_folios[5]\",
    \"ver\": \"$ver\",
		\"eliminar\": \"$link\",
		\"compartir\": \"$compartir\"
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