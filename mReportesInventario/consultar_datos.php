<?php 
	include '../global_settings/conexion_oracle.php';
	include '../global_settings/conexion.php';
	$sucursal = 1;
	$movimiento = $_POST['tipo_movimiento'];
	$folio = $_POST['folio'];
	$sql = "SELECT
				SUM( CASE WHEN RMOC_CVEIVA = 'IVACOM' THEN ( RMON_COSTO_RENGLON_MB * 1.16 ) WHEN RMOC_CVEIEPS = 'IEPSG' THEN ( RMON_COSTO_RENGLON_MB * 1.08 ) ELSE RMON_COSTO_RENGLON_MB END ) AS TOTAL,
				(
			SELECT
				ROUND( SUM( CASE WHEN RMOC_CVEIVA = 'IVACOM' THEN ( RMON_COSTO_RENGLON_MB * 0.16 ) END ), 2 ) 
			FROM
				INV_RENGLONES_MOVIMIENTOS 
			WHERE
				ALMN_ALMACEN = '$sucursal' 
				AND MODC_TIPOMOV = '$movimiento' 
				AND MODN_FOLIO = '$folio' 
				),
				(
			SELECT
				ROUND( SUM( CASE WHEN RMOC_CVEIEPS = 'IEPSG' THEN ( RMON_COSTO_RENGLON_MB * 0.08 ) END ), 2 ) AS IEPS 
			FROM
				INV_RENGLONES_MOVIMIENTOS 
			WHERE
				ALMN_ALMACEN = '$sucursal' 
				AND MODC_TIPOMOV = '$movimiento' 
				AND MODN_FOLIO = '$folio' 
				),
				SUM( RMON_COSTO_RENGLON_MB ) 
			FROM
				INV_RENGLONES_MOVIMIENTOS 
			WHERE
				ALMN_ALMACEN = '$sucursal' 
				AND MODC_TIPOMOV = '$movimiento' 
				AND MODN_FOLIO = '$folio' 
			GROUP BY
				1";
	$st = oci_parse($conexion_central, $sql);
	oci_execute($st);
	$row = oci_fetch_row($st);
	$sql_notas = "SELECT diferencia FROM notas_entrada WHERE folio_mov = '$folio' AND tipo_mov = '$movimiento'";
		$exS = mysqli_query($conexion, $sql_notas);
	$row_n = mysqli_fetch_row($exS);
	$array = array(
		$row[0],
		$row_n[0]
	);
	echo json_encode($array);
 ?>