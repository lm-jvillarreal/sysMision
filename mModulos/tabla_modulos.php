<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$cadena_modulos = "SELECT id, nombre, descripcion FROM modulos";
$consulta_modulos = mysqli_query($conexion, $cadena_modulos);

$cuerpo ="";

while ($row_modulos = mysqli_fetch_array($consulta_modulos)) {
	$link = "<center><a href='#' class='btn btn-danger'>Editar</a></center>";
	$renglon = "
		{
		\"id_modulo\": \"$row_modulos[0]\",
		\"nombre_modulo\": \"$row_modulos[1]\",
		\"desc_modulo\": \"$row_modulos[2]\",
		\"editar_modulo\": \"$link\"
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