<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$codigo = $_POST['id'];
$sucursal = $_POST['suc'];

$cadena_ue = "SELECT * FROM (SELECT
detalle.MODN_FOLIO,
TO_CHAR(movs.MOVD_FECHAAFECTACION, 'MM/DD/YYYY'),
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
TO_CHAR(movs.MOVD_FECHAAFECTACION, 'MM/DD/YYYY'),
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

if((!empty($row_etrans[1])) && (empty($row_ue[1]))){
	$fecha_etrans = date_create($row_etrans[1]);
	$fecha_ue = date_create('2000-01-01');
}elseif((empty($row_etrans[1])) && (!empty($row_ue[1]))){
	$fecha_etrans = date_create('2000-01-01');
	$fecha_ue = date_create($row_ue[1]);
}elseif((!empty($row_etrans[1])) && (!empty($row_ue[1]))){
	$fecha_etrans = date_create($row_etrans[1]);
	$fecha_ue = date_create($row_ue[1]);
}elseif((empty($row_etrans[1])) && (empty($row_ue[1]))){
	$fecha_ue = date_create('2000-01-01');
	$fecha_etrans = date_create('2000-01-01');
}
$formato_etrans = date_format($fecha_etrans, 'Y-m-d');
$formato_ue = date_format($fecha_ue, 'Y-m-d');

$folio_ue = str_replace("-","",$formato_ue);
$folio_etrans = str_replace("-","",$formato_etrans);

if($folio_ue>=$folio_etrans){
	$fecha_inicio = $folio_ue;
}elseif($folio_ue<$folio_etrans){
	$fecha_inicio = $folio_etrans;
}
$fecha_fin = str_replace("-","",$fecha);
$cadena_ventas = "SELECT
					SUM( a.ARTN_CANTIDAD_TOTAL) 
					FROM
					pv_vta_diaria_articulo a 
					WHERE
					a.artc_articulo = '$codigo'
					AND ticn_aaaammddventa BETWEEN '$fecha_inicio' AND '$fecha_fin' 
					AND TICC_SUCURSAL = $sucursal";
$st_ventas = oci_parse($conexion_central, $cadena_ventas);
oci_execute($st_ventas);
$row_ventas = oci_fetch_row($st_ventas);
//echo $folio_ue."<br>";
//echo $folio_etrans;
$imprimir = '
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<label>Folio de Entrada:&nbsp;</label>'.$row_ue[0].'<br>
			<label>Fecha de Entrada(mm/dd/aaaa):&nbsp;</label>'.$row_ue[1].'<br>
			<label>Tipo de Movimiento:&nbsp;</label>'.$row_ue[2].'<br>
			<label>Proveedor:&nbsp;</label>'.$row_prov[0].'<br>
			<label>Cantidad Surtida:&nbsp;</label>'.$row_ue[3].'<br>
			<label>Unidad de Medida&nbsp;</label>'.$row_ue[4].'<br>
		</div>
		<div class="col-md-4">
			<label>Folio de Entrada:&nbsp;</label>'.$row_etrans[0].'<br>
			<label>Fecha de Entrada(mm/dd/aaaa):&nbsp;</label>'.$row_etrans[1].'<br>
			<label>Tipo de Movimiento:&nbsp;</label>'.$row_etrans[2].'<br>
			<label>Cantidad Surtida:&nbsp;</label>'.$row_etrans[3].'<br>
			<label>Unidad de Medida&nbsp;</label>'.$row_etrans[4].'<br>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<strong><h4>Unidades Vendidas:&nbsp;'.$row_ventas[0].'</h4></strong><br>
		</div>
	</div>
</div>
';

echo $imprimir;
?>