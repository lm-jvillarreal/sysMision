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

$cadena = "SELECT
                      R.MODN_FOLIO,
                      R.MODC_TIPOMOV,
                      RMON_CANTSURTIDA,
                      M .MOVD_FECHAAFECTACION,
                      R.RMON_COSTO_RENGLON_MB,
                      M .MOVN_USUARIOREALIZAMOV,
                      M.MOVC_CVEPROVEEDOR,
                      M.ALMN_ALMACEN,
                      INV_TIPOS_MOVIMIENTO.TMOC_DESCRIPCION
                    FROM
                      INV_RENGLONES_MOVIMIENTOS R
                    INNER JOIN INV_MOVIMIENTOS M ON M .MODN_FOLIO = R.MODN_FOLIO
                    AND M .ALMN_ALMACEN = R.ALMN_ALMACEN
                    AND M.MODC_TIPOMOV = R.MODC_TIPOMOV
                    INNER JOIN INV_TIPOS_MOVIMIENTO ON INV_TIPOS_MOVIMIENTO.TMOC_TIPOMOV = R.MODC_TIPOMOV

                    WHERE (
                      M.MODC_TIPOMOV = 'ENTCOC'
                      OR M.MODC_TIPOMOV = 'ENTSOC'
                      OR M.MODC_TIPOMOV = 'ESCARG'
                    )
                    AND (
                      R.MODC_TIPOMOV = 'ENTCOC'
                      OR R.MODC_TIPOMOV = 'ENTSOC'
                      OR R.MODC_TIPOMOV = 'ESCARG'
                    )

                    AND R.ARTC_ARTICULO = '$codigo'
                    AND
                      M.ALMN_ALMACEN = '$almacen'
                    AND R.ALMN_ALMACEN = '$almacen'

                    AND M.MOVD_FECHAAFECTACION >= TRUNC (
                      TO_DATE ('$fecha_inicial', 'YYYY/MM/DD')
                    )
                    AND M.MOVD_FECHAAFECTACION < TRUNC (
                      TO_DATE ('$fecha_final', 'YYYY/MM/DD')
                    ) + 1";
                    //echo "$cadena";
    $st = oci_parse($conexion_central, $cadena);
    oci_execute($st);


$cuerpo ="";

while ($row_gastos = oci_fetch_array($st)) {
    $valor = $row_gastos[4] / $row_gastos[2];
	$link_detalle = "<center><a href='#' data-id = '$row_gastos[0]' data-toggle = 'modal' data-target = '#modal-default' class='btn btn-danger' target='blank'>$row_gastos[0]</a></center>";
	$renglon = "
		{
    \"s\": \"$row_gastos[7]\",
    \"orden\": \"$row_gastos[0]\",
    \"tipo\": \"$row_gastos[8]\",
    \"fecha\": \"$row_gastos[3]\",
    \"cantidad\": \"$row_gastos[2]\",
    \"costo\": \"$valor\",
    \"importe\": \"$row_gastos[4]\",
    \"proveedor\": \"$row_gastos[6]\",
    \"usuario\": \"$row_gastos[5]\"
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