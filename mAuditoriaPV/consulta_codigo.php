<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$codigo = $_POST['codigo'];

date_default_timezone_set("America/Monterrey");
$fecha = date("Y-m-d");
$fecha_f = str_replace("-","",$fecha);
//$sucursal = $_POST['suc'];

$cadenaPrincipal = "SELECT
										INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
										INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
										INV_ARTICULOS_DETALLE.ARTN_ULTIMOPRECIO,
										familias.FAMC_DESCRIPCION AS Familia,
										(SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE ) AS Departamento,
										(SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '$id_sede', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Existencia,
										ROUND( INV_ARTICULOS_DETALLE.ARTN_COSTO_PROMEDIO, 2) AS C_PROM,
										(SELECT AREN_CANTIDAD FROM INV_ARTICULOS_EMPAQUE WHERE ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM = 1) AS U_EMP
										FROM
										INV_ARTICULOS_DETALLE
										INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
										WHERE INV_ARTICULOS_DETALLE.ARTC_ARTICULO = '$codigo'";

$consultaPrincipal = oci_parse($conexion_central,$cadenaPrincipal);
oci_execute($consultaPrincipal);
$row_articulo = oci_fetch_row($consultaPrincipal);

$conteo = count($row_articulo);
if ($conteo==0) {
	echo "no_existe";
}else{

$cadena_ue = "SELECT * FROM (SELECT
								detalle.MODN_FOLIO,
								TO_CHAR(movs.MOVD_FECHAAFECTACION, 'DD/MM/YYYY'),
								detalle.modc_tipomov,
								detalle.RMON_CANTSURTIDA,
								detalle.RMOC_UNIMEDIDA,
								(SELECT CONCAT(PROC_CVEPROVEEDOR,PROC_NOMBRE) FROM cxp_proveedores WHERE TRIM(PROC_CVEPROVEEDOR) = TRIM(movs.MOVC_CVEPROVEEDOR)) AS Proveedor,
								TO_CHAR(movs.MOVD_FECHAAFECTACION, 'YYYY-MM-DD')
								FROM
								INV_RENGLONES_MOVIMIENTOS detalle
								INNER JOIN INV_MOVIMIENTOS movs ON movs.ALMN_ALMACEN = detalle.ALMN_ALMACEN 
								AND detalle.MODN_FOLIO = movs.MODN_FOLIO 
								AND movs.MODC_TIPOMOV = detalle.MODC_TIPOMOV 
								WHERE
								ARTC_ARTICULO = '$codigo' 
								AND movs.ALMN_ALMACEN = '$id_sede' 
								AND detalle.ALMN_ALMACEN = '$id_sede'
								AND movs.MOVD_FECHAAFECTACION IS NOT NULL
								AND ( detalle.MODC_TIPOMOV = 'ENTSOC' OR detalle.MODC_TIPOMOV = 'ENTCOC' OR detalle.MODC_TIPOMOV = 'ETRANS')
								ORDER BY
								movs.MOVD_FECHAAFECTACION DESC)
							WHERE ROWNUM <=1";

$st = oci_parse($conexion_central, $cadena_ue);
oci_execute($st);
$row_ue = oci_fetch_row($st);

$fecha_i = str_replace("-","",$row_ue[6]);
$cadenaVentas = "SELECT
									SUM (DETALLE.ARTN_CANTIDAD)
								FROM
									PV_ARTICULOSTICKET detalle
								INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
								AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
								WHERE
									DETALLE.ARTC_ARTICULO = '$codigo'
								AND TIK.ticn_aaaammddventa BETWEEN '$fecha_i'
								AND '$fecha_f'
								AND TIK.TICC_SUCURSAL = '$id_sede'
								AND DETALLE.TICC_SUCURSAL = '$id_sede'
								AND TIK.TICN_ESTATUS = 3";
$consultaVentas = oci_parse($conexion_central, $cadenaVentas);
oci_execute($consultaVentas);
$row_ventas = oci_fetch_row($consultaVentas);

$faltante = $row_ventas[0] - $row_articulo[5];

if($faltante == 0 || $row_articulo[7]==""){
	$fue = 0;
}elseif($faltante < 0){
	$faltante_ue=($faltante * -1)/$row_articulo[7];
	$fue = ceil($faltante_ue);
	$fue = $fue * -1;
}else{
	$faltante_ue=($faltante)/$row_articulo[7];
	$fue = ceil($faltante_ue);
}

$f_inicio = new DateTime($row_ue[6]);
$f_fin = new DateTime($fecha);
$diff = $f_inicio->diff($f_fin);
$dias = $diff->days;
$dias = $dias +1;

if(empty($row_ventas[0])){
	$dias_inventario="";
	$mes_inventario = "";
}else{
	$dias_inventario = $row_articulo[5]/($row_ventas[0]/$dias);//existencias/(ventas/dias)
	$dias_inventario = ROUND($dias_inventario);
	$mes_inventario = $dias_inventario/30;
	$mes_inventario = round($mes_inventario,2);
}

$array = array(
	$row_articulo[1], //Descripcion
	$row_articulo[5], //Existencia
	$row_ue[1], //Fecha de UE
	$row_ue[2], //Tipo de movimiento
	$row_ue[0], //Folio de movimiento
	$row_ue[3], //Cantidad surtida
	$row_ue[5], //Proveedor
	$row_articulo[4], //Depto
	$row_articulo[3], //Familia
	$row_articulo[2], //ultimo precio
	$row_articulo[7], //U empaque
	$row_ventas[0], //Ventas
	$row_articulo[5], //Existencia
	$faltante, //Unidades faltantes
	$fue,				//Faltante en cajas
	$dias_inventario, //dias de inventario
	$mes_inventario //mes inventario
);
$array_datos = json_encode($array);
echo $array_datos;
}
?>