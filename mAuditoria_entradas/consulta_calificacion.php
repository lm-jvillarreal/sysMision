<?php
include "../global_settings/conexion_oracle.php";

//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$fecha_inicio = (!isset($_POST['fecha_inicial'])) ? $fecha : $_POST['fecha_inicial'];
$fecha_fin = (!isset($_POST['fecha_final'])) ? $fecha : $_POST['fecha_final'];

//CALIFICACIÓN DÍAZ ORDAZ /////
$cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
						WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
						AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND movd_fechaafectacion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
						AND ALMN_ALMACEN = '1'
						ORDER BY modn_folio ASC";

$consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
					  oci_execute($consulta_afectados);
$row_afectados = oci_fetch_row($consulta_afectados);


$cadena_pendientes = "SELECT COUNT(*)
				        FROM INV_MOVIMIENTOS
				        WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
				        AND movd_fechaafectacion IS NULL
				        AND movd_fechaelaboracion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
				        AND movd_fechaelaboracion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
				        AND almn_almacen = '1'";

$consulta_pendientes = oci_parse($conexion_central, $cadena_pendientes);
					   oci_execute($consulta_pendientes);
$row_pendientes = oci_fetch_row($consulta_pendientes);

$pendientes_do = $row_pendientes[0];
$afectados_do = $row_afectados[0];

$total_do = $pendientes_do + $afectados_do;
$calculo_do = ROUND((100*$afectados_do)/$total_do,2);
$calificacion_do = $calculo_do."% de efectividad";
$bp_do = ROUND($calculo_do,0)."%";

//CALIFICACIÓN ARBOLEDAs
$cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
						WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
						AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND movd_fechaafectacion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
						AND ALMN_ALMACEN = '2'
						ORDER BY modn_folio ASC";

$consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
					  oci_execute($consulta_afectados);
$row_afectados = oci_fetch_row($consulta_afectados);


$cadena_pendientes = "SELECT COUNT(*)
				        FROM INV_MOVIMIENTOS
				        WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
				        AND movd_fechaafectacion IS NULL
				        AND movd_fechaelaboracion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
				        AND movd_fechaelaboracion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
				        AND almn_almacen = '2'";

$consulta_pendientes = oci_parse($conexion_central, $cadena_pendientes);
					   oci_execute($consulta_pendientes);
$row_pendientes = oci_fetch_row($consulta_pendientes);

$pendientes_ar = $row_pendientes[0];
$afectados_ar = $row_afectados[0];

$total_ar = $pendientes_ar + $afectados_ar;
$calculo_ar = ROUND((100*$afectados_ar)/$total_ar,2);
$calificacion_ar = $calculo_ar."% de efectividad";
$bp_ar = ROUND($calculo_ar,0)."%";

//CALIFICACIÓN VILLEGAS
$cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
						WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
						AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND movd_fechaafectacion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
						AND ALMN_ALMACEN = '3'
						ORDER BY modn_folio ASC";

$consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
					  oci_execute($consulta_afectados);
$row_afectados = oci_fetch_row($consulta_afectados);


$cadena_pendientes = "SELECT COUNT(*)
				        FROM INV_MOVIMIENTOS
				        WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
				        AND movd_fechaafectacion IS NULL
				        AND movd_fechaelaboracion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
				        AND movd_fechaelaboracion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
				        AND almn_almacen = '3'";

$consulta_pendientes = oci_parse($conexion_central, $cadena_pendientes);
					   oci_execute($consulta_pendientes);
$row_pendientes = oci_fetch_row($consulta_pendientes);

$pendientes_vi = $row_pendientes[0];
$afectados_vi = $row_afectados[0];

$total_vi = $pendientes_vi + $afectados_vi;
$calculo_vi = ROUND((100*$afectados_vi)/$total_vi,2);
$calificacion_vi = $calculo_vi."% de efectividad";
$bp_vi = ROUND($calculo_vi,0)."%";

//CALIFICACION ALLENDE
$cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
						WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
						AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND movd_fechaafectacion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
						AND ALMN_ALMACEN = '4'
						ORDER BY modn_folio ASC";

$consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
					  oci_execute($consulta_afectados);
$row_afectados = oci_fetch_row($consulta_afectados);


