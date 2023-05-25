<?php 
include("../../global_settings/conexion.php");
include("../../global_settings/conexion_oracle.php");
error_reporting(E_ALL^E_NOTICE);
//include("conexion.php");
date_default_timezone_set('America/Monterrey');
$fecha = date('Y-m-d');
$hora = date('H:i:s');

$faltante_total = 0;
$sobrante_total = 0;
$date1 = date_create($_POST['fecha_inicial']);
$date2 = date_create($_POST['fecha_final']);
$almacen = $_POST['sucursal_OPE012'];
$fechauno = date_format($date1, 'd-m-Y');
$fechados = date_format($date2, 'd-m-Y');
	$fechaaamostar = $fechauno;
	$truncate = "TRUNCATE sobrantes_faltantes";
	$exTr = mysqli_query($conexion, $truncate);
	while(strtotime($fechados) >= strtotime($fechauno))
	{
		if(strtotime($fechados) != strtotime($fechaaamostar))
		{
			$qry = "SELECT
				PV_ACUMULADOS.CCAC_CAJERO,
				(
					SUM (
						PV_ACUMULADOS.ACUN_MONTOVENTA
					) - SUM (
						PV_ACUMULADOS.ACUN_CASHBACK
					)
				) AS NETO,
				SUM(PV_ACUMULADOS.ACUN_TOTALCAPTURADO) CAPTURADO,
				CFG_USUARIOS.USUC_NOMBRE,
				CFG_USUARIOS.USUC_EMAIL
			FROM
				PV_ACUMULADOS
			INNER JOIN PV_CORTEDECAJA ON PV_CORTEDECAJA.CCAC_CAJERO = PV_ACUMULADOS.CCAC_CAJERO
			AND PV_CORTEDECAJA.CCAC_SUCURSAL = PV_ACUMULADOS.CCAC_SUCURSAL
			AND PV_CORTEDECAJA.CCAN_CONSECORTE = PV_ACUMULADOS.CCAN_CONSECORTE
			INNER JOIN CFG_USUARIOS ON CFG_USUARIOS.USUN_ID = PV_ACUMULADOS.CCAC_CAJERO
			WHERE CAAD_FECHAHORACORTE >= TRUNC (
				TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
			)
			AND CAAD_FECHAHORACORTE < TRUNC (
				TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
			) + 1
			AND PV_ACUMULADOS.CCAC_SUCURSAL = '$almacen'
			AND PV_ACUMULADOS.ACUN_CVECOBRODEV = '1'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-DO'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-DO'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-DO'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-ARB'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-ARB'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-ARB'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CREDITO'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PELECT'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PELEC-ESP'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-ALL'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-ALL'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-ALL'
			GROUP BY
			PV_ACUMULADOS.CCAC_CAJERO,
				CFG_USUARIOS.USUC_NOMBRE,
				CFG_USUARIOS.USUC_EMAIL
			ORDER BY
				PV_ACUMULADOS.CCAC_CAJERO";
			$st = oci_parse($conexion_central, $qry);
			oci_execute($st);
			//echo "$fechaaamostar<br />";
			
			while ($row = oci_fetch_row($st)) {
				$qry_dev = "SELECT
							ACUMU.CCAC_CAJERO,
							SUM (ACUMU.ACUN_MONTOVENTA)
							
						FROM
							PV_ACUMULADOS ACUMU
						INNER JOIN PV_CORTEDECAJA CORTE ON CORTE.CCAC_CAJERO = ACUMU.CCAC_CAJERO
						AND CORTE.CCAC_SUCURSAL = ACUMU.CCAC_SUCURSAL
						AND CORTE.CCAN_CONSECORTE = ACUMU.CCAN_CONSECORTE
						WHERE
							ACUMU.ACUC_FORMADEPAGO = '1EFE'
						AND CAAD_FECHAHORACORTE >= TRUNC (
							TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
						)
						AND CAAD_FECHAHORACORTE < TRUNC (
							TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
						) + 1
						AND ACUMU.CCAC_SUCURSAL = '$almacen'
						AND ACUMU.ACUN_CVECOBRODEV = '-1'
						AND ACUMU.CCAC_CAJERO = '$row[0]'
						GROUP BY
							ACUMU.CCAC_CAJERO
						ORDER BY
							ACUMU.CCAC_CAJERO";
				$st_dev = oci_parse($conexion_central, $qry_dev);
				oci_execute($st_dev);
				$row_dev = oci_fetch_row($st_dev);
				$neto_real = $row[1] - $row_dev[1];
				$total = $neto_real - $row[2];
				$total = round($total, 2);

				if ($total < 0) {
					$sobrante_total = $total;
					$sobrante_total = abs($sobrante_total);
				}else{
					$faltante_total = $total;
					$faltante_total = abs($total);
				}
				$insert = "INSERT INTO sobrantes_faltantes (
								fecha,
								sobrante,
								faltante,
								cajero,
								nombre_cajero,
								num_empleado
							)
							VALUES
								('$fechaaamostar', '$sobrante_total', '$faltante_total', '$row[0]', '$row[3]', '$row[4]')";
				$exInsert = mysqli_query($conexion, $insert);
				$faltante_total = 0;
				$sobrante_total = 0;
			}
			$fechaaamostar = date("d-m-Y", strtotime($fechaaamostar . " + 1 day"));
		}
		else
		{

			$qry = "SELECT
				PV_ACUMULADOS.CCAC_CAJERO,
				(
					SUM (
						PV_ACUMULADOS.ACUN_MONTOVENTA
					) - SUM (
						PV_ACUMULADOS.ACUN_CASHBACK
					)
				) AS NETO,
				SUM(PV_ACUMULADOS.ACUN_TOTALCAPTURADO) CAPTURADO,
				CFG_USUARIOS.USUC_NOMBRE,
				CFG_USUARIOS.USUC_EMAIL
			FROM
				PV_ACUMULADOS
			INNER JOIN PV_CORTEDECAJA ON PV_CORTEDECAJA.CCAC_CAJERO = PV_ACUMULADOS.CCAC_CAJERO
			AND PV_CORTEDECAJA.CCAC_SUCURSAL = PV_ACUMULADOS.CCAC_SUCURSAL
			AND PV_CORTEDECAJA.CCAN_CONSECORTE = PV_ACUMULADOS.CCAN_CONSECORTE
			INNER JOIN CFG_USUARIOS ON CFG_USUARIOS.USUN_ID = PV_ACUMULADOS.CCAC_CAJERO
			WHERE CAAD_FECHAHORACORTE >= TRUNC (
				TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
			)
			AND CAAD_FECHAHORACORTE < TRUNC (
				TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
			) + 1
			AND PV_ACUMULADOS.CCAC_SUCURSAL = '$almacen'
			AND PV_ACUMULADOS.ACUN_CVECOBRODEV = '1'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-DO'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-DO'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-DO'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-ARB'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-ARB'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-ARB'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CREDITO'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PELECT'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PELEC-ESP'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '5CRE-ALL'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '2PE-ALL'
			AND PV_ACUMULADOS.ACUC_FORMADEPAGO <> '3PEE-ALL'
			GROUP BY
			PV_ACUMULADOS.CCAC_CAJERO,
				CFG_USUARIOS.USUC_NOMBRE,
				CFG_USUARIOS.USUC_EMAIL
			ORDER BY
				PV_ACUMULADOS.CCAC_CAJERO";
		$st = oci_parse($conexion_central, $qry);
		oci_execute($st);
			while ($row = oci_fetch_row($st)) {
				$qry_dev = "SELECT
							ACUMU.CCAC_CAJERO,
							SUM (ACUMU.ACUN_MONTOVENTA)
						FROM
							PV_ACUMULADOS ACUMU
						INNER JOIN PV_CORTEDECAJA CORTE ON CORTE.CCAC_CAJERO = ACUMU.CCAC_CAJERO
						AND CORTE.CCAC_SUCURSAL = ACUMU.CCAC_SUCURSAL
						AND CORTE.CCAN_CONSECORTE = ACUMU.CCAN_CONSECORTE
						WHERE
							ACUMU.ACUC_FORMADEPAGO = '1EFE'
						AND CAAD_FECHAHORACORTE >= TRUNC (
							TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
						)
						AND CAAD_FECHAHORACORTE < TRUNC (
							TO_DATE ('$fechaaamostar', 'DD/MM/YYYY')
						) + 1
						AND ACUMU.CCAC_SUCURSAL = '$almacen'
						AND ACUMU.ACUN_CVECOBRODEV = '-1'
						AND ACUMU.CCAC_CAJERO = '$row[0]'
						GROUP BY
							ACUMU.CCAC_CAJERO
						ORDER BY
							ACUMU.CCAC_CAJERO";
				$st_dev = oci_parse($conexion_central, $qry_dev);
				oci_execute($st_dev);
				$row_dev = oci_fetch_row($st_dev);
				$neto_real = $row[1] - $row_dev[1];
				$total = $neto_real - $row[2];
				$total = round($total, 2);

				if ($total < 0) {
					$sobrante_total = $total;
					$sobrante_total = abs($sobrante_total);
				}else{
					$faltante_total = $total;
					$faltante_total = abs($total);
				}

				$insert = "INSERT INTO sobrantes_faltantes (
								fecha,
								sobrante,
								faltante,
								cajero,
								nombre_cajero,
								num_empleado
							)
							VALUES
								('$fechaaamostar', '$sobrante_total', '$faltante_total', '$row[0]', '$row[3]', '$row[4]')";
				$exInsert = mysqli_query($conexion, $insert);
				$faltante_total = 0;
				$sobrante_total = 0;
			}

			//echo "$fechaaamostar<br />";
			break;
		}
	}

	$qry_sql = "SELECT
					cajero,
					nombre_cajero,
					ROUND(SUM(sobrante),2),
					ROUND(SUM(faltante),2),
					num_empleado
				FROM
					sobrantes_faltantes
				GROUP BY
					cajero";
	$exQry_sql = mysqli_query($conexion, $qry_sql);

	/** Error reporting */
	//error_reporting(E_ALL);
	ini_set('max_execution_time', 1000); 
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
								 ->setSubject("Analisis")
								 ->setDescription("Reporte de analisis")
								 ->setKeywords("office PHPExcel php")
								 ->setCategory("Reportes");


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Cajero')
	            ->setCellValue('B1', 'Nombre Cajero')
	            ->setCellValue('C1', '# empleado')
	            ->setCellValue('D1', 'Sobrante Total')
	            ->setCellValue('E1', 'Faltante Total');


	$fila = 2;
	while($row_principal = mysqli_fetch_row($exQry_sql))
	{

	
		 $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$fila, $row_principal[0]);
				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('B'.$fila, $row_principal[1])
	            ->setCellValue('C'.$fila, $row_principal[4])	            
	            ->setCellValue('D'.$fila, $row_principal[2])
	            ->setCellValue('E'.$fila, $row_principal[3]);

	  
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
    		$fila++;
	}
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Faltantes y sobrantes');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Faltantes_Y_Sobrantes_'.$fecha.' .xlsx"');
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
