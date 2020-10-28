<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_consulta = "SELECT ID, FOLIO_TICKET, ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_CANTIDAD, ARTC_PRECIO, ARTC_CAMBIOPRECIO, ARTC_DIFERENCIAPRECIO, TOTAL_DIFERENCIAPRECIO FROM valecaja_provisional WHERE SUCURSAL='$id_sede'";
$consulta=mysqli_query($conexion,$cadena_consulta);

$cuerpo ="";
while ($row = mysqli_fetch_array($consulta)) {
  $link="<center><a href='#' class='btn btn-primary btn-sm' onclick='reimprimir($row[0])'><i class='fa fa-print fa-lg' aria-hidden='true'></i></a></center>";
	$renglon = "
	{
		\"ID\": \"$row[0]\",
		\"FOLIO_TICKET\": \"$row[1]\",
    \"ARTC_ARTICULO\": \"$row[2]\",
    \"ARTC_DESCRIPCION\": \"$row[3]\",
    \"ARTC_CANTIDAD\": \"$row[4]\",
    \"ARTC_PRECIO\": \"$row[5]\",
    \"ARTC_CAMBIOPRECIO\": \"$row[6]\",
    \"ARTC_DIFERENCIAPRECIO\": \"$row[7]\",
    \"TOTAL_DIFERENCIAPRECIO\": \"$row[8]\",
    \"OPCIONES\": \"$link\"
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