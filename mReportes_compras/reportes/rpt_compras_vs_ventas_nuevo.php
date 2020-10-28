<?php 
include("../../global_settings/conexion_oracle.php");
error_reporting(E_ALL ^ E_NOTICE);
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$fecha_inicio = $_POST['fecha_inicial'];
$fecha_final = $_POST['fecha_final'];
//$tipo = $_POST['tipo'];
$sucursal = $_POST['sucursal'];
$proveedor = $_POST['proveedor'];
$proveedor = trim($proveedor);
$codigo = $_POST['codigo'];
$depto = $_POST['departamento'];
$fecha_i=str_replace("-","",$fecha_inicio);
$fecha_fin=str_replace("-","",$fecha_final);
$array = $_POST['array'];
$arra = explode(',', $array);



	$cantidad = count($arra);
	for ($i=1; $i < $cantidad; $i++) { 
		$consulta = " OR PRECIOS.ARTC_ARTICULO = '$arra[$i]'";
		$or = $or . $consulta;
	}	
	$where = " WHERE (PRECIOS.ARTC_ARTICULO = '$arra[0]'".$or.")";


if ($codigo == "") {
	$filtro_codigo = "";
}else{
	$filtro_codigo = "AND R.ARTC_ARTICULO = '$codigo'";
}
if ($depto == "") {
	$filtro_departamento = "";
}else{
	$filtro_departamento = "AND f.FAMC_FAMILIAPADRE = '$depto'";
}

