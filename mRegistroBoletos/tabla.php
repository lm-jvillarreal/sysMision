<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_boletos = "SELECT id, folio_boleto, folio_ticket, subtotal, impuestos, ajuste, total, estatus FROM registro_boletos where fecha = '$fecha' AND sucursal = '$id_sede' ORDER BY folio_boleto DESC LIMIT 30";

$consulta_boletos = mysqli_query($conexion, $cadena_boletos);
$cuerpo ="";
while ($row_boletos = mysqli_fetch_array($consulta_boletos)) {
  if($row_boletos[7]=='1'){
    $folio_boleto = "<div class='input-group' style='width:100%''><input type='text' id='folio_$row_boletos[0]' class='form-control' value='$row_boletos[1]'><span class='input-group-btn'><button onclick='asocia($row_boletos[0])' class='btn btn-danger' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
  }elseif($row_boletos[7]=='2'){
    $folio_boleto = "<div class='input-group' style='width:100%''><input type='text' id='folio_$row_boletos[0]' class='form-control' value='$row_boletos[1]'><span class='input-group-btn'><button onclick='asocia($row_boletos[0])' class='btn btn-success' type='button'><i class='fa fa-save fa-lg' aria-hidden='true'></i></button></span></div>";
  }else{
    $folio_boleto = $row_boletos[1];
  }
	$renglon = "
	{
		\"id\": \"$row_boletos[0]\",
		\"folio_boleto\": \"$folio_boleto\",
    \"folio_ticket\": \"$row_boletos[2]\",
    \"sucursal\": \"$nombre_sede\",
    \"subtotal\": \"$row_boletos[3]\",
    \"impuestos\": \"$row_boletos[4]\",
    \"ajuste\": \"$row_boletos[5]\",
    \"total\": \"$row_boletos[6]\"
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