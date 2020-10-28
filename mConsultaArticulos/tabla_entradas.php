<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
		
$codigo = $_POST['codigo'];
$qry = "SELECT
				CASE
				WHEN INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = 1 THEN
				'Diaz Ordaz'
				WHEN INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = 2 THEN
				'Arboledas'
				WHEN INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = 3 THEN
				'Villegas'
				WHEN INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = 4 THEN
				'Allende'
				WHEN INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = 5 THEN
				'La Petaca'
				WHEN INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN = 99 THEN
				'CEDIS'
				END,
				INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV,
				INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO,
				RMON_CANTSURTIDA,
				ROUND(RMON_COSTO_RENGLON_MB,2),
				(
				RMON_COSTO_RENGLON_MB / RMON_CANTSURTIDA
				),
				TO_CHAR( INV_MOVIMIENTOS.MOVD_FECHAAFECTACION, 'YYYY-MM-DD'),
				CXP_PROVEEDORES.PROC_NOMBRE
				FROM
				INV_RENGLONES_MOVIMIENTOS
				INNER JOIN INV_MOVIMIENTOS ON INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
				AND INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
				AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
				INNER JOIN CXP_PROVEEDORES ON TRIM (
				CXP_PROVEEDORES.PROC_CVEPROVEEDOR
				) = TRIM (
				INV_MOVIMIENTOS.MOVC_CVEPROVEEDOR
				)
				WHERE
				ARTC_ARTICULO = '$codigo'
				AND (
				INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTSOC'
				OR INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV = 'ENTCOC'
				)
				ORDER BY
				INV_MOVIMIENTOS.MOVD_FECHAAFECTACION,
				INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN";
$st_detalle = oci_parse($conexion_central, $qry);
oci_execute($st_detalle);
$cuerpo="";
while($row=oci_fetch_row($st_detalle)){
	$renglon = "
	{
		\"fecha\": \"$row[6]\",
		\"tipo_mov\": \"$row[1]\",
		\"folio\": \"$row[2]\",
		\"pu\": \"$row[5]\",
		\"cant\": \"$row[3]\",
		\"total\": \"$row[4]\",
		\"sucursal\": \"$row[0]\",
		\"proveedor\": \"$row[7]\"
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