// if ($proveedor == "") {
// 	$consulta_principal = "SELECT
// 	PRECIOS.ARTC_ARTICULO,
// 	PRECIOS.ARTC_DESCRIPCION,
// 	( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, PRECIOS.ARTC_ARTICULO ) FROM dual ) AS ExistenciaDiazOrdaz,
// 	( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, PRECIOS.ARTC_ARTICULO ) FROM dual ) AS ExistenciasArboledas,
// 	( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, PRECIOS.ARTC_ARTICULO ) FROM dual ) AS ExistenciasVillegas,
// 	( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, PRECIOS.ARTC_ARTICULO ) FROM dual ) AS ExistenciasAllende,
// --fin del bloque de existencias
// 	(
// SELECT
// 	SUM( R.RMON_CANTSURTIDA ) 
// FROM
// 	INV_RENGLONES_MOVIMIENTOS R
// 	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
// 	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
// 	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
// 	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
// 	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
// WHERE
// 	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND MOV.MOVD_FECHAAFECTACION >= trunc(
// 	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
// 	AND MOV.MOVD_FECHAAFECTACION < trunc(
// 	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
// 	AND r.ALMN_ALMACEN = '1' 
// 	AND MOV.ALMN_ALMACEN = '1' 
// 	AND INV.ALMN_ALMACEN = '1' 
// 	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	) AS cantidad_surtida_do,
// 	(
// SELECT
// 	SUM(
// 	ROUND( R.RMON_COSTO_RENGLON_MB, 2 )) 
// FROM
// 	INV_RENGLONES_MOVIMIENTOS R
// 	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
// 	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
// 	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
// 	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
// 	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
// WHERE
// 	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND MOV.MOVD_FECHAAFECTACION >= trunc(
// 	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
// 	AND MOV.MOVD_FECHAAFECTACION < trunc(
// 	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
// 	AND r.ALMN_ALMACEN = '1' 
// 	AND MOV.ALMN_ALMACEN = '1' 
// 	AND INV.ALMN_ALMACEN = '1' 
// 	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	) AS costo_cantidad_surtida_do,
// --Fin del bloque de diaz ordaz
// 	(
// SELECT
// 	SUM( R.RMON_CANTSURTIDA ) 
// FROM
// 	INV_RENGLONES_MOVIMIENTOS R
// 	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
// 	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
// 	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
// 	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
// 	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
// WHERE
// 	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND MOV.MOVD_FECHAAFECTACION >= trunc(
// 	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
// 	AND MOV.MOVD_FECHAAFECTACION < trunc(
// 	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
// 	AND r.ALMN_ALMACEN = '2' 
// 	AND MOV.ALMN_ALMACEN = '2' 
// 	AND INV.ALMN_ALMACEN = '2' 
// 	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	) AS cantidad_surtida_arb,
// 	(
// SELECT
// 	SUM(
// 	ROUND( R.RMON_COSTO_RENGLON_MB, 2 )) 
// FROM
// 	INV_RENGLONES_MOVIMIENTOS R
// 	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
// 	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
// 	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
// 	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
// 	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
// WHERE
// 	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND MOV.MOVD_FECHAAFECTACION >= trunc(
// 	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
// 	AND MOV.MOVD_FECHAAFECTACION < trunc(
// 	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
// 	AND r.ALMN_ALMACEN = '2' 
// 	AND MOV.ALMN_ALMACEN = '2' 
// 	AND INV.ALMN_ALMACEN = '2' 
// 	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	) AS costo_cantidad_surtida_arb,
// --fin bloque arboledas
// 	(
// SELECT
// 	SUM( R.RMON_CANTSURTIDA ) 
// FROM
// 	INV_RENGLONES_MOVIMIENTOS R
// 	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
// 	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
// 	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
// 	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
// 	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
// WHERE
// 	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND MOV.MOVD_FECHAAFECTACION >= trunc(
// 	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
// 	AND MOV.MOVD_FECHAAFECTACION < trunc(
// 	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
// 	AND r.ALMN_ALMACEN = '3' 
// 	AND MOV.ALMN_ALMACEN = '3' 
// 	AND INV.ALMN_ALMACEN = '3' 
// 	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	) AS cantidad_surtida_vill,
// 	(
// SELECT
// 	SUM(
// 	ROUND( R.RMON_COSTO_RENGLON_MB, 2 )) 
// FROM
// 	INV_RENGLONES_MOVIMIENTOS R
// 	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
// 	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
// 	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
// 	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
// 	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
// WHERE
// 	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND MOV.MOVD_FECHAAFECTACION >= trunc(
// 	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
// 	AND MOV.MOVD_FECHAAFECTACION < trunc(
// 	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
// 	AND r.ALMN_ALMACEN = '3' 
// 	AND MOV.ALMN_ALMACEN = '3' 
// 	AND INV.ALMN_ALMACEN = '3' 
// 	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	) AS costo_cantidad_surtida_vill,
// --Fin bloque villegas,
// 	(
// SELECT
// 	SUM( R.RMON_CANTSURTIDA ) 
// FROM
// 	INV_RENGLONES_MOVIMIENTOS R
// 	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
// 	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
// 	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
// 	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
// 	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
// WHERE
// 	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND MOV.MOVD_FECHAAFECTACION >= trunc(
// 	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
// 	AND MOV.MOVD_FECHAAFECTACION < trunc(
// 	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
// 	AND r.ALMN_ALMACEN = '4' 
// 	AND MOV.ALMN_ALMACEN = '4' 
// 	AND INV.ALMN_ALMACEN = '4' 
// 	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	) AS cantidad_surtida_all,
// 	(
// SELECT
// 	SUM(
// 	ROUND( R.RMON_COSTO_RENGLON_MB, 2 )) 
// FROM
// 	INV_RENGLONES_MOVIMIENTOS R
// 	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
// 	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
// 	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
// 	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
// 	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
// WHERE
// 	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
// 	AND MOV.MOVD_FECHAAFECTACION >= trunc(
// 	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
// 	AND MOV.MOVD_FECHAAFECTACION < trunc(
// 	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
// 	AND r.ALMN_ALMACEN = '4' 
// 	AND MOV.ALMN_ALMACEN = '4' 
// 	AND INV.ALMN_ALMACEN = '4' 
// 	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	) AS costo_cantidad_surtida_all, --Fin bloque allende,
	
// 	--inicio bloque ventas diaz ordaz
// 	(
// 	SELECT
// 	SUM( DETALLE.ARTN_CANTIDAD )
// 	FROM
// 	PV_ARTICULOSTICKET detalle
// 	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
// 	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
// WHERE
// 	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
// 	AND '$fecha_fin' 
// 	AND TIK.TICC_SUCURSAL = '1' 
// 	AND DETALLE.TICC_SUCURSAL = '1' 
// 	AND TIK.TICN_ESTATUS = 3
// 	) AS cantidad_vendida_do,
// 	(
// 	SELECT
// 	SUM(
// 	ROUND( detalle.ARTN_CANTIDAD * detalle.ARTN_PRECIOVENTA, 2 )) 
// FROM
// 	PV_ARTICULOSTICKET detalle
// 	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
// 	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
// WHERE
// 	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO  
// 	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
// 	AND '$fecha_fin' 
// 	AND TIK.TICC_SUCURSAL = '1' 
// 	AND DETALLE.TICC_SUCURSAL = '1' 
// 	AND TIK.TICN_ESTATUS = 3
// 	)AS importe_cantidad_vendida,
	
