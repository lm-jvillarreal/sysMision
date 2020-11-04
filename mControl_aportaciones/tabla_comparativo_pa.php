<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$anio = '2020';
$filtro_rp = (!empty($registros_propios) == '1') ? " AND id_comprador = '$id_usuario'" : "";

$cadena_aportaciones = "SELECT proy.id, proy.cve_proveedor, proy.nombre_proveedor, proy.monto, aport.total, usr.nombre_usuario 
						FROM ap_proyeccion AS proy
						INNER JOIN usuarios as usr on proy.id_comprador = usr.id
						LEFT JOIN aportaciones as aport
						ON proy.cve_proveedor = aport.cve_proveedor
						AND proy.nombre_concepto = aport.concepto
						WHERE proy.ano='$anio'
						ORDER BY proy.id ASC";

$consulta_aportaciones = mysqli_query($conexion, $cadena_aportaciones);

$cuerpo ="";

while ($row_aportaciones = mysqli_fetch_array($consulta_aportaciones)) {

	$d_real = $row_aportaciones[3]-$row_aportaciones[4];
	if ($d_real<0) {
		$d_real = ($d_real)*(-1);
		$diferencia = "<span class='description-percentage text-green'><i class='fa fa-caret-up'></i> ".money_format("%.2n", $d_real)."</span>";
	}elseif($d_real>0){
		$diferencia = "<span class='description-percentage text-red'><i class='fa fa-caret-down'></i> ".money_format("%.2n", $d_real)."</span>";
	}elseif($d_real==0){
		$diferencia = "<span class='description-percentage text-blue'><i class='fa fa-caret-right'></i> ".money_format("%.2n", $d_real)."</span>";
	}
	$proyeccion = money_format("%.2n", $row_aportaciones[3]);
	$aportacion = money_format("%.2n", $row_aportaciones[4]);
	//$diferencia = money_format("%.2n", $row_aportaciones[3]-$row_aportaciones[4]);
	$renglon = "
		{
		\"no\": \"$row_aportaciones[0]\",
		\"proveedor\": \"$row_aportaciones[1] - $row_aportaciones[2]\",
		\"proyeccion\": \"$proyeccion\",
		\"aportacion\": \"$aportacion\",
		\"diferencia\": \"$diferencia\",
		\"comprador\": \"$row_aportaciones[5]\"
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