<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 
$hora=date ("H:i:s");

$paciente =  $_POST['paciente'];

$cadena_consulta = "SELECT id, CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM pacientes WHERE CONCAT(nombre,' ',ap_paterno,' ',ap_materno) LIKE '%$paciente%'";
$consulta_paciente = mysqli_query($conexion, $cadena_consulta);

$cuerpo ="";
while ($row_paciente = mysqli_fetch_row($consulta_paciente)) {
	$editar = "<a href='#' data-id = '$row_paciente[0]'   data-toggle='modal' data-target='#modal-default' class='btn btn-danger'>Consultas</a><br>";
	$renglon = "
	{
		\"id\": \"$row_paciente[0]\",
		\"paciente\": \"$row_paciente[1]\",
		\"historial\": \"$editar\"
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