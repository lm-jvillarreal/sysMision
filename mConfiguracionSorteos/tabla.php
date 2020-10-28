<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_consulta = "SELECT id, sorteo, anio, tiraje_boletos, monto_boleto, boletos_block FROM configuracion_sorteos";

$consulta_sorteos = mysqli_query($conexion, $cadena_consulta);
$cuerpo ="";
while ($row_sorteos = mysqli_fetch_array($consulta_sorteos)) {
    $editar = "<a href='#' class='btn btn-primary' onclick='editar($row_sorteos[0])'><i class='fa fa-edit fa-lg'></i></a>";
    $eliminar = "<a href='#' class='btn btn-danger' onclick='eliminar($row_sorteos[0])'><i class='fa fa-trash-o fa-lg'></i></a>";
    $opciones = "<center>".$editar."&nbsp;".$eliminar."</center>";
    $renglon = "
	{
		\"id\": \"$row_sorteos[0]\",
		\"sorteo\": \"$row_sorteos[1]\",
		\"anio\": \"$row_sorteos[2]\",
        \"tiraje\": \"$row_sorteos[3]\",
        \"block\": \"$row_sorteos[5]\",
        \"monto\": \"$row_sorteos[4]\",
        \"opciones\": \"$opciones\"
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