// 	--Fin bloque ventas diaz ordaz
// 				--inicio bloque ventas arboledas
// 	(
// 	SELECT
// 	SUM( DETALLE.ARTN_CANTIDAD )
// 	FROM
// 	PV_ARTICULOSTICKET detalle
// 	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
// 	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
// WHERE
// 	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
// 	AND '$fecha_fin' 
// 	AND TIK.TICC_SUCURSAL = '2' 
// 	AND DETALLE.TICC_SUCURSAL = '2' 
// 	AND TIK.TICN_ESTATUS = 3
// 	) AS cantidad_vendida_arb,
// 	(
// 	SELECT
// 	SUM(
// 	ROUND( detalle.ARTN_CANTIDAD * detalle.ARTN_PRECIOVENTA, 2 )) 
// FROM
// 	PV_ARTICULOSTICKET detalle
// 	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
// 	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
// WHERE
// 	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO  
// 	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
// 	AND '$fecha_fin' 
// 	AND TIK.TICC_SUCURSAL = '2' 
// 	AND DETALLE.TICC_SUCURSAL = '2' 
// 	AND TIK.TICN_ESTATUS = 3
// 	)AS importe_cantidad_vendida_arb,
	
// 	--Fin bloque ventas arboledas
	
// 		--inicio bloque ventas villegas
// 	(
// 	SELECT
// 	SUM( DETALLE.ARTN_CANTIDAD )
// 	FROM
// 	PV_ARTICULOSTICKET detalle
// 	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
// 	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
// WHERE
// 	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
// 	AND '$fecha_fin' 
// 	AND TIK.TICC_SUCURSAL = '3' 
// 	AND DETALLE.TICC_SUCURSAL = '3' 
// 	AND TIK.TICN_ESTATUS = 3
// 	) AS cantidad_vendida_villegas,
// 	(
// 	SELECT
// 	SUM(
// 	ROUND( detalle.ARTN_CANTIDAD * detalle.ARTN_PRECIOVENTA, 2 )) 
// FROM
// 	PV_ARTICULOSTICKET detalle
// 	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
// 	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
// WHERE
// 	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO  
// 	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
// 	AND '$fecha_fin' 
// 	AND TIK.TICC_SUCURSAL = '3' 
// 	AND DETALLE.TICC_SUCURSAL = '3' 
// 	AND TIK.TICN_ESTATUS = 3
// 	)AS importe_cantidad_vendida_v,
		
// 	--Fin bloque ventas villegas
// 			--inicio bloque ventas allende
// 	(
// 	SELECT
// 	SUM( DETALLE.ARTN_CANTIDAD )
// 	FROM
// 	PV_ARTICULOSTICKET detalle
// 	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
// 	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
// WHERE
// 	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
// 	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
// 	AND '$fecha_fin' 
// 	AND TIK.TICC_SUCURSAL = '4' 
// 	AND DETALLE.TICC_SUCURSAL = '4' 
// 	AND TIK.TICN_ESTATUS = 3
// 	) AS cantidad_vendida_allende,
// 	(
// 	SELECT
// 	SUM(
// 	ROUND( detalle.ARTN_CANTIDAD * detalle.ARTN_PRECIOVENTA, 2 )) 
// FROM
// 	PV_ARTICULOSTICKET detalle
// 	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
// 	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
// WHERE
// 	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO  
// 	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
// 	AND '$fecha_fin' 
// 	AND TIK.TICC_SUCURSAL = '4' 
// 	AND DETALLE.TICC_SUCURSAL = '4' 
// 	AND TIK.TICN_ESTATUS = 3
// 	)AS importe_cantidad_vendida_al
// 	FROM
// 	PV_ARTICULOS PRECIOS
	