$cadena_pendientes = "SELECT COUNT(*)
				        FROM INV_MOVIMIENTOS
				        WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
				        AND movd_fechaafectacion IS NULL
				        AND movd_fechaelaboracion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
				        AND movd_fechaelaboracion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
				        AND almn_almacen = '4'";

$consulta_pendientes = oci_parse($conexion_central, $cadena_pendientes);
					   oci_execute($consulta_pendientes);
$row_pendientes = oci_fetch_row($consulta_pendientes);

$pendientes_all = $row_pendientes[0];
$afectados_all = $row_afectados[0];

$total_all = $pendientes_all + $afectados_all;
$calculo_all = ROUND((100*$afectados_all)/$total_all,2);
$calificacion_all = $calculo_all."% de efectividad";
$bp_all = ROUND($calculo_all,0)."%";

//CALIFICACIÓN LA PETACA
$cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
						WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
						AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND movd_fechaafectacion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
						AND ALMN_ALMACEN = '5'
						ORDER BY modn_folio ASC";

$consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
					  oci_execute($consulta_afectados);
$row_afectados = oci_fetch_row($consulta_afectados);


$cadena_pendientes = "SELECT COUNT(*)
				        FROM INV_MOVIMIENTOS
				        WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
				        AND movd_fechaafectacion IS NULL
				        AND movd_fechaelaboracion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
				        AND movd_fechaelaboracion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
				        AND almn_almacen = '5'";

$consulta_pendientes = oci_parse($conexion_central, $cadena_pendientes);
					   oci_execute($consulta_pendientes);
$row_pendientes = oci_fetch_row($consulta_pendientes);

$pendientes_lp = $row_pendientes[0];
$afectados_lp = $row_afectados[0];

$total_lp = $pendientes_lp + $afectados_lp;
$calculo_lp = ROUND((100*$afectados_lp)/$total_lp,2);
$calificacion_lp = $calculo_lp."% de efectividad";
$bp_lp = ROUND($calculo_lp,0)."%";

//CALIFICACIÓN CEDIS
$cadena_afectados = "SELECT COUNT(*) FROM INV_MOVIMIENTOS
						WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
						AND movd_fechaafectacion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
						AND movd_fechaafectacion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
						AND ALMN_ALMACEN = '99'
						ORDER BY modn_folio ASC";

$consulta_afectados = oci_parse($conexion_central, $cadena_afectados);
					  oci_execute($consulta_afectados);
$row_afectados = oci_fetch_row($consulta_afectados);

$cadena_pendientes = "SELECT COUNT(*)
				        FROM INV_MOVIMIENTOS
				        WHERE (modc_tipomov = 'ENTSOC' OR modc_tipomov = 'ENTCOC')
				        AND movd_fechaafectacion IS NULL
				        AND movd_fechaelaboracion >= trunc(TO_DATE ('$fecha_inicio', 'YYYY/MM/DD'))
				        AND movd_fechaelaboracion < trunc(TO_DATE ('$fecha_fin', 'YYYY/MM/DD'))+1
				        AND almn_almacen = '99'";

$consulta_pendientes = oci_parse($conexion_central, $cadena_pendientes);
					   oci_execute($consulta_pendientes);
$row_pendientes = oci_fetch_row($consulta_pendientes);

$pendientes_cedis = $row_pendientes[0];
$afectados_cedis = $row_afectados[0];

$total_cedis = $pendientes_cedis + $afectados_cedis;
$calculo_cedis = ROUND((100*$afectados_cedis)/$total_cedis,2);
$calificacion_cedis = $calculo_cedis."% de efectividad";
$bp_cedis = ROUND($calculo_cedis,0)."%";

$array = array(
	$afectados_do,
	$calificacion_do,
	$bp_do,
	$afectados_ar,
	$calificacion_ar,
	$bp_ar,
	$afectados_vi,
	$calificacion_vi,
	$bp_vi,
	$afectados_all,
	$calificacion_all,
	$bp_all,
	$afectados_lp,
	$calificacion_lp,
	$bp_lp,
	$afectados_cedis,
	$calificacion_cedis,
	$bp_cedis
	);

$array_folio = json_encode($array);
echo "$array_folio";
?>