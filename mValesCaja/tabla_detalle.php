<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

$prefijo = $_POST['prefijo'];
$consecutivo = $_POST['consecutivo'];

if($id_sede=='1'){
	$conexion_central = $conexion_do;
}elseif($id_sede=='2'){
	$conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
	$conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
	$conexion_central = $conexion_all;
}elseif($id_sede=='5'){
  $conexion_central=$conexion_lp;
}elseif($id_sede=='6'){
  $conexion_central=$conexion_mm;
}

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");

$cadena_consulta = "SELECT 
                      ARTC_ARTICULO, 
                      (SELECT ARTC_DESCRIPCION FROM PVS_ARTICULOS WHERE ARTC_ARTICULO=A.ARTC_ARTICULO) DESCRIPCION ,
                      ARTN_CANTIDAD, 
                      TO_CHAR(ROUND((ARTN_PRECIOVENTA + (ARTN_MONTO_IMPUESTOS/ARTN_CANTIDAD)),2),'9999D99') PRECIO,
                      TO_CHAR(ROUND((ARTN_PRECIOVENTA *ARTN_CANTIDAD) + ARTN_MONTO_IMPUESTOS,2),'9999D99') TOTAL
                    FROM PVS_ARTICULOSTICKET A
                    WHERE ticn_aaaammddventa='$prefijo'
                    AND ticn_folio='$consecutivo'";
$consulta_ticket = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_ticket);

$cuerpo ="";
while ($row = oci_fetch_row($consulta_ticket)) {
  $artc_descripcion=mysqli_real_escape_string($conexion,$row[1]);
  $link="<center><a href='#' data-prefijo = '$prefijo' data-consecutivo='$consecutivo' data-articulo='$row[0]' data-cantidad='$row[2]' data-toggle = 'modal' data-target = '#modal-cambio' class='btn btn-success btn-sm' target='blank'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></center>";
	$renglon = "
	{
		\"artc_articulo\": \"$row[0]\",
		\"artc_descripcion\": \"$artc_descripcion\",
    \"artc_cantidad\": \"$row[2]\",
    \"precio\": \"$row[3]\",
    \"total\": \"$row[4]\",
    \"opciones\": \"$link\"
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