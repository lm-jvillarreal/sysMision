<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$fi_now = $_POST['fi_now'];
$ff_now = $_POST['ff_now'];
$fi_ago = $_POST['fi_ago'];
$ff_ago = $_POST['ff_ago'];
$fecha_i=str_replace("-","",$fi_now);
$fecha_fin=str_replace("-","",$ff_now);

$fecha_iAgo=str_replace("-","",$fi_ago);
$fecha_finAgo=str_replace("-","",$ff_ago);
$cadena_detalle = "SELECT
                    ARTC_ARTICULO,
                    ARTC_DESCRIPCION,
                    (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
                        AND '$fecha_fin' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '1' 
                    ) AS DO, 
                        (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
                        AND '$fecha_fin' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '2' 
                    ) AS ARB, 
                        (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
                        AND '$fecha_fin' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '3' 
                    ) AS VIL,
                    (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
                        AND '$fecha_fin' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '4' 
                    ) AS ALLE,
                    (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
                        AND '$fecha_fin' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '5' 
                    ) AS PET,
                    (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_i' 
                        AND '$fecha_fin' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '6' 
                    ) AS MM
                    FROM
                    COM_ARTICULOS 
                    WHERE
                    ARTC_FAMILIA BETWEEN 419 
                    AND 423";
//echo $cadena_detalle;
$st = oci_parse($conexion_central, $cadena_detalle);
oci_execute($st);
$v_d = "";
$v_arb = "";
$v_vill = "";
$v_all = "";
$v_pet = "";
$v_mm = "";


while ($row = oci_fetch_row($st)) {
    $v_d = $v_d + $row[2];
    $v_arb = $v_arb + $row[3];
    $v_vill = $v_vill + $row[4];
    $v_all = $v_all + $row[5];
    $v_pet = $v_pet + $row[6];
    $v_mm = $v_mm + $row[7];

}
$total = $v_all + $v_d + $v_vill + $v_arb + $v_pet + $v_mm;


$cadena_detalleAgo = "SELECT
                    ARTC_ARTICULO,
                    ARTC_DESCRIPCION,
                    (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_iAgo' 
                        AND '$fecha_finAgo' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '1' 
                    ) AS DO, 
                        (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_iAgo' 
                        AND '$fecha_finAgo' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '2' 
                    ) AS ARB, 
                        (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0) 
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_iAgo' 
                        AND '$fecha_finAgo' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '3' 
                    ) AS VIL,
                    (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_iAgo' 
                        AND '$fecha_finAgo' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '4' 
                    ) AS ALLE,
                    (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_iAgo' 
                        AND '$fecha_finAgo' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '5' 
                    ) AS PET,
                    (
                    SELECT
                        NVL(SUM( VENTAS.ARTN_VENTA_C_IMPUESTO ),0)
                    FROM
                        PV_VENTAS_REPORTE_VW VENTAS 
                    WHERE
                        VENTAS.TICN_AAAAMMDDVENTA BETWEEN '$fecha_iAgo' 
                        AND '$fecha_finAgo' 
                        AND ARTC_ARTICULO = COM_ARTICULOS.ARTC_ARTICULO 
                        AND TICC_SUCURSAL = '6' 
                    ) AS PET
                    FROM
                    COM_ARTICULOS 
                    WHERE
                    ARTC_FAMILIA BETWEEN 419 
                    AND 423";
//echo $cadena_detalle;
$stAgo = oci_parse($conexion_central, $cadena_detalleAgo);
oci_execute($stAgo);
$v_dAgo = "";
$v_arbAgo = "";
$v_villAgo = "";
$v_allAgo = "";
$v_petAgo = "";
$v_mmAgo = "";

while ($rowAgo = oci_fetch_row($stAgo)) {
    $v_dAgo = $v_dAgo + $rowAgo[2];
    $v_arbAgo = $v_arbAgo + $rowAgo[3];
    $v_villAgo = $v_villAgo + $rowAgo[4];
    $v_allAgo = $v_allAgo + $rowAgo[5];
    $v_petAgo = $v_petAgo + $rowAgo[6];
    $v_mmAgo = $v_mmAgo + $rowAgo[7];
}
$totalAgo = $v_allAgo + $v_dAgo + $v_villAgo + $v_arbAgo + $v_petAgo + $v_mmAgo;

$cuerpo ="";

$renglon = "
	{
		\"do\": \"$v_d\",
		\"arb\": \"$v_arb\",
		\"vill\": \"$v_vill\",
        \"all\": \"$v_all\",
        \"pet\": \"$v_pet\",
        \"mm\": \"$v_mm\",
        \"total\": \"$total\"
    },
    {
		\"do\": \"$v_dAgo\",
		\"arb\": \"$v_arbAgo\",
		\"vill\": \"$v_villAgo\",
        \"all\": \"$v_allAgo\",
        \"pet\": \"$v_petAgo\",
        \"mm\": \"$v_mmAgo\",
        \"total\": \"$totalAgo\"
	}";
    $cuerpo = $renglon;
$tabla = "
["
.$cuerpo.
"]
";
//echo $cadena_cartas;
echo $tabla;
?>