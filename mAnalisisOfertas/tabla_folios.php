<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("H:i:s");

$cadena_folios = "SELECT DISTINCT(of.folio_oferta), of.descripcion_oferta, count(of.id), DATE_FORMAT(of.fecha_registro, '%d/%m/%Y'), u.nombre_usuario, of.id 
                  FROM registro_ofertas as of INNER JOIN usuarios as u ON of.id_comprador = u.id
                  GROUP BY of.folio_oferta";
$consulta_folios = mysqli_query($conexion, $cadena_folios);

$cuerpo ="";

while ($row_folios = mysqli_fetch_array($consulta_folios)) {
  $link = "<center><a href='#' class='btn btn-danger' onclick='eliminar($row_folios[5])'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
  $ver = "<center><a href='#' data-folio = '$row_folios[5]' data-toggle = 'modal' data-target = '#modal-codigos' class='btn btn-primary' target='blank'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
	$renglon = "
		{
			\"folio\": \"$row_folios[0]\",
			\"descripcion\": \"$row_folios[1]\",
			\"cantidad\": \"$row_folios[2]\",
			\"fecha\": \"$row_folios[3]\",
			\"usuario\": \"$row_folios[4]\",
			\"ver\": \"$ver\",
			\"eliminar\": \"$link\"
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