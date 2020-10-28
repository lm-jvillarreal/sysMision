<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
$fecha_inicial = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
// $codigo = $_POST['codigo'];
// $almacen = $_POST['sucursal'];
$fecha_i=str_replace("-","",$fecha_inicial);
$fecha_f=str_replace("-","",$fecha_final);
//$anio = date("Y");
$anio = '2018';

$cadena = "SELECT
                ARTC_ARTICULO,
                ARTC_DESCRIPCION,
                (
            SELECT
                NVL(SUM( DETALLE.ARTN_CANTIDAD ),0) 
            FROM
                PV_ARTICULOSTICKET detalle
                INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
                AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
            WHERE
                DETALLE.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
                AND '$fecha_f' 
                AND TIK.TICC_SUCURSAL = '1' 
                AND DETALLE.TICC_SUCURSAL = '1' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_do,
                (
            SELECT
                NVL(SUM( DETALLE.ARTN_CANTIDAD ),0)
            FROM
                PV_ARTICULOSTICKET detalle
                INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
                AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
            WHERE
                DETALLE.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
                AND '$fecha_f' 
                AND TIK.TICC_SUCURSAL = '2' 
                AND DETALLE.TICC_SUCURSAL = '2' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_arb,
                (
            SELECT
                NVL(SUM( DETALLE.ARTN_CANTIDAD ),0) 
            FROM
                PV_ARTICULOSTICKET detalle
                INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
                AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
            WHERE
                DETALLE.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
                AND '$fecha_f' 
                AND TIK.TICC_SUCURSAL = '3' 
                AND DETALLE.TICC_SUCURSAL = '3' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_vil,
                (
            SELECT
                NVL(SUM( DETALLE.ARTN_CANTIDAD ) ,0)
            FROM
                PV_ARTICULOSTICKET detalle
                INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
                AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
            WHERE
                DETALLE.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
                AND '$fecha_f' 
                AND TIK.TICC_SUCURSAL = '4' 
                AND DETALLE.TICC_SUCURSAL = '4' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_all 
            FROM
                COM_ARTICULOS 
            WHERE
                (
                ARTC_ARTICULO = '9028' 
                OR ARTC_ARTICULO = '9029' 
                OR ARTC_ARTICULO = '9030' 
                OR ARTC_ARTICULO = '9031' 
                OR ARTC_ARTICULO = '9032' 
                OR ARTC_ARTICULO = '9033' 
                OR ARTC_ARTICULO = '9034' 
                OR ARTC_ARTICULO = '9035' 
                ) 
            ORDER BY
                ARTC_ARTICULO";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);


$cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
    $cantidad = "<input type='text' class='form-control' name='cantidad[]' value='0'>";	
    $codigo = "<input type='text' class='form-control' name='codigo[]' value='$row_gastos[0]' readonly>";
    $descripcion = "<input type='text' class='form-control' name='descripcion[]' value='$row_gastos[1]' readonly>";
    $do = "<input style='width:100%' type='text' class='form-control' name='c_do[]' value='$row_gastos[2]' readonly>";
    $arb = "<input style='width:100%' type='text' class='form-control' name='c_arb[]' value='$row_gastos[3]' readonly>";
    $vil = "<input style='width:100%' type='text' class='form-control' name='c_vil[]' value='$row_gastos[4]' readonly>";
    $all = "<input style='width:100%' type='text' class='form-control' name='c_all[]' value='$row_gastos[5]' readonly>";
    $total = $row_gastos[2] + $row_gastos[3] + $row_gastos[4] + $row_gastos[5];
    $total_i = "<input type='text' class='form-control' name='c_total[]' value='$total' readonly>";
    
    $renglon = "
		{
		\"codigo\": \"$codigo\",
		\"descripcion\": \"$descripcion\",
		\"do\": \"$do\",
		\"arb\": \"$arb\",
		\"vil\": \"$vil\",
        \"all\": \"$all\",
        \"total\": \"$total_i\",
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
echo $tabla;
?>