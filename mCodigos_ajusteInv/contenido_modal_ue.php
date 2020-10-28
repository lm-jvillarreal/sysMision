<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$codigo = $_POST['id'];
$sucursal = $_POST['suc'];

$cadena_ue = "SELECT * FROM (SELECT
detalle.MODN_FOLIO,
TO_CHAR(movs.MOVD_FECHAAFECTACION, 'DD/MM/YYYY'),
detalle.modc_tipomov,
detalle.RMON_CANTSURTIDA,
detalle.RMOC_UNIMEDIDA,
movs.MOVC_CVEPROVEEDOR
FROM
INV_RENGLONES_MOVIMIENTOS detalle
INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
WHERE
ARTC_ARTICULO = '$codigo' 
AND movs.ALMN_ALMACEN = '$sucursal' 
AND detalle.ALMN_ALMACEN = '$sucursal' 
AND movs.MOVD_FECHAAFECTACION IS NOT NULL
AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC')
ORDER BY
movs.MOVD_FECHAAFECTACION DESC)
WHERE ROWNUM <=1";

$st = oci_parse($conexion_central, $cadena_ue);
oci_execute($st);
$row_ue = oci_fetch_row($st);

$cadena_etrans = "
SELECT * FROM (SELECT
detalle.MODN_FOLIO,
TO_CHAR(movs.MOVD_FECHAAFECTACION, 'DD/MM/YYYY'),
detalle.modc_tipomov,
detalle.RMON_CANTSURTIDA,
detalle.RMOC_UNIMEDIDA,
movs.MOVC_CVEPROVEEDOR
FROM
INV_RENGLONES_MOVIMIENTOS detalle
INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
WHERE
ARTC_ARTICULO = '$codigo' 
AND movs.ALMN_ALMACEN = '$sucursal' 
AND detalle.ALMN_ALMACEN = '$sucursal'
AND movs.MOVD_FECHAAFECTACION IS NOT NULL
AND  detalle.MODC_TIPOMOV = 'ETRANS'
ORDER BY
movs.MOVD_FECHAAFECTACION DESC)
WHERE ROWNUM <=1
";

$st_etrans = oci_parse($conexion_central, $cadena_etrans);
oci_execute($st_etrans);
$row_etrans = oci_fetch_row($st_etrans);

$cadena_prov = "SELECT CONCAT(PROC_CVEPROVEEDOR,PROC_NOMBRE) FROM cxp_proveedores WHERE PROC_CVEPROVEEDOR = '$row_ue[5]'";
$st_proveedores = oci_parse($conexion_central, $cadena_prov);
oci_execute($st_proveedores);
$row_prov = oci_fetch_row($st_proveedores);

$imprimir = '
<div class="container">
	<div class="col-md-4">
		<label>Folio de Entrada:&nbsp;</label>'.$row_ue[0].'<br>
		<label>Fecha de Entrada:&nbsp;</label>'.$row_ue[1].'<br>
		<label>Tipo de Movimiento:&nbsp;</label>'.$row_ue[2].'<br>
		<label>Proveedor:&nbsp;</label>'.$row_prov[0].'<br>
		<label>Cantidad Surtida:&nbsp;</label>'.$row_ue[3].'<br>
		<label>Unidad de Medida&nbsp;</label>'.$row_ue[4].'<br>
	</div>
	<div class="col-md-5">
		<label>Folio de Entrada:&nbsp;</label>'.$row_etrans[0].'<br>
		<label>Fecha de Entrada:&nbsp;</label>'.$row_etrans[1].'<br>
		<label>Tipo de Movimiento:&nbsp;</label>'.$row_etrans[2].'<br>
		<label>Cantidad Surtida:&nbsp;</label>'.$row_etrans[3].'<br>
		<label>Unidad de Medida&nbsp;</label>'.$row_etrans[4].'<br>
	</div>
</div>
';

echo $imprimir;
?>