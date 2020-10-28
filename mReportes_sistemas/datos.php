<?php
include '../global_settings/conexion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha = date("Y-m-d");
$hora  = date ("h:i:s");

$fecha_inicial = $_POST['fecha1'];
$fecha_final   = $_POST['fecha2'];

$fecha_i = str_replace("-","",$fecha_inicial);
$fecha_f = str_replace("-","",$fecha_final);

$anio = '2018';
$json = [];

$cadena = "SELECT ARTC_ARTICULO,ARTC_DESCRIPCION,
                (
            SELECT NVL(SUM( DETALLE.ARTN_CANTIDAD ),0) 
            FROM PV_ARTICULOSTICKET detalle
                INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
                AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
            WHERE DETALLE.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
                AND '$fecha_f' 
                AND TIK.TICC_SUCURSAL = '1' 
                AND DETALLE.TICC_SUCURSAL = '1' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_do,
                (
            SELECT NVL(SUM( DETALLE.ARTN_CANTIDAD ),0)
            FROM PV_ARTICULOSTICKET detalle
                INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
                AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
            WHERE DETALLE.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
                AND '$fecha_f' 
                AND TIK.TICC_SUCURSAL = '2' 
                AND DETALLE.TICC_SUCURSAL = '2' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_arb,
                (
            SELECT NVL(SUM( DETALLE.ARTN_CANTIDAD ),0) 
            FROM PV_ARTICULOSTICKET detalle
                INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
                AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
            WHERE DETALLE.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
                AND '$fecha_f' 
                AND TIK.TICC_SUCURSAL = '3' 
                AND DETALLE.TICC_SUCURSAL = '3' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_vil,
                (
            SELECT NVL(SUM( DETALLE.ARTN_CANTIDAD ) ,0)
            FROM PV_ARTICULOSTICKET detalle
                INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
                AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
            WHERE DETALLE.ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
                AND '$fecha_f' 
                AND TIK.TICC_SUCURSAL = '4' 
                AND DETALLE.TICC_SUCURSAL = '4' 
                AND TIK.TICN_ESTATUS = 3 
                ) AS ventas_all 
            FROM COM_ARTICULOS 
            WHERE ARTC_ARTICULO BETWEEN '9000' 
                AND '9052' 
                AND ARTC_DESCRIPCION LIKE '%RECARGA%'
                AND ARTC_ARTICULO != '9028'
                AND ARTC_ARTICULO != '9029'
                AND ARTC_ARTICULO != '9030'
                AND ARTC_ARTICULO != '9031'
                AND ARTC_ARTICULO != '9032'
                AND ARTC_ARTICULO != '9033'
                AND ARTC_ARTICULO != '9034'
                AND ARTC_ARTICULO != '9035'
            ORDER BY ARTC_ARTICULO";
$st = oci_parse($conexion_central, $cadena);
oci_execute($st);

$cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
    $total = $row_gastos[2] + $row_gastos[3] + $row_gastos[4] + $row_gastos[5];
    if($total != 0){
        $json[] = [(string)$row_gastos[1], (int)$total];
        // echo 'Descripcion:'.$row_gastos[1].' Total:'.$total.'<br>';
    }    
}    
    echo json_encode($json);
?>