<?php
include '../global_settings/conexion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2019';

$cadena_gastos = "SELECT id, cve_proveedor, nombre_proveedor, concepto, CONCAT('$',FORMAT(importe,2)), CONCAT('$',FORMAT(iva,2)), CONCAT('$',FORMAT(retencion,2)), CONCAT('$',FORMAT(total,2)), comentarios,tipo_pago, no_comprobante, estatus FROM gastos_aportaciones WHERE anio = '$anio' AND concepto = 'GASTO POR ANIVERSARIO'";

$consulta_gastos = mysqli_query($conexion, $cadena_gastos);

$cuerpo ="";

while ($row_gastos = mysqli_fetch_array($consulta_gastos)) {
	if($row_gastos[11]=="1" OR $row_gastos[10]==""){
		$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
	}elseif($row_gastos[11]=="2" OR $row_gastos[10]!=""){
		$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-success' target='blank'>$row_gastos[0]</a></center>";
	}
	if(file_exists('comprobantes/'.$row_gastos[0].'.pdf')){
		$link_total = "<center><a href='comprobantes/$row_gastos[0].pdf' target='blank'>$row_gastos[7]</a></center>";
	}elseif((!file_exists('comprobantes/'.$row_gastos[0].'.pdf')) AND($row_gastos[9]=='SGRAL1' OR $row_gastos[9]=='SGRAL2' OR $row_gastos[9]=='SGRAL3' OR $row_gastos[9]=='SGRAL4')){
		$link_total = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-sgral' target='blank'>$row_gastos[7]</a></center>";
	}else{
		$link_total = $row_gastos[7];
	}
	
	$editar = "<center><button class='btn btn-danger' onclick='editar($row_gastos[0])'><i class='fa fa-edit fa-lg' aria-hidden='true'></i></button></center>";
	$renglon = "
		{
		\"folio\": \"$link_detalle\",
		\"cve_proveedor\": \"$row_gastos[1]\",
		\"proveedor\": \"$row_gastos[2]\",
		\"concepto\": \"$row_gastos[3]\",
		\"comentarios\": \"$row_gastos[8]\",
		\"importe\": \"$row_gastos[4]\",
		\"iva\": \"$row_gastos[5]\",
		\"retencion\": \"$row_gastos[6]\",
		\"total\": \"$link_total\",
		\"editar\": \"$editar\"
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