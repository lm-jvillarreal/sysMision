<?php 
    error_reporting(E_ALL ^ E_NOTICE);
    include '../global_settings/conexion_oracle.php';
    include '../global_settings/conexion_supsys.php';
    session_name("login_supsys"); 
    session_start();
    date_default_timezone_set("America/Monterrey");
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

    $movimiento = $_POST['movimiento'];
    $sucursal = $_POST['sucursal'];
    $folio = $_POST['folio'];

    $select = "SELECT SUM(
					CASE
				WHEN RMOC_CVEIVA = 'IVACOM' THEN
						(RMON_COSTO_RENGLON_MB * 1.16)
				WHEN RMOC_CVEIEPS = 'IEPSG' THEN
					(RMON_COSTO_RENGLON_MB * 1.08)
					ELSE RMON_COSTO_RENGLON_MB
					END) AS TOTAL,
					(
					SELECT
					ROUND(SUM( CASE WHEN RMOC_CVEIVA = 'IVACOM' THEN ( RMON_COSTO_RENGLON_MB * 0.16 ) END ),2)
				FROM
					INV_RENGLONES_MOVIMIENTOS
				WHERE
					ALMN_ALMACEN = '$sucursal' 
					AND MODC_TIPOMOV = '$movimiento' 
					AND MODN_FOLIO = '$folio'),
					(
						SELECT
					ROUND(SUM( CASE WHEN RMOC_CVEIEPS = 'IEPSG' THEN ( RMON_COSTO_RENGLON_MB * 0.08 ) END ),2) AS IEPS
				FROM
					INV_RENGLONES_MOVIMIENTOS 
				WHERE
					ALMN_ALMACEN = '$sucursal' 
					AND MODC_TIPOMOV = '$movimiento' 
					AND MODN_FOLIO = '$folio'
					),
					SUM(RMON_COSTO_RENGLON_MB)
				FROM
					INV_RENGLONES_MOVIMIENTOS
				WHERE
					ALMN_ALMACEN = '$sucursal'
				AND MODC_TIPOMOV = '$movimiento'
				AND MODN_FOLIO = '$folio'
				GROUP BY 1";
				//echo "$select";

	$st = oci_parse($conexion_central, $select);
	oci_execute($st);
	$row = oci_fetch_row($st);
	$total = $row[0];
	$sub_total = $row[3];
	$iva = $row[1];
	$ieps = $row[2];



	$array = array(
					$total,
					$sub_total, 
					$iva,
					$ieps
				);
	$array_datos = json_encode($array);
	echo "$array_datos";


 ?>