// 	--Fin bloque ventas allende".$where;
//}else{
	$consulta_principal  = "SELECT
	PRECIOS.ARTC_ARTICULO,
	PRECIOS.ARTC_DESCRIPCION,
	( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, PRECIOS.ARTC_ARTICULO ) FROM dual ) AS ExistenciaDiazOrdaz,
	( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, PRECIOS.ARTC_ARTICULO ) FROM dual ) AS ExistenciasArboledas,
	( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, PRECIOS.ARTC_ARTICULO ) FROM dual ) AS ExistenciasVillegas,
	( SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, PRECIOS.ARTC_ARTICULO ) FROM dual ) AS ExistenciasAllende,
--fin del bloque de existencias
	(
SELECT
	SUM( R.RMON_CANTSURTIDA ) 
FROM
	INV_RENGLONES_MOVIMIENTOS R
	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
WHERE
	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
	AND MOV.MOVD_FECHAAFECTACION >= trunc(
	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
	AND MOV.MOVD_FECHAAFECTACION < trunc(
	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
	AND r.ALMN_ALMACEN = '1' 
	AND MOV.ALMN_ALMACEN = '1' 
	AND INV.ALMN_ALMACEN = '1' 
	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	) AS cantidad_surtida_do,
	(
SELECT
	SUM(
	ROUND( R.RMON_COSTO_RENGLON_MB, 2 )) 
FROM
	INV_RENGLONES_MOVIMIENTOS R
	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
WHERE
	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
	AND MOV.MOVD_FECHAAFECTACION >= trunc(
	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
	AND MOV.MOVD_FECHAAFECTACION < trunc(
	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
	AND r.ALMN_ALMACEN = '1' 
	AND MOV.ALMN_ALMACEN = '1' 
	AND INV.ALMN_ALMACEN = '1' 
	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	) AS costo_cantidad_surtida_do,
--Fin del bloque de diaz ordaz
	(
SELECT
	SUM( R.RMON_CANTSURTIDA ) 
FROM
	INV_RENGLONES_MOVIMIENTOS R
	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
WHERE
	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
	AND MOV.MOVD_FECHAAFECTACION >= trunc(
	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
	AND MOV.MOVD_FECHAAFECTACION < trunc(
	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
	AND r.ALMN_ALMACEN = '2' 
	AND MOV.ALMN_ALMACEN = '2' 
	AND INV.ALMN_ALMACEN = '2' 
	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	) AS cantidad_surtida_arb,
	(
SELECT
	SUM(
	ROUND( R.RMON_COSTO_RENGLON_MB, 2 )) 
FROM
	INV_RENGLONES_MOVIMIENTOS R
	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
WHERE
	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
	AND MOV.MOVD_FECHAAFECTACION >= trunc(
	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
	AND MOV.MOVD_FECHAAFECTACION < trunc(
	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
	AND r.ALMN_ALMACEN = '2' 
	AND MOV.ALMN_ALMACEN = '2' 
	AND INV.ALMN_ALMACEN = '2' 
	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	) AS costo_cantidad_surtida_arb,
--fin bloque arboledas
	(
SELECT
	SUM( R.RMON_CANTSURTIDA ) 
FROM
	INV_RENGLONES_MOVIMIENTOS R
	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
WHERE
	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
	AND MOV.MOVD_FECHAAFECTACION >= trunc(
	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
	AND MOV.MOVD_FECHAAFECTACION < trunc(
	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
	AND r.ALMN_ALMACEN = '3' 
	AND MOV.ALMN_ALMACEN = '3' 
	AND INV.ALMN_ALMACEN = '3' 
	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	) AS cantidad_surtida_vill,
	(
SELECT
	SUM(
	ROUND( R.RMON_COSTO_RENGLON_MB, 2 )) 
FROM
	INV_RENGLONES_MOVIMIENTOS R
	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
WHERE
	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
	AND MOV.MOVD_FECHAAFECTACION >= trunc(
	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
	AND MOV.MOVD_FECHAAFECTACION < trunc(
	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
	AND r.ALMN_ALMACEN = '3' 
	AND MOV.ALMN_ALMACEN = '3' 
	AND INV.ALMN_ALMACEN = '3' 
	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	) AS costo_cantidad_surtida_vill,
--Fin bloque villegas,
	(
SELECT
	SUM( R.RMON_CANTSURTIDA ) 
FROM
	INV_RENGLONES_MOVIMIENTOS R
	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
WHERE
	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
	AND MOV.MOVD_FECHAAFECTACION >= trunc(
	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
	AND MOV.MOVD_FECHAAFECTACION < trunc(
	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
	AND r.ALMN_ALMACEN = '4' 
	AND MOV.ALMN_ALMACEN = '4' 
	AND INV.ALMN_ALMACEN = '4' 
	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	) AS cantidad_surtida_all,
	(
SELECT
	SUM(
	ROUND( R.RMON_COSTO_RENGLON_MB, 2 )) 
FROM
	INV_RENGLONES_MOVIMIENTOS R
	INNER JOIN INV_MOVIMIENTOS MOV ON MOV.MODN_FOLIO = R.MODN_FOLIO
	INNER JOIN INV_REP_MAR_ESP_COMPRA_VW inv ON INV.ENTN_ENTRADA = R.MODN_FOLIO 
	AND inv.ARTC_ARTICULO = R.ARTC_ARTICULO 
	AND inv.PROC_CVEPROVEEDOR = MOV.MOVC_CVEPROVEEDOR
	INNER JOIN COM_FAMILIAS f ON f.FAMC_FAMILIA = INV.ARTC_FAMILIA 
WHERE
	( R.MODC_TIPOMOV = 'ENTSOC' OR R.MODC_TIPOMOV = 'ENTCOC' ) 
	AND ( MOV.MODC_TIPOMOV = 'ENTSOC' OR MOV.MODC_TIPOMOV = 'ENTCOC' ) 
	AND MOV.MOVD_FECHAAFECTACION >= trunc(
	TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
	AND MOV.MOVD_FECHAAFECTACION < trunc(
	TO_DATE( '$fecha_final', 'YYYY/MM/DD' )) + 1 
	AND r.ALMN_ALMACEN = '4' 
	AND MOV.ALMN_ALMACEN = '4' 
	AND INV.ALMN_ALMACEN = '4' 
	AND R.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	) AS costo_cantidad_surtida_all, --Fin bloque allende,
	
	--inicio bloque ventas diaz ordaz
	(
	SELECT
	SUM( DETALLE.ARTN_CANTIDAD )
	FROM
	PV_ARTICULOSTICKET detalle
	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
WHERE
	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
	AND '$fecha_fin' 
	AND TIK.TICC_SUCURSAL = '1' 
	AND DETALLE.TICC_SUCURSAL = '1' 
	AND TIK.TICN_ESTATUS = 3
	) AS cantidad_vendida_do,
	(
	SELECT
	SUM(
	ROUND( detalle.ARTN_CANTIDAD * detalle.ARTN_PRECIOVENTA, 2 )) 
FROM
	PV_ARTICULOSTICKET detalle
	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
WHERE
	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO  
	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
	AND '$fecha_fin' 
	AND TIK.TICC_SUCURSAL = '1' 
	AND DETALLE.TICC_SUCURSAL = '1' 
	AND TIK.TICN_ESTATUS = 3
	)AS importe_cantidad_vendida,
	
	--Fin bloque ventas diaz ordaz
				--inicio bloque ventas arboledas
	(
	SELECT
	SUM( DETALLE.ARTN_CANTIDAD )
	FROM
	PV_ARTICULOSTICKET detalle
	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
WHERE
	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
	AND '$fecha_fin' 
	AND TIK.TICC_SUCURSAL = '2' 
	AND DETALLE.TICC_SUCURSAL = '2' 
	AND TIK.TICN_ESTATUS = 3
	) AS cantidad_vendida_arb,
	(
	SELECT
	SUM(
	ROUND( detalle.ARTN_CANTIDAD * detalle.ARTN_PRECIOVENTA, 2 )) 
FROM
	PV_ARTICULOSTICKET detalle
	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
WHERE
	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO  
	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
	AND '$fecha_fin' 
	AND TIK.TICC_SUCURSAL = '2' 
	AND DETALLE.TICC_SUCURSAL = '2' 
	AND TIK.TICN_ESTATUS = 3
	)AS importe_cantidad_vendida_arb,
	
	--Fin bloque ventas arboledas
	
		--inicio bloque ventas villegas
	(
	SELECT
	SUM( DETALLE.ARTN_CANTIDAD )
	FROM
	PV_ARTICULOSTICKET detalle
	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
WHERE
	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
	AND '$fecha_fin' 
	AND TIK.TICC_SUCURSAL = '3' 
	AND DETALLE.TICC_SUCURSAL = '3' 
	AND TIK.TICN_ESTATUS = 3
	) AS cantidad_vendida_villegas,
	(
	SELECT
	SUM(
	ROUND( detalle.ARTN_CANTIDAD * detalle.ARTN_PRECIOVENTA, 2 )) 
FROM
	PV_ARTICULOSTICKET detalle
	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
WHERE
	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO  
	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
	AND '$fecha_fin' 
	AND TIK.TICC_SUCURSAL = '3' 
	AND DETALLE.TICC_SUCURSAL = '3' 
	AND TIK.TICN_ESTATUS = 3
	)AS importe_cantidad_vendida_v,
		
	--Fin bloque ventas villegas
			--inicio bloque ventas allende
	(
	SELECT
	SUM( DETALLE.ARTN_CANTIDAD )
	FROM
	PV_ARTICULOSTICKET detalle
	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
WHERE
	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO 
	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
	AND '$fecha_fin' 
	AND TIK.TICC_SUCURSAL = '4' 
	AND DETALLE.TICC_SUCURSAL = '4' 
	AND TIK.TICN_ESTATUS = 3
	) AS cantidad_vendida_allende,
	(
	SELECT
	SUM(
	ROUND( detalle.ARTN_CANTIDAD * detalle.ARTN_PRECIOVENTA, 2 )) 
FROM
	PV_ARTICULOSTICKET detalle
	INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA 
	AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO 
WHERE
	DETALLE.ARTC_ARTICULO = PRECIOS.ARTC_ARTICULO  
	AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i' 
	AND '$fecha_fin' 
	AND TIK.TICC_SUCURSAL = '4' 
	AND DETALLE.TICC_SUCURSAL = '4' 
	AND TIK.TICN_ESTATUS = 3
	)AS importe_cantidad_vendida_al
	
	--Fin bloque ventas allende
	FROM PV_ARTICULOS PRECIOS
	INNER JOIN COM_ARTICULOSLISTAPRECIOS ARTICULOS
	ON PRECIOS.ARTC_ARTICULO = ARTICULOS.ARTC_ARTICULO
	WHERE ARTICULOS.PROC_CVEPROVEEDOR = '$proveedor'";
//}
					
					





	//$resultado_principal=mysql_query ($consulta_principal, $conexion) or die (mysql_error());
	$stmt = oci_parse($conexion_central, $consulta_principal);
	oci_execute($stmt);



// //$registros = mysql_num_rows ($resultado_principal);
	
	
	
	/** Error reporting */
	//error_reporting(E_ALL);
	ini_set('max_execution_time', 1000); 
	ini_set('memory_limit', '-1');
	//ini_set('max_execution_time', 300); 
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');

	/** Include PHPExcel */
	require_once '../../plugins/PHPExcel/Classes/PHPExcel.php';

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// // Set document properties
	$objPHPExcel->getProperties()->setCreator("Sebastian Villarreal")
								 ->setLastModifiedBy("La Misión Supermercados")
								 ->setTitle("Reporte General de las Devoluciónes")
								 ->setSubject("Devoluciónes")
								 ->setDescription("Reporte de las Devoluciónes")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	//Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Codigo')
	            ->setCellValue('B1', 'Descripcion')
	            ->setCellValue('C1', 'Compra DO')
	            ->setCellValue('D1', 'Importe Compra DO')
	            ->setCellValue('E1', 'Venta DO')
	            ->setCellValue('F1', 'Importe venta DO')
                ->setCellValue('G1', '%Vta vs Compra')
                ->setCellValue('H1', '%Vta vs importe')
                ->setCellValue('I1', 'Existencia DO')
                ->setCellValue('J1', 'Compra Arb')
                ->setCellValue('K1', 'Importe compra arb')
                ->setCellValue('L1', 'Venta arb')
                ->setCellValue('M1', 'Importe venta arb')
                ->setCellValue('N1', '%Vta vs Compra arb')
                ->setCellValue('O1', '%Vta vs importe arb')
                ->setCellValue('P1', 'Existencia arb')
                ->setCellValue('Q1', 'Compra Vill')
                ->setCellValue('R1', 'Importe compra vill')
                ->setCellValue('S1', 'Venta vill')
                ->setCellValue('T1', 'Importe venta vill')
                ->setCellValue('U1', '%Vta vs Compra vill')
                ->setCellValue('V1', '%Vta vs importe vill')
                ->setCellValue('W1', 'Existencia vill')
                ->setCellValue('X1', 'Compra All')
                ->setCellValue('Y1', 'Importe compra All')
                ->setCellValue('Z1', 'Venta All')
                ->setCellValue('AA1', 'Importe Venta All')
                ->setCellValue('AB1', '%Vta vs compra all')
                ->setCellValue('AC1', '%Vta vs importe All')
                ->setCellValue('AD1', 'Existencia All');


	$fila = 2;
	while($row_principal = oci_fetch_row($stmt))
	{

	    	
///////////////Diaz ordaz/////////////////////////////////
		    if ($row_principal[6] == "") {
	    		$compras_do = "N/A";
	    		$importe_compras_do = "N/A";

	    	}else{
	    		$compras_do = $row_principal[6];
	    		$importe_compras_do = $row_principal[7];
	    	}
	    	if ($row_principal[14] == "") {
	    		$ventas_do = "N/A";
	    		$importe_ventas_do = "N/A";
			}else{
				$ventas_do = $row_principal[14];
				$importe_ventas_do = $row_principal[15];
			}
			if ($ventas_do == "N/A" || $compras_do == "N/A" || $importe_compras_do == 0) {
	    		$porc_cant_do = "N/A";
	    		$porc_imp_do = "N/A";
			}else{
	    		$porc_cant_do = $ventas_do / $compras_do;
	    		$porc_imp_do = $importe_ventas_do / $importe_compras_do;
			}
////////////////Arboledas///////////////////////////////////////
		    if (is_null($row_principal[8]) || is_null($row_principal[9])) {
	    		$compras_arb = "N/A";
	    		$importe_compras_arb = "N/A";

	    	}else{
	    		$compras_arb = $row_principal[8];
	    		$importe_compras_arb = $row_principal[9];
	    	}

	    	if (is_null($row_principal[16])) {
	    		$ventas_arb = "N/A";
	    		$importe_ventas_arb = "N/A";
			}else{
				$ventas_arb = $row_principal[16];
				$importe_ventas_arb = $row_principal[17];
			}
			if ($ventas_arb == "N/A" || $compras_arb == "N/A" || $importe_compras_arb == 0) {
	    		$porc_cant_arb = "N/A";
	    		$porc_imp_arb = "N/A";
			}else{
	    		$porc_cant_arb = $ventas_arb / $compras_arb;
	    		//echo "$compras_arb";
	    		$porc_imp_arb = $importe_ventas_arb / $importe_compras_arb;
	    		//echo "$importe_compras_arb";
			}
			// echo "$porc_cant_arb";
			// echo "<br>";
			// echo "$porc_imp_arb";
			//echo "$compras_arb";
//////////////////////Villegas////////////////////
		    if ($row_principal[10] == "") {
	    		$compras_vil = "N/A";
	    		$importe_compras_vil = "N/A";

	    	}else{
	    		$compras_vil = $row_principal[10];
	    		$importe_compras_vil = $row_principal[11];
	    	}
	    	if ($row_principal[18] == "") {
	    		$ventas_vil = "N/A";
	    		$importe_ventas_vil = "N/A";
			}else{
				$ventas_vil = $row_principal[18];
				$importe_ventas_vil = $row_principal[19];
			}
			if ($ventas_vil == "N/A" || $compras_vil == "N/A" || $importe_compras_vil == 0) {
	    		$porc_cant_vil = "N/A";
	    		$porc_imp_vil = "N/A";
			}else{
	    		$porc_cant_vil = $ventas_vil / $compras_vil;
	    		$porc_imp_vil = $importe_ventas_vil / $importe_compras_vil;
			}
////////////Allende////////////////
		    if ($row_principal[12] == "") {
	    		$compras_all = "N/A";
	    		$importe_compras_all = "N/A";

	    	}else{
	    		$compras_all = $row_principal[12];
	    		$importe_compras_all = $row_principal[13];
	    	}
	    	if ($row_principal[20] == "") {
	    		$ventas_all = "N/A";
	    		$importe_ventas_all = "N/A";
			}else{
				$ventas_all = $row_principal[20];
				$importe_ventas_all = $row_principal[21];
			}
			if ($ventas_all == "N/A" || $compras_all == "N/A" || $importe_compras_all == 0) {
	    		$porc_cant_all = "N/A";
	    		$porc_imp_all = "N/A";
			}else{
	    		$porc_cant_all = $ventas_all / $compras_all;
	    		$porc_imp_all = $importe_ventas_all / $importe_compras_all;
			}
					
										
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0])
	            ->setCellValue('B'.$fila, $row_principal[1])
	            ->setCellValue('C'.$fila, $compras_do)
	            ->setCellValue('D'.$fila, $importe_compras_do)
	            ->setCellValue('E'.$fila, $ventas_do)
	            ->setCellValue('F'.$fila, $importe_ventas_do);
	            
		$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G'.$fila, $porc_cant_do)//$row_ventas_DO[0] / $row_compras_DO[0])
                ->setCellValue('H'.$fila, $porc_imp_do)//$row_ventas_DO[1] / $row_compras_DO[1])
                ->setCellValue('I'.$fila, $row_principal[2])//existencias Diaz Ordaz
                ->setCellValue('J'.$fila, $compras_arb)
                ->setCellValue('K'.$fila, $importe_compras_arb)
                ->setCellValue('L'.$fila, $ventas_arb)
                ->setCellValue('M'.$fila, $importe_ventas_arb)
                ->setCellValue('N'.$fila, $porc_cant_arb)//$row_ventas_ARB[0] / $row_compras_ARB[0])
                ->setCellValue('O'.$fila, $porc_imp_arb)//$row_ventas_ARB[1] / $row_compras_ARB[1])
                ->setCellValue('P'.$fila, $row_principal[3])//Existencia Villegas
                ->setCellValue('Q'.$fila, $compras_vil)
                ->setCellValue('R'.$fila, $importe_compras_vil)
                ->setCellValue('S'.$fila, $ventas_vil)
                ->setCellValue('T'.$fila, $importe_ventas_vil)
                ->setCellValue('U'.$fila, $porc_cant_vil)//$row_ventas_VIL[0] / $row_compras_VIL[0])
                ->setCellValue('V'.$fila, $porc_imp_vil)//$row_ventas_VIL[1] / $row_compras_VIL[1])
                ->setCellValue('W'.$fila, $row_principal[4])//existencia villegas
                ->setCellValue('X'.$fila, $compras_all)
                ->setCellValue('Y'.$fila, $importe_compras_all)
                ->setCellValue('Z'.$fila, $ventas_all)
                ->setCellValue('AA'.$fila, $importe_ventas_all)
                ->setCellValue('AB'.$fila, $porc_cant_all)//$row_ventas_ALL[0] / $row_compras_ALL[0])
                ->setCellValue('AC'.$fila, $porc_imp_all)//$row_ventas_ALL[1] / $row_compras_ALL[1])
                ->setCellValue('AD'.$fila, $row_principal[5]);//existencia allende


	    $objPHPExcel->getActiveSheet()
    		->getColumnDimension('A')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('B')
    		->setAutoSize(false);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('C')
    		->setAutoSize(false);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('D')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('E')
    		->setAutoSize(true);

    	$objPHPExcel->getActiveSheet()
    		->getColumnDimension('F')
    		->setAutoSize(true);

        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('G')
        ->setAutoSize(true);

        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('H')
        ->setAutoSize(true);
        
                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('I')
        ->setAutoSize(true);
                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('J')
        ->setAutoSize(true);
                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('K')
        ->setAutoSize(true);

                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('L')
        ->setAutoSize(true);

                $objPHPExcel->getActiveSheet()
        ->getColumnDimension('M')
        ->setAutoSize(true);

        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('N')
        ->setAutoSize(true);
        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('O')
        ->setAutoSize(true);
        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('P')
        ->setAutoSize(true);

        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('Q')
        ->setAutoSize(true);

        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('R')
        ->setAutoSize(true);

        $objPHPExcel->getActiveSheet()
        ->getColumnDimension('S')
        ->setAutoSize(true);        
	$fila = $fila + 1;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Detalle de compras');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="compras_vs_ventas" '.$fecha.' ".xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
?>
