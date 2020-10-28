
<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$departamento=$_POST['departamento'];

$cadena_indicadores = "SELECT ID, AREA FROM revision_cierre WHERE ID_DEPTO = '$departamento'";
$consulta_indicadores = mysqli_query($conexion, $cadena_indicadores);

$cuerpo ="";

while ($row_indicadores = mysqli_fetch_array($consulta_indicadores)) {
  $opciones="<center><a href='#' data-id = '$row_indicadores[0]' data-toggle = 'modal' data-target = '#modal-fotografia' class='btn btn-success' target='blank'><i class='fa fa-camera fa-lg' aria-hidden='true'></i></a></center>";
	$renglon = "
		{
		\"id\": \"$row_indicadores[0]\",
		\"indicador\": \"$row_indicadores[1]\",
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
echo $tabla;
?>