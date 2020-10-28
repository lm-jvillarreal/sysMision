<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
$codigo = $_POST['codigo'];
$almacen = $_POST['sucursal'];
//$anio = date("Y");
$anio = '2018';

    $cadena="SELECT t.tran_id_consecutivo, t.almn_almacen, t.tran_folio_salida, t.tran_almacen_destino, TO_CHAR(t.trad_fecha_aut_salida,'YYYY/MM/DD'), r.rtrn_cantidad_salida 
            FROM INV_TRANSFERENCIAS T INNER JOIN INV_RENGLONES_TRANSFERENCIA R ON t.tran_id_consecutivo=r.tran_id_consecutivo
            WHERE almn_almacen='$almacen' 
            AND modc_tipomov='STRANS'
            AND t.trad_fecha_aut_salida>= TRUNC(TO_DATE('$fecha_inicial', 'YYYY/MM/DD'))
            AND t.trad_fecha_aut_salida < TRUNC(TO_DATE('$fecha_final', 'YYYY/MM/DD') ) + 1
            AND R.ARTC_ARTICULO='$codigo'";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);


$cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
	$renglon = "
		{
		\"consecutivo\": \"$row_gastos[0]\",
		\"almacen\": \"$row_gastos[1]\",
        \"folio_salida\": \"$row_gastos[2]\",
        \"destino\": \"$row_gastos[3]\",
        \"cantidad\": \"$row_gastos[5]\",
        \"fecha\": \"$row_gastos[4]\"
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