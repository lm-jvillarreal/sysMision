<?php
include '../global_seguridad/verificar_sesion.php';
$id_solicitud = $_POST['id_solicitud'];

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_detalle = "SELECT id, codigo, descripcion,cantidad FROM detalle_solicitud WHERE id_solicitud='$id_solicitud'";

$consulta_detalle = mysqli_query($conexion, $cadena_detalle);
$cuerpo ="";
while ($row_detalle = mysqli_fetch_array($consulta_detalle)) {

	if($row_detalle[3] != ""){
		$valor = $row_detalle[3];
	}
	else{
		$valor = 1;
	}
	$escape_descripcion = mysqli_real_escape_string($conexion, $row_detalle[2]);
	$cantidad = "<input type='hidden' name='id[]' value='$row_detalle[0]'><input type='number' class='form-control' name='cantidad[]' style='width: 100%' value='$valor' onblur='act_cantidad(this.value,$row_detalle[0])'><input type='hidden' value='$id_solicitud' name='id_solicitud[]'>";
	$renglon = "
	{
		\"no\": \"$row_detalle[0]\",
		\"codigo\": \"$row_detalle[1]\",
		\"descripcion\": \"$escape_descripcion\",
		\"cantidad\": \"$cantidad\"
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