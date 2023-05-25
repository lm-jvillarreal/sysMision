<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

$folio = $_POST['folio'];
$sucursal=$_POST['sucursal'];

if($sucursal=='1' || empty($sucursal)){
	$conexion_central = $conexion_do;
}elseif($sucursal=='2'){
	$conexion_central = $conexion_arb;
}elseif($sucursal=='3'){
	$conexion_central = $conexion_vill;
}elseif($sucursal=='4'){
	$conexion_central = $conexion_all;
}elseif($sucursal=='5'){
	$conexion_central = $conexion_lp;
}elseif($sucursal=='6'){
	$conexion_central = $conexion_mm;
}

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha = date('d/m/Y');
$hora=date ("h:i:s");

$cadenaFolio = "SELECT IMP.ARTC_ARTICULO, AR.ARTC_DESCRIPCION, imp.iarn_id_importacion,imp.aimn_precio
                FROM PVS_ARTICULOS_IMPORTACION IMP 
                INNER JOIN PVS_ARTICULOS AR ON imp.artc_articulo=AR.ARTC_ARTICULO 
                WHERE IMP.IARN_ID_IMPORTACION = '$folio'";

$consultaFolio = oci_parse($conexion_central, $cadenaFolio);
oci_execute($consultaFolio);

$cuerpo ="";

while ($rowFolio = oci_fetch_row($consultaFolio)) {
  //$baja = "<a href='#' class='btn btn-danger' onclick='baja($rowOfertas[2])'><i class='fa fa-trash-o fa-lg' aria-hidden=true'></i></a>";
	$renglon = "
		{
      \"artc_articulo\":\"$rowFolio[0]\",
      \"artc_descripcion\":\"$rowFolio[1]\",
      \"folio_importacion\":\"$rowFolio[2]\",
      \"precio\":\"$rowFolio[3]\"
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