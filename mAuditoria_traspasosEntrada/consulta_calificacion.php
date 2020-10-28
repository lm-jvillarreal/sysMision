<?php
include "../global_settings/conexion_oracle.php";
include "../global_seguridad/verificar_sesion.php";

//Fecha y hora actual
  date_default_timezone_set('America/Monterrey');
  $fecha=date("Y-m-d"); 
  $hora=date ("h:i:s");

$fecha_inicio = (!isset($_POST['fecha_inicial'])) ? $fecha : $_POST['fecha_inicial'];
$fecha_fin = (!isset($_POST['fecha_final'])) ? $fecha : $_POST['fecha_final'];
$filtro_sucursal = ($_POST['sucursal']=="") ? "" : " AND ALMN_ALMACEN ='".$_POST['sucursal']."'";
$filtro_suc = ($_POST['sucursal']=="") ? "" : " AND sucursal ='".$_POST['sucursal']."'";

$cadena_recibidos = "SELECT
						COUNT(*)
					FROM
						INV_TRANSFERENCIAS 
					WHERE
						TRAD_FECHA_AUT_ENTRADA >= trunc(
						TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
						AND TRAD_FECHA_AUT_ENTRADA < trunc(
						TO_DATE( '$fecha_fin', 'YYYY/MM/DD' )) + 1 
				        ".$filtro_sucursal." ORDER BY TRAD_FECHA_AUT_ENTRADA ASC";

$consulta_recibidos = oci_parse($conexion_central, $cadena_recibidos);
					  oci_execute($consulta_recibidos);
$row_recibidos = oci_fetch_row($consulta_recibidos);

$cadena_pendientes =	"SELECT
							COUNT(*)
						FROM
							INV_TRANSFERENCIAS 
						WHERE
							TRAD_FECHA_CAPTURA >= trunc(
							TO_DATE( '$fecha_inicio', 'YYYY/MM/DD' )) 
							AND TRAD_FECHA_CAPTURA < trunc(
							TO_DATE( '$fecha_fin', 'YYYY/MM/DD' )) + 1 
							AND MODN_FOLIO IS NULL AND ( TRAN_ESTATUS = '1' OR TRAN_ESTATUS='2')".$filtro_sucursal." ORDER BY TRAD_FECHA_CAPTURA ASC";
$consulta_pendientes =  oci_parse($conexion_central, $cadena_pendientes);
						oci_execute($consulta_pendientes);
$row_pendientes = oci_fetch_row($consulta_pendientes);

$cadena_promedio = "SELECT AVG(calificacion) 
					FROM calificacion_traspasos 
					WHERE fecha_calificacion 
					BETWEEN '$fecha_inicio' AND '$fecha_fin'".$filtro_suc;
//echo $cadena_promedio;
$consulta_promedio = mysqli_query($conexion, $cadena_promedio);
$row_promedio = mysqli_fetch_array($consulta_promedio);
$promedio = round($row_promedio[0],2);

$recibidos = $row_recibidos[0];
$pendientes = $row_pendientes[0];
if($recibidos==0 || $pendientes==0){
	$total = 0;
	$calificacion = '0'.'% de efectividad';
	$barra_progreso = '0'.'%';
	$calif_negativa = 0;
	$calificacion_negativa = $calif_negativa.'% de oportunidad de mejora';
	$barra_negativa = '0'.'%';
	$calificacion_real = 0;
}else{
	$total = $row_recibidos[0] + $row_pendientes[0];
	$calificacion = ROUND((100*$recibidos)/$total,2).'% de efectividad';
	$barra_progreso = ROUND((100*$recibidos)/$total,0).'%';
	$calif_negativa = ROUND(100-(ROUND((100*$recibidos)/$total,2)),2);
	$calificacion_negativa = $calif_negativa.'% de oportunidad de mejora';
	$barra_negativa = ROUND($calif_negativa).'%';
	$calificacion_real = ROUND((100*$recibidos)/$total,2);
}

$array = array(
	$recibidos,
	$pendientes,
	$calificacion,
	$barra_progreso,
	$calificacion_negativa,
	$barra_negativa,
	$calificacion_real,
	$promedio
);
$array_folio = json_encode($array);
echo "$array_folio";
?>