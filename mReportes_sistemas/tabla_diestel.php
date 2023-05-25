<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';
error_reporting(0);

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
                ) AS ventas_all,
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
                AND TIK.TICC_SUCURSAL = '5' 
                AND DETALLE.TICC_SUCURSAL = '5' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_pet
            FROM
                COM_ARTICULOS 
            WHERE
                ARTC_ARTICULO BETWEEN '9000' 
                AND '9085' 
                AND ARTC_DESCRIPCION LIKE '%RECARGA%'
                AND ARTC_ARTICULO != '9028'
                AND ARTC_ARTICULO != '9029'
                AND ARTC_ARTICULO != '9030'
                AND ARTC_ARTICULO != '9031'
                AND ARTC_ARTICULO != '9032'
                AND ARTC_ARTICULO != '9033'
                AND ARTC_ARTICULO != '9034'
                AND ARTC_ARTICULO != '9035'
            ORDER BY
                ARTC_ARTICULO";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);


$cuerpo ="";
$numero = 0;

while ($row_gastos = oci_fetch_array($st)) {
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
    $cantidad = "<input id='cap$numero' type='text' class='form-control' name='cantidad[]' value='0' size='5' onchange='diferencia($numero)'>"; 
    $codigo = "<span>$row_gastos[0]</span><input type='hidden' class='form-control' name='codigo[]' value='$row_gastos[0]' readonly size='5'>";
    $descripcion = "<span>$row_gastos[1]</span><input type='hidden' class='form-control' name='descripcion[]' value='$row_gastos[1]' readonly>";
    $do = "<span>$row_gastos[2]</span><input type='hidden' class='form-control' name='c_do[]' value='$row_gastos[2]' readonly size='5'>";
    $arb = "<span>$row_gastos[3]</span><input type='hidden' class='form-control' name='c_arb[]' value='$row_gastos[3]' readonly size='5'>";
    $vil = "<span>$row_gastos[4]</span><input type='hidden' class='form-control' name='c_vil[]' value='$row_gastos[4]' readonly size='5'>";
    $all = "<span>$row_gastos[5]</span><input type='hidden' class='form-control' name='c_all[]' value='$row_gastos[5]' readonly size='5'>";
    $pet = "<span>$row_gastos[6]</span><input type='hidden' class='form-control' name='c_petaca[]' value='$row_gastos[6]' readonly size='5'>";
    $total = $row_gastos[2] + $row_gastos[3] + $row_gastos[4] + $row_gastos[5] + $row_gastos[6];
    $total_i = "<a class='btn btn-warning btn-sm' onclick='copiar($numero)'>$total</a><input type='hidden' id='total$numero' class='form-control' name='c_total[]' value='$total' readonly size='5'>";
    $dif = "<span id='dif$numero'>0</span><input type='hidden' id='dif1$numero' class='form-control' name='c_diff[]' value='0' readonly size='5'>";
    
    if ($total != 0){
        $renglon = "
            {
            \"codigo\": \"$codigo\",
            \"descripcion\": \"$descripcion\",
            \"do\": \"$do\",
            \"arb\": \"$arb\",
            \"vil\": \"$vil\",
            \"all\": \"$all\",
            \"pet\": \"$pet\",
            \"total\": \"$total_i\",
            \"cantidad\": \"$cantidad\",
            \"dif\": \"$dif\"
            },";
        $cuerpo = $cuerpo.$renglon;
    }
    $numero ++